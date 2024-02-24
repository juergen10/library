<?php

namespace App\Services;

use App\Repositories\BookRepositoryInterface;
use App\Repositories\LoanRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanService
{
    protected $loan;
    protected $book;
    public function __construct(
        LoanRepositoryInterface $loan,
        BookRepositoryInterface $book
    ) {
        $this->loan = $loan;
        $this->book = $book;
    }

    public function index(array $data)
    {
        return $this->loan->paginate($data);
    }

    public function getActiveLoanUser(int $userID)
    {
        return $this->loan->getActiveLoanUser($userID);
    }

    public function store($userID, array $loans)
    {
        $now = Carbon::now();
        DB::beginTransaction();
        try {
            foreach ($loans as $loan) {
                $loanData = [
                    'user_id' => $userID,
                    'book_id' => $loan['book_id'],
                    'date_loan' => $now,
                    'due_date' => Carbon::parse($loan['due_date'])->format('Y-m-d H:i:s'),
                    'created_at' => $now,
                    'updated_at' => $now
                ];
                $book = $this->book->lockForUpdate($loan['book_id']);
                $book->stock -= 1;
                $book->save();

                $this->loan->store($loanData);
            }

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function getLoanBook(int $id)
    {
        return $this->loan->getLoanBook($id);
    }
}
