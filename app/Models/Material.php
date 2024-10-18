<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Material extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'department_id',
        'created_by',
        'name',
        'description',
        'status',
        'amount',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function departament()
    {
        return $this->belongsTo(Department::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function loanDetails()
    {
        return $this->hasMany(LoanDetail::class);
    }

    public function loans()
    {
        return $this->belongsToMany(Loan::class, 'loan_details')
            ->withPivot('quantity', 'created_by')
            ->withTimestamps();
    }
}
