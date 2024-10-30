<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'loan_id',
        'department_id',
        'created_by',
        'status',
        'detail',
        'expected_return_date',
    ];
}
