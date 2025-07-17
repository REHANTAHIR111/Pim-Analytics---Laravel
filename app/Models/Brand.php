<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
use App\Models\Product;

class Brand extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $table = 'brand';
    protected $primaryKey = 'id';

    public function categories() {
        return $this->belongsToMany(Categories::class, 'brand_categories', 'brand_id', 'category_id');
    }

    public function productrelatedBrand(){
        return $this->belongsToMany(Product::class, 'product_brands', 'brand_id', 'product_id');
    }
}
