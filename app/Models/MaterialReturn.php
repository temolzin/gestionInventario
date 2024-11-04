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

    public function getMaterialsAttribute()
    {
        return $this->loan ? $this->loan->materials : null;
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class); 
    }

    public function student()
    {
        return $this->belongsTo(Student::class); 
    }

    public function department()
    {
        return $this->belongsTo(Department::class); 
    }
}
