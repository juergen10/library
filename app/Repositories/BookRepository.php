<?php


namespace App\Repositories;

use App\Models\Book;


class BookRepository implements BookRepositoryInterface
{
    /**
     * Get's a record by it's ID
     *
     * @param int
     * @return collection
     */
    public function get($id)
    {
        return Book::where('id', $id)
            ->with('category')
            ->with('authors')
            ->first();
    }

    /**
     * Get's all records.
     *
     * @return mixed
     */
    public function all()
    {
        return Book::all();
    }

    /**
     * Deletes a record.
     *
     * @param int
     */
    public function delete($id)
    {
        Book::destroy($id);
    }

    /**
     * Updates a post.
     *
     * @param int
     * @param array
     */
    public function update($id, array $data)
    {
        Book::find($id)->update($data);
    }

    public function store(array $book)
    {
        return Book::create($book);
    }
}
