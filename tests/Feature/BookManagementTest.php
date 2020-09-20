<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Book;
use Carbon\Factory;
use Illuminate\Support\Facades\Auth;
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

        $response = $this->post('/books', $this->data());
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

        $response = $this->post('/books', array_merge($this->data(), ['title' => '']));

        $response->assertSessionHasErrors('title');
    }
    /**   
     * @test
     */
    public function an_author_is_required()
    {

        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }
    /**   
     * @test
     */
    public function a_book_can_be_updated()
    {
        //create the book
        $this->post('/books', $this->data());

        // get that book
        $book = Book::first();

        //update that book
        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author_id' => 'New Author'
        ]);

        // check if book is updated
        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id); // New Author name has created a new record, so ID will be 2

        //test redirect
        $response->assertRedirect($book->fresh()->path());
    }
    /**
     * @test
     */
    public function a_book_can_be_deleted()
    {

        //create a book
        $this->post('/books', $this->data());

        // get that book
        $book = Book::first();
        $this->assertCount(1, Book::all());

        // delete that book
        $response = $this->delete('/books/' . $book->id);

        // test the result
        $this->assertCount(0, Book::all());

        //test redirect
        $response->assertRedirect('/books');
    }

    /**
     * @test
     */
    public function a_new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();
        //create the book
        $this->post('/books', $this->data());

        $book = Book::first();
        $author = Author::first();

        $this->assertCount(1, Author::all());
        $this->assertEquals($author->id, $book->author_id);
    }

    private function data()
    {

        return [
            'title' => 'My First book',
            'author_id' => 'Krishna'
        ];
    }
}
