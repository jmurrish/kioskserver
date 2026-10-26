<?php

namespace Tests\Feature;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;
use Carbon\Carbon;

class PublishDateTest extends TestCase
{
	use RefreshDatabase;
    #[Test]
    public function entries_with_no_publish_date_will_be_retrieved(){
    	DB::enableQueryLog();
		$message = \App\Models\Message::factory()->create(['status'=>1]);
		$response = $this->get('/messages/getActive');	
		
		// dd(DB::getQueryLog());
		
		$response->assertSee($message->name);
    }
	
	#[Test]
	public function entries_with_uptimes_will_be_retrieved(){
		
		
		$todaymessage = \App\Models\Message::factory()->create(['status'=>1, 'uptime'=>carbon::today()]);
		$tomorrowmessage = \App\Models\Message::factory()->create(['status'=>1, 'uptime'=>carbon::tomorrow()]);
		
		$response = $this->get('/messages/getActive');
		$response->assertSee($todaymessage->name);
		$response->assertDontSee($tomorrowmessage->name);
	}
	
	#[Test]
	public function entries_with_downtimestimes_will_be_retrieved(){
		
		
		$yesterdaymessage = \App\Models\Message::factory()->create(['status'=>1, 'downtime'=>carbon::yesterday()]);
		$tomorrowmessage = \App\Models\Message::factory()->create(['status'=>1, 'downtime'=>carbon::tomorrow()]);
		
		$response = $this->get('/messages/getActive');
		$response->assertDontSee($yesterdaymessage->name);
		$response->assertSee($tomorrowmessage->name);
	}
	
	#[Test]
	public function entries_in_date_range_will_be_retrieved(){
		
		
		$lowmessage = \App\Models\Message::factory()->create(['status'=>1, 'uptime'=>carbon::now()->subDays(30), 'downtime'=>Carbon::yesterday()]);
		$highmessage = \App\Models\Message::factory()->create(['status'=>1, 'uptime'=>carbon::tomorrow(), 'downtime'=>carbon::today()->addDays(30)]);
		$rightmessage = \App\Models\Message::factory()->create(['status'=>1, 'uptime'=>carbon::yesterday(),'downtime'=>carbon::tomorrow()]);
		
		$response = $this->get('/messages/getActive');
		$response->assertDontSee($lowmessage->name);
		$response->assertDontSee($highmessage->name);
		$response->assertSee($rightmessage->name);
	}
	
 
}
