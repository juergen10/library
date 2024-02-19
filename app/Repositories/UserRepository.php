<?php

namespace App\Repositories;

use App\Models\User;


class UserRepository implements UserRepositoryInterface
{
    /**
     * Get's a record by it's ID
     *
     * @param int
     * @return collection
     */
    public function get($id)
    {
        return User::find($id);
    }

    /**
     * Get's all records.
     *
     * @return mixed
     */
    public function all()
    {
        return User::all();
    }

    /**
     * Deletes a record.
     *
     * @param int
     */
    public function delete($id)
    {
        User::destroy($id);
    }

    /**
     * Updates a post.
     *
     * @param int
     * @param array
     */
    public function update($id, array $data)
    {
        User::find($id)->update($data);
    }

    public function getByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function store(array $user)
    {
        return User::create($user);
    }
}
