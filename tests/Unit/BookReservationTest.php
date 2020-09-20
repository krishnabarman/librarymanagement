<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Factory;

use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function a_book_can_be_checked_out()
    {
        $book = Book::factory()->create(); 
        $user =  User::factory()->create();
        $book->checkout($user);

        $this->assertCount(1,Reservation::all());
        $this->assertEquals($user->id,Reservation::first()->user_id);
        $this->assertEquals($book->id,Reservation::first()->book_id);        
        $this->assertNotNull(Reservation::first()->checked_out_at);
        $this->assertNull(Reservation::first()->checked_in_at);
    }

    /**
     * @test
     */
    public function a_book_can_be_returned(){

        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkout($user);

        $book->checkin($user); // Must checkout first, only then can checkin

        $this->assertCount(1,Reservation::all());
        $this->assertEquals($user->id,Reservation::first()->user_id);
        $this->assertEquals($book->id,Reservation::first()->book_id);
        $this->assertNotNull(Reservation::first()->checked_out_at);        
        $this->assertNotNull(Reservation::first()->checked_in_at);
       
    }

    /**
     * @test
     */
    public function if_not_checked_out_exception_is_thrown(){

        $this->expectException(\Exception::class);

        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkin($user);
    }


    /**
     * @test
     */
     public function a_user_can_check_out_a_book_twice(){

        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkout($user);

        $book->checkin($user); // Must checkout first, only then can checkin

        $book->checkout($user); // use can check out same book again


        $this->assertCount(2,Reservation::all());
        $this->assertEquals($user->id,Reservation::find(2)->user_id);
        $this->assertEquals($book->id,Reservation::find(2)->book_id);
        $this->assertNotNull(Reservation::find(2)->checked_out_at);        
        $this->assertNull(Reservation::find(2)->checked_in_at);

       $book->checkin($user);
       

        $this->assertCount(2,Reservation::all());
        $this->assertEquals($user->id,Reservation::find(2)->user_id);
        $this->assertEquals($book->id,Reservation::find(2)->book_id);
        $this->assertNotNull(Reservation::find(2)->checked_out_at);        
        $this->assertNotNull(Reservation::find(2)->checked_in_at);
     }
} 
