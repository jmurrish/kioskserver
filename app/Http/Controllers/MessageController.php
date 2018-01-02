<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Response;


use App\Message;

class MessageController extends Controller
{
    //
	
	public function index(Request $request){
		
		$status=$request->input('status');
		
		if ($status != ""){
			$messages=Message::where('status', $status)->get();
		}
		else $messages=Message::all();
		return view('messages.messagelist', ['messages' => $messages, 'status'=>$status]);
	}
	

	
	public function edit(Message $message){
		
		
		return view('messages.editmessage', compact('message'));
	}
	
	public function create(){
		return view('messages.addmessage', ['message' => new Message]);
	}
	
	public function store(Request $request){
		
		
		$message=Message::create($request->all());
		
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
		
		
		$message->update($request->all());
		
		if ($request->uploadphoto) {
		    
			
			$fpath=$request->uploadphoto->store('slides', 'public');
			// dd($fpath);
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
		// $request=new Request();
		
		
		$startdate=$request->input('startdate');
		
		if ($startdate == "") $startdate="0000-00-00";
		
		$messages=Message::where('updated_at', '>', $startdate)->where('status', '=', 1)->get();
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
	
	private function getactiveids(){
		return Message::select('id')->where('status', 1)->get();
	
	}
}


