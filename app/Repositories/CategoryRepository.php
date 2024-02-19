<?php

namespace App\Repositories;

use App\Models\Category;


class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Get's a record by it's ID
     *
     * @param int
     * @return collection
     */
    public function get($id)
    {
        return Category::find($id);
    }

    /**
     * Get's all records.
     *
     * @return mixed
     */
    public function all()
    {
        return Category::all();
    }

    /**
     * Deletes a record.
     *
     * @param int
     */
    public function delete($id)
    {
        Category::destroy($id);
    }

    /**
     * Updates a post.
     *
     * @param int
     * @param array
     */
    public function update($id, array $data)
    {
        $category = new Category();

        foreach ($data as $key => $value) {
            $category->{$key} = $value;
        }

        $category->save();

        return $category;
    }

    public function paginate(int $perPage, int $page, $search = null)
    {
        return Category::where('name', 'like', '%' . $search . '%')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function store(array $category)
    {
        return Category::create($category);
    }
}
