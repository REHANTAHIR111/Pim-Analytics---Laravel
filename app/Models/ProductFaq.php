<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductFaq extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $table = 'productfaqs';
    protected $primaryKey = 'id';

    public function product(){
        return $this->belongsToMany(Product::class, 'productfaqs', 'faq_id', 'product_id');
    }
}
