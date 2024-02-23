<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Response\Response;
use App\Rules\BookStock;
use App\Rules\LoanDueDate;
use App\Services\LoanService;
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
            'user_id' => 'required|exists:books,id',
            'loans' => 'required|array|max:5',
            'loans.*.book_id' => ['required', 'distinct', 'exists:books,id', new BookStock],
            'loans.*.due_date' => ['required', 'date', new LoanDueDate],
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

        return Response::send(200, $saveLoans);
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        //
    }
}
