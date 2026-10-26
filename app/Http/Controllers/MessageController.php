<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Response;
use Carbon\Carbon;


use App\Models\Message;

class MessageController extends Controller
{
    //
	
	public function index(Request $request){
		
		$status=$request->input('status');
		
		if ($status != ""){
			$messages=Message::where('status', $status)->orderBy('slideorder', 'asc')->get();
		}
		else $messages=Message::orderBy('slideorder', 'asc')->get();
		return view('messages.messagelist', ['messages' => $messages, 'status'=>$status]);
	}
	

	
	public function edit(Message $message){
		
		
		return view('messages.editmessage', compact('message'));
	}
	
	public function create(){
		return view('messages.addmessage', ['message' => new Message]);
	}
	
	public function store(Request $request){
		
		
		$requestdata = $request->all();
		
		
		
		
		if ($requestdata['uptime'] != ''){
			$requestdata['uptime'] = carbon::createFromFormat('YmdHi', date('YmdHi', strtotime($requestdata['uptime'])));
		}
		
		if ($requestdata['downtime'] != ''){
			$requestdata['downtime'] = carbon::createFromFormat('YmdHi', date('YmdHi', strtotime($requestdata['downtime'])));
		}
		
		$message=Message::create($requestdata);
		
		if ($request->uploadphoto) {
		    //
			$fpath=$request->uploadphoto->store('slides', 'public');
			// dd($fpath);
			$message->assetpath=$fpath;
			$message->save();
			
		}		
		return redirect('/messages');
	}
	
	public function update(Request $request, Message $message){
		
		$requestdata = $request->all();
		
		
		if ($requestdata['uptime'] != ''){
			$requestdata['uptime'] = carbon::createFromFormat('YmdHi', date('YmdHi', strtotime($requestdata['uptime'])));
		}
		
		if ($requestdata['downtime'] != ''){
			$requestdata['downtime'] = carbon::createFromFormat('YmdHi', date('YmdHi', strtotime($requestdata['downtime'])));
		}
		
		$message->update($requestdata);
			
		
		
		if ($request->uploadphoto) {
		    
			
			$fpath=$request->uploadphoto->store('slides', 'public');
			$message->assetpath=$fpath;
			
			
		}		
		
		$message->save();
		
		
		
		
		return redirect('/messages');
	}
	
	public function destroy(Message $message){
		if($message->assetpath){
			// dd($message->assetpath);
			
			Storage::disk('public')->delete($message->assetpath);
		}
		
		$message->delete();
		return redirect('/messages');
	}
	
	public function getactive(){
		$messages=Message::where('status', 1)->get();
		$res=array();
		$data=array();
		$data['activeids']=$this->getactiveids()->toArray();
		if (count($messages)){
			foreach($messages as $message){
				
				if ($message->assetpath) $message->assetpath=asset('storage/'.$message->assetpath);
				array_push($res, $message);
			}
		}
		
		$data['messages']=$messages->toArray();
		return Response::json([
			'data' => $data,
		], 200);
	}
	
	public function getchanged(Request $request){
		$data = $this->getchanged_data($request);
		return Response::json([
			'data' => $data,
		], 200);
	}

	public function getchanged_data(Request $request){
		// $request=new Request();
		
		
		$startdate=$request->input('startdate');
		
		if ($startdate == "") $startdate="0000-00-00";
		
		$messages=Message::where('updated_at', '>', $startdate)
			->where('status', '=', 1)
			->where(function ($query){
				$query->whereNull('uptime')
				->orWhere('uptime', '<=', Carbon::now());
			})
			->where(function ($query){
				$query->whereNull('downtime')
				->orWhere('downtime', '>=', Carbon::now());
			})
				->orderBy('slideorder', 'asc')
			->get();
		$res=array();
		$data=array();
		$data['activeids']=$this->getactiveids()->toArray();
		if (count($messages)){
			foreach($messages as $message){
				
				if ($message->assetpath) $message->assetpath=asset('storage/'.$message->assetpath);
				array_push($res, $message);
			}
		}
		
		$data['messages']=$messages->toArray();
		return $data;
	}
	
	private function getactiveids(){
		return Message::select('id')->where('status', 1)
		->where(function ($query){
			$query->whereNull('uptime')
			->orWhere('uptime', '<=', Carbon::now());
		})
		->where(function ($query){
			$query->whereNull('downtime')
			->orWhere('downtime', '>=', Carbon::now());
		})
			->orderBy('slideorder', 'asc')
		->get();
	
	}
	
	public function togglestatus(Request $request, Message $message){
		
		
		$message->status = $request->input('toggle-'.$message->id);
		$message->save();
		return redirect()->back();
	}
}


