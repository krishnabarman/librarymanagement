<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Book;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    /**   
     * @test
     */
    public function a_book_can_be_added_to_the_library()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'My First Book',
            'author' => 'Krishna'
        ]);
        $book = Book::first();

        // check if book has been created      
        $this->assertCount(1, Book::all());

        //test redirect
        
       $response->assertRedirect($book->path());
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
        //create the book
        $this->post('/books', [
            'title' => 'My First book',
            'author' => 'Krishna'
        ]);

        // get that book
        $book = Book::first();

        //update that book
        $response = $this->patch($book->path(),[
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        // check if book is updated
       $this->assertEquals('New Title', Book::first()->title);
       $this->assertEquals('New Author',Book::first()->author);

       //test redirect
       $response->assertRedirect($book->fresh()->path());


    }
    /**
     * @test
     */
    public function a_book_can_be_deleted(){

        //create a book
        $this->post('/books', [
            'title' => 'My First book',
            'author' => 'Krishna'
        ]);

        // get that book
        $book = Book::first();
        $this->assertCount(1,Book::all());
        
        // delete that book
        $response = $this->delete('/books/'.$book->id);
        
        // test the result
        $this->assertCount(0,Book::all());
        
        //test redirect
        $response->assertRedirect('/books');

    }
}
