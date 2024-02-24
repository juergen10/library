<?php

namespace App\Services;

use App\Repositories\BookRepositoryInterface;
use App\Repositories\LoanRepositoryInterface;
use App\Repositories\ReturnBookRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReturnBookService
{
    protected $returnBook;
    protected $book;
    protected $loan;

    public function __construct(
        ReturnBookRepositoryInterface $returnBook,
        BookRepositoryInterface $book,
        LoanRepositoryInterface $loan
    ) {
        $this->returnBook = $returnBook;
        $this->book = $book;
        $this->loan = $loan;
    }

    public function store(array $loans)
    {
        $now = Carbon::now();
        DB::beginTransaction();
        try {
            foreach ($loans as $loan) {
                $loanData = [
                    'loan_id' => $loan['loan_id'],
                    'date_return' => $now,
                    'is_fine' => $loan['is_fine'],
                    'notes' => $loan['notes'],
                    'created_at' => $now,
                    'updated_at' => $now
                ];
                $this->returnBook->store($loanData);
                $this->loan->update($loan['loan_id'], ['is_return' => 1]);

                $book = $this->book->lockForUpdate($loan['book_id']);
                $book->stock += 1;
                $book->save();
            }

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
