<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SlideOrderTest extends TestCase
{
	
	use RefreshDatabase;
    /**
     @test
     */
    public function can_add_order_field()
    {
        $message = factory(\App\Message::class)->create(['slideorder'=>4]);
		$this->assertDatabaseHas('Messages', ['id'=>$message->id]);
    }
	
    /**
     @test
     */
    public function messages_are_retrieved_in_order()
    {
        $message1 = factory(\App\Message::class)->create(['slideorder'=>3, 'status'=>1]);
		$message2 = factory(\App\Message::class)->create(['slideorder'=>2, 'status'=>1]);
		$message3 = factory(\App\Message::class)->create(['slideorder'=>1, 'status'=>1]);
		
		
		$response = $this->call('GET', '/messages/getActive')->json();
		
		
		// dd($response['data']['messages'][0]['id']);
		
		$this->assertTrue($response['data']['messages'][0]['id']==$message3->id && $response['data']['messages'][1]['id']==$message2->id && $response['data']['messages'][2]['id']==$message1->id);
    }
	
	
}
