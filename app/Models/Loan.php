<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'date_loan',
        'due_date',
        'is_return'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function book()
    {
        return $this->hasOne(Book::class, 'id', 'book_id');
    }

    public function returnBook()
    {
        return $this->hasOne(ReturnBook::class, 'loan_id', 'id');
    }
}
