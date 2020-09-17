<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Book;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /**   
     * @test
     */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'My First Book',
            'author' => 'Krishna'
        ]);
        $response->assertOk();
        $this->assertCount(1, Book::all());
    }
    /**   
     * @test
     */
    public function a_title_is_required()
    {
      
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Krishna'
        ]);

        $response->assertSessionHasErrors('title');
    }
    /**   
     * @test
     */
    public function an_author_is_required()
    {
       
        $response = $this->post('/books', [
            'title' => 'My First book',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }
    /**   
     * @test
     */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'My First book',
            'author' => 'Krishna'
        ]);

        $book = Book::first();
        $response = $this->patch('/books/'.$book->id,[
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

       $this->assertEquals('New Title', Book::first()->title);
       $this->assertEquals('New Author',Book::first()->author);


    }
}
