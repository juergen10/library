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
        return Book::destroy($id);
    }

    /**
     * Updates a post.
     *
     * @param int
     * @param array
     */
    public function update($id, array $data)
    {
        return Book::find($id)->update($data);
    }

    public function store(array $book)
    {
        return Book::create($book);
    }

    public function paginate(array $data)
    {
        $getBooks = Book::with('category', 'authors');

        if (isset($data['title'])) {
            $getBooks->where('title', 'like', '%' . $data['title'] . '%');
        }

        if (isset($data['categories'])) {
            $getBooks->whereIn('category_id', $data['categories']);
        }

        if (isset($data['author'])) {
            $author = $data['author'];

            $getBooks->whereHas('authors', function ($query) use ($author) {
                $query->where('authors.first_name', 'like', '%' . $author . '%');
                $query->orWhere('authors.last_name', 'like', '%' . $author . '%');
            });
        }

        $books = $getBooks->paginate($data['perPage'], ['*'], 'page', $data['page']);

        return $books;
    }

    public function getISBN(int $id, string $isbn)
    {
        return Book::where('id', '!=', $id)->where('isbn', $isbn)
            ->first();
    }
}
