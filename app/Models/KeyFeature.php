<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class KeyFeature extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $table = 'key_feature';
    protected $primaryKey = 'id';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
