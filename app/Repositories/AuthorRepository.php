<?php


namespace App\Repositories;

use App\Models\Author;


class AuthorRepository implements AuthorRepositoryInterface
{
    /**
     * Get's a record by it's ID
     *
     * @param int
     * @return collection
     */
    public function get($id)
    {
        return Author::find($id);
    }

    /**
     * Get's all records.
     *
     * @return mixed
     */
    public function all()
    {
        return Author::all();
    }

    /**
     * Deletes a record.
     *
     * @param int
     */
    public function delete($id)
    {
        Author::destroy($id);
    }

    /**
     * Updates a post.
     *
     * @param int
     * @param array
     */
    public function update($id, array $data)
    {
        $author = Author::find($id);

        foreach ($data as $key => $value) {
            $author->{$key} = $value;
        }

        $author->save();

        return $author;
    }

    public function paginate(int $perPage, int $page, $search = null)
    {
        return Author::where('first_name', 'like', '%' . $search . '%')
            ->orWhere('last_name', 'like', '%' . $search . '%')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function store(array $author)
    {
        return Author::create($author);
    }
}
