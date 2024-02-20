<?php

namespace App\Http\Controllers;

use App\Constants\PaginationConstant;
use App\Repositories\AuthorRepositoryInterface;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    protected $author;

    public function __construct(AuthorRepositoryInterface $author)
    {
        $this->author = $author;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', PaginationConstant::DEFAULT_PAGE);
        $perPage = $request->get('perPage', PaginationConstant::DEFAULT_PER_PAGE);
        $search = $request->get('q');

        $authors = $this->author->paginate($perPage, $page, $search);

        return Response::send(200, $authors);
    }

    public function store(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'first_name' => 'required',
        ]);

        if ($rules->fails()) {
            return Response::send(422, $rules->errors());
        }

        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $author = $this->author->store($data);

        return Response::send(200, $author);
    }

    public function show(int $id)
    {
        $author = $this->author->get($id);

        if (null == $author) {
            return Response::message('resource_not_found');
        }

        return Response::send(200, $author);
    }

    public function delete(int $id)
    {
        $author = $this->author->delete($id);

        return Response::send(204, $author);
    }

    public function update(int $id, Request $request)
    {
        $rules = Validator::make($request->all(), [
            'first_name' => 'required',
        ]);

        if ($rules->fails()) {
            return Response::send(422, $rules->errors());
        }

        $author = $this->author->get($id);

        if (null == $author) {
            return Response::message('resource_not_found');
        }

        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;

        $author = $this->author->update($id, $data);

        return Response::send(200, $author);
    }
}
