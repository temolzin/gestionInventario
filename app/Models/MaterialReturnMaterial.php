<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialReturnMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['material_return_id', 'material_id', 'quantity_returned'];

    public function materialReturn()
    {
        return $this->belongsTo(MaterialReturn::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
