<?php

namespace App\Repositories;

interface UserRepositoryInterface
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
     * Ger a record by email.
     *
     * @param string
     */
    public function getByEmail(string $email);

    public function store(array $user);
}
