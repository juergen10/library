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
    public function storeBook(array $book, array $bookAuthor)
    {
        $book = $this->book->store($book);
        $bookAuthor['book_id'] = $book->id;
        $this->bookAuthor->store($bookAuthor);

        return $this->book->get($book->id);
    }
}
