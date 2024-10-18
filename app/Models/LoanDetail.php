<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'material_id',
        'department_id',
        'created_by',
        'quantity',

    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
