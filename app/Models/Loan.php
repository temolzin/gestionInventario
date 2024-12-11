<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'department_id',
        'created_by',
        'status',
        'detail',
        'return_at',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'loan_details')
            ->withPivot('quantity', 'returned_quantity');
    }
    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    public function materialReturns()
    {
        return $this->hasMany(MaterialReturn::class);
    }

    public function materialReturn()
    {
        return $this->hasOne(MaterialReturn::class);
    } 
    
}
