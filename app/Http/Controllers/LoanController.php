<?php

namespace App\Http\Controllers;

use App\Constants\PaginationConstant;
use App\Models\Loan;
use App\Response\Response;
use App\Rules\BookStock;
use App\Rules\LoanDueDate;
use App\Services\LoanService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    protected $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = [];
        $now = Carbon::now();
        $data['page'] = $request->get('page', PaginationConstant::DEFAULT_PAGE);
        $data['perPage'] = $request->get('perPage', PaginationConstant::DEFAULT_PER_PAGE);

        $data['from'] = $request->get('from', $now->startOfDay());
        $data['to'] = $request->get('to', $now->endOfDay());

        if ($request->has('userID') && null !== $request->get('userID')) {
            $data['userID'] = $request->get('userID');
        }
        $loans = $this->loanService->index($data);

        return Response::send(200, $loans);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'loans' => 'required|array|max:5',
            'loans.*.book_id' => ['required', 'distinct', 'exists:books,id', new BookStock]
        ]);

        if ($rules->fails()) {
            return Response::send(422, $rules->errors());
        }

        $userID = $request->user_id;
        $loans = $request->loans;

        $userLoanActive = $this->loanService->getActiveLoanUser($userID);

        if (null != $userLoanActive) {
            return Response::message('user_has_active_loan');
        }

        $saveLoans = $this->loanService->store($userID, $loans);

        return Response::send(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        //
    }
}
