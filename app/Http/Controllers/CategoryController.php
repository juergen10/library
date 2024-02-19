<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use App\Response\Response;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryRepositoryInterface $category)
    {
        $this->category = $category;
    }


    public function index(Request $request)
    {
        $page = $request->get('page', Category::DEFAULT_PAGE);
        $perPage = $request->get('perPage', Category::DEFAULT_PER_PAGE);
        $search = $request->get('q');

        $categories = $this->category->paginate($perPage, $page, $search);

        return Response::send(200, $categories);
    }
}
