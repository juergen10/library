<?php

namespace App\Services;

use App\Repositories\BookAuthorRepositoryInterface;
use App\Repositories\BookRepositoryInterface;
use Illuminate\Support\Facades\DB;

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
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
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
        return $this->book->delete($id);
    }

    public function getISBN(int $id, string $isbn)
    {
        return $this->book->getISBN($id, $isbn);
    }

    public function edit(int $id, $book, $bookAuthors)
    {
        try {
            DB::beginTransaction();
            $this->book->update($id, $book);

            foreach ($bookAuthors as $bookAuthor) {
                $authors = [];
                $findBookAuthor = $this->bookAuthor->getBookAuthor($bookAuthor, $id);

                if (null == $findBookAuthor) {
                    $authors = [
                        'author_id' => $bookAuthor,
                        'book_id' => $id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $this->bookAuthor->store($authors);
                }
            }

            $this->bookAuthor->deleteAuthorBook($id, $bookAuthors);
            DB::commit();

            return $this->book->get($id);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
