<?php

namespace App\Http\Controllers;

use App\Constants\PaginationConstant;
use App\Repositories\CategoryRepositoryInterface;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryRepositoryInterface $category)
    {
        $this->category = $category;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', PaginationConstant::DEFAULT_PAGE);
        $perPage = $request->get('perPage', PaginationConstant::DEFAULT_PER_PAGE);
        $search = $request->get('q');

        $categories = $this->category->paginate($perPage, $page, $search);

        return Response::send(200, $categories);
    }

    public function show(int $id)
    {
        $category = $this->category->get($id);

        if (null == $category) {
            return Response::message('resource_not_found');
        }

        return Response::send(200, $category);
    }

    public function store(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
        ]);

        if ($rules->fails()) {
            return Response::send(422, $rules->errors());
        }

        $data['name'] = $request->name;
        $category = $this->category->store($data);

        return Response::send(200, $category);
    }

    public function update(int $id, Request $request)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
        ]);

        if ($rules->fails()) {
            return Response::send(422, $rules->errors());
        }

        $category = $this->category->get($id);

        if (null == $category) {
            return Response::message('resource_not_found');
        }

        $data['name'] = $request->name;
        $category = $this->category->update($id, $data);

        return Response::send(200, $category);
    }

    public function delete(int $id)
    {
        $category = $this->category->delete($id);

        return Response::send(204, $category);
    }
}
