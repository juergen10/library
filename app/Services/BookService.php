<?php

namespace App\Services;

use App\Repositories\BookAuthorRepositoryInterface;
use App\Repositories\BookRepositoryInterface;

class BookService
{
    protected $book;
    protected $bookAuthor;

    public function __construct(
        BookRepositoryInterface $book,
        BookAuthorRepositoryInterface $bookAuthor
    ) {
        $this->book = $book;
        $this->bookAuthor = $bookAuthor;
    }

    public function index(array $data)
    {
        $books = $this->book->paginate($data);
        
        return $books;
    }

    public function storeBook(array $book, array $bookAuthors)
    {
        $authors = [];
        $book = $this->book->store($book);

        foreach ($bookAuthors as $bookAuthor) {
            $authors[] = [
                'author_id' => $bookAuthor,
                'book_id' => $book->id,
            ];
        }

        $this->bookAuthor->store($authors);

        return $this->book->get($book->id);
    }

    public function get(int $id)
    {
        return $this->book->get($id);
    }

    public function delete(int $id)
    {
        //TODO
        //add validation if book still on loan

        return $this->book->delete($id);
    }
}
