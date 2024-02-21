<?php

namespace App\Http\Controllers;

use App\Constants\PaginationConstant;
use App\Response\Response;
use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = [];
        $data['page'] = $request->get('page', PaginationConstant::DEFAULT_PAGE);
        $data['perPage'] = $request->get('perPage', PaginationConstant::DEFAULT_PER_PAGE);

        if ($request->has('title') && null !== $request->get('title')) {
            $data['title'] = $request->get('title');
        }

        if ($request->has('categories') && null !== $request->get('categories')) {
            $data['categories'] = explode(',', $request->get('categories'));
        }

        if ($request->has('author') && null !== $request->get('author')) {
            $data['author'] = $request->get('author');
        }

        $books = $this->bookService->index($data);

        return Response::send(200, $books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'title' => 'required',
            'isbn' => 'required|unique:books',
            'publication_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'author_ids' => 'required|array',
            'author_ids.*' => 'required|exists:authors,id',
            'stock' => 'required|integer'
        ]);

        if ($rules->fails()) {
            return Response::send(422, $rules->errors());
        }

        $book['title'] = $request->title;
        $book['isbn'] = $request->isbn;
        $book['publication_date'] = $request->publication_date;
        $book['category_id'] = $request->category_id;
        $book['stock'] = $request->stock;
        $book['description'] = $request->description;

        $bookAuthors = $request->author_ids;
        $book = $this->bookService->storeBook($book, $bookAuthors);

        return Response::send(200, $book);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $book = $this->bookService->get($id);

        if (null == $book) {
            return Response::message('resource_not_found');
        }

        return Response::send(200, $book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $book = $this->bookService->delete($id);
        return Response::send(204);
    }
}
