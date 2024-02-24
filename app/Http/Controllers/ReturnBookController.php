<?php

namespace App\Http\Controllers;

use App\Response\Response;
use App\Rules\ReturnBook;
use App\Services\ReturnBookService;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ReturnBookController extends Controller
{
    protected $returnBookService;

    public function __construct(ReturnBookService $returnBookService)
    {
        $this->returnBookService = $returnBookService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'returns' => 'required|array',
            'returns.*.loan_id' => ['required', 'distinct', 'exists:loans,id'],
            'returns.*.book_id' => ['required', 'distinct', Rule::exists('loans', 'book_id')->where(function (Builder $query) use ($request) {
                return $query->where([
                    'user_id' => $request->user_id,
                    'is_return' => 0,
                ]);
            })],
            'returns.*.is_fine' => 'sometimes|required|boolean',
            'returns.*.note' => 'sometimes|required'
        ]);

        if ($rules->fails()) {
            return Response::send(422, $rules->errors());
        }
        $loans = $request->returns;
        $returns = $this->returnBookService->store($loans);
        return Response::send(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ReturnBook $returnBook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReturnBook $returnBook)
    {
        //
    }
}
