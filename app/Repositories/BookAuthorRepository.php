<?php


namespace App\Repositories;

use App\Models\BookAuthor;


class BookAuthorRepository implements BookAuthorRepositoryInterface
{
    /**
     * Get's a record by it's ID
     *
     * @param int
     * @return collection
     */
    public function get($id)
    {
        return BookAuthor::find($id);
    }

    public function getBookAuthor(int $authorID, int $bookID)
    {
        return BookAuthor::where(['author_id' => $authorID, 'book_id' => $bookID])->first();
    }

    /**
     * Get's all records.
     *
     * @return mixed
     */
    public function all()
    {
        return BookAuthor::all();
    }

    /**
     * Deletes a record.
     *
     * @param int
     */
    public function deleteAuthorBook(int $bookID, array $authors)
    {
        return BookAuthor::where('book_id', $bookID)
            ->whereNotIn('author_id', $authors)->delete();
    }

    /**
     * Updates a post.
     *
     * @param int
     * @param array
     */
    public function update($id, array $data)
    {
        BookAuthor::find($id)->update($data);
    }

    public function store(array $bookAuthor)
    {
        return BookAuthor::insert($bookAuthor);
    }
}
