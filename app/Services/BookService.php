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
}
