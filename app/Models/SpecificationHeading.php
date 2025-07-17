<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\SpecificationValue;

class SpecificationHeading extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $table = 'specification_heading';
    protected $primaryKey = 'id';

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function specificationValues(){
        return $this->hasMany(SpecificationValue::class, 'specs_heading_id');
    }
}
