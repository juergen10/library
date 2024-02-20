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
    public function delete($id)
    {
        BookAuthor::destroy($id);
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
        return BookAuthor::create($bookAuthor);
    }
}
