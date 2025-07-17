<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductTags extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $table = 'product_tags';
    protected $primaryKey = 'id';

    public function product(){
        return $this->belongsToMany(Product::class, 'product_tags', 'tag_id', 'product_id');
    }
}
