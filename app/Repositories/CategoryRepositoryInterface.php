<?php

namespace App\Repositories;

interface CategoryRepositoryInterface
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

    /**
     * Paginate the records.
     *
     * @param int
     * @param int
     * @param string
     */

    public function paginate(int $perPage, int $page, $search = null);

    public function store(array $data);
}
