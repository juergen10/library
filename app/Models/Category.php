<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    const DEFAULT_PAGE = 1;
    const DEFAULT_PER_PAGE = 10;

    protected $fillable = [
        'name'
    ];
}
