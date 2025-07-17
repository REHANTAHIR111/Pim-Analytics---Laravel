<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KeyFeature;
use App\Models\SpecificationHeading;
use App\Models\UpsaleItems;
use App\Models\Categories;
use App\Models\Product;
use App\Models\Faq;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $table = 'product';
    protected $primaryKey = 'id';

    public function keyFeatures(){
        return $this->hasMany(KeyFeature::class, 'product_id');
    }

    public function specificationHeadings(){
        return $this->hasMany(SpecificationHeading::class, 'product_id');
    }

    public function upsaleItems(){
        return $this->hasMany(UpsaleItems::class, 'product_id');
    }

    public function relatedBrands(){
        return $this->belongsToMany(Brand::class, 'product_brands', 'product_id', 'brand_id');
    }

    public function relatedCategories(){
        return $this->belongsToMany(Categories::class, 'product_related_categories', 'product_id', 'category_id');
    }

    public function faqs(){
        return $this->belongsToMany(Faq::class, 'productfaqs', 'product_id', 'faq_id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }

    public function categories(){
        return $this->belongsToMany(Categories::class, 'product_categories', 'product_id', 'category_id');
    }

    public function galleryImages(){
        return $this->hasMany(ProductImageGallery::class, 'product_id');
    }
}
