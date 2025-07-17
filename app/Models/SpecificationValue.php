<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SpecificationHeading;

class SpecificationValue extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $table = 'specification_value';
    protected $primaryKey = 'id';

    public function specificationHeading(){
        return $this->belongsTo(SpecificationHeading::class, 'specs_heading_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
