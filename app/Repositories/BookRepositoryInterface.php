<?php

namespace App\Repositories;

interface BookRepositoryInterface
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

    /**
     * Deletes a record.
     *
     * @param int
     */
    public function delete($id);

    /**
     * Updates a record.
     *
     * @param int
     * @param array
     */
    public function update($id, array $data);

    public function store(array $book);

    public function paginate(array $data);

    public function getISBN(int $id, string $isbn);

    public function lockForUpdate(int $bookID);
}
