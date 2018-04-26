<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;
use Carbon\Carbon;

class PublishDateTest extends TestCase
{
	
    /** @test */
    public function entries_with_no_publish_date_will_be_retrieved(){
    	DB::enableQueryLog();
		$message = factory(\App\Message::class)->create(['status'=>1]);
		$response = $this->get('/messages/getActive');	
		
		// dd(DB::getQueryLog());
		
		$response->assertSee($message->name);
    }
	
	/** @test */
	public function entries_with_uptimes_will_be_retrieved(){
		
		
		$todaymessage = factory(\App\Message::class)->create(['status'=>1, 'uptime'=>carbon::today()]);
		$tomorrowmessage = factory(\App\Message::class)->create(['status'=>1, 'uptime'=>carbon::tomorrow()]);
		
		$response = $this->get('/messages/getActive');
		$response->assertSee($todaymessage->name);
		$response->assertDontSee($tomorrowmessage->name);
	}
	
	/** @test */
	public function entries_with_downtimestimes_will_be_retrieved(){
		
		
		$yesterdaymessage = factory(\App\Message::class)->create(['status'=>1, 'downtime'=>carbon::yesterday()]);
		$tomorrowmessage = factory(\App\Message::class)->create(['status'=>1, 'downtime'=>carbon::tomorrow()]);
		
		$response = $this->get('/messages/getActive');
		$response->assertDontSee($yesterdaymessage->name);
		$response->assertSee($tomorrowmessage->name);
	}
	
	/** @test */
	public function entries_in_date_range_will_be_retrieved(){
		
		
		$lowmessage = factory(\App\Message::class)->create(['status'=>1, 'uptime'=>carbon::now()->subDays(30), 'downtime'=>Carbon::yesterday()]);
		$highmessage = factory(\App\Message::class)->create(['status'=>1, 'uptime'=>carbon::tomorrow(), 'downtime'=>carbon::today()->addDays(30)]);
		$rightmessage = factory(\App\Message::class)->create(['status'=>1, 'uptime'=>carbon::yesterday(),'downtime'=>carbon::tomorrow()]);
		
		$response = $this->get('/messages/getActive');
		$response->assertDontSee($lowmessage->name);
		$response->assertDontSee($highmessage->name);
		$response->assertSee($rightmessage->name);
	}
	
 
}
