<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /**     
     * @test
     */
    public function an_author_can_be_created()
    {
        $this->withoutExceptionHandling();
        $this->post('/authors', [
            'name' => 'Krishna',
            'dob' => '07/19/1979'
        ]);

        $author = Author::all();

        $this->assertCount(1,$author);

        // check if the date is Carbon instanced
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);

        $this->assertEquals('19/07/1979', $author->first()->dob->format('d/m/Y'));

    }
}
