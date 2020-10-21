<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManangementTest extends TestCase
{
    /** @test **/
    use RefreshDatabase;

    public function a_book_can_be_added_to_the_library()
    {

        $response = $this->post('/books', [
            'title' => 'Cool Book title',
            'author' => 'Josh'
        ]);

        $book = Book::first();


        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());
    }

    /** @test **/
    public function a_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Josh'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test **/
    public function a_author_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'Cool title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test **/
    public function a_book_can_be_updated()
    {
        $this->post('/books', [
            'title' => 'Cool title',
            'author' => 'Josh'
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New title',
            'author' => 'New author'
        ]);

        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New author', Book::first()->author);
        $response->assertRedirect($book->fresh()->path());
    }

    /** @test **/
    public function a_book_can_be_deleted()
    {
        $this->post('/books', [
            'title' => 'Cool title',
            'author' => 'Josh'
        ]);

        $book = Book::first();

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
}
