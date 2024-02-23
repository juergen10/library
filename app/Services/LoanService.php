<?php

namespace App\Services;

use App\Repositories\LoanRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanService
{
    protected $loan;

    public function __construct(LoanRepositoryInterface $loan)
    {
        $this->loan = $loan;
    }


    public function store($userID, array $loans)
    {
        $now = Carbon::now();
        $loanData = [];
        foreach ($loans as $loan) {
            $loanData[] = [
                'user_id' => $userID,
                'book_id' => $loan['book_id'],
                'date_loan' => $now,
                'due_date' => Carbon::parse($loan['due_date'])->format('Y-m-d H:i:s'),
                'created_at' => $now,
                'updated_at' => $now
            ];
        }

        return $this->loan->store($loanData);
    }
}
