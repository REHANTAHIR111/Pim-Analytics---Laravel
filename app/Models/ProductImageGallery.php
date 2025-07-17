<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImageGallery extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $table = 'product_image_gallery';
    protected $primaryKey = 'id';

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
