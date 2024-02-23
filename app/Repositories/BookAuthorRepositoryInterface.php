<?php

namespace App\Repositories;

interface BookAuthorRepositoryInterface
{
    /**
     * Get's a record by it's ID
     *
     * @param int
     */
    public function get($id);

    /**
     * Get's all records.
     *
     * @return mixed
     */
    public function all();

    public function deleteAuthorBook(int $bookID, array $authors);

    /**
     * Updates a record.
     *
     * @param int
     * @param array
     */
    public function update($id, array $data);

    public function store(array $bookAuthor);

    public function getBookAuthor(int $authorID, int $bookID);
}
