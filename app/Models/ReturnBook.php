<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnBook extends Model
{
    protected $fillable = [
        'loan_id',
        'date_return',
        'is_fine',
        'notes'
    ];

    use HasFactory;
}
