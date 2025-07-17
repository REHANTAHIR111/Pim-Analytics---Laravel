<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subtag;
use App\Models\Brand;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'slug',
        'name',
        'name_arabic',
        'h1_en',
        'h1_arabic',
        'description',
        'description_arabic',
        'meta_title',
        'meta_title_arabic',
        'meta_canonical',
        'meta_canonical_arabic',
        'meta_description',
        'meta_description_arabic',
        'meta_tags',
        'meta_tags_arabic',
        'content_title',
        'content_title_arabic',
        'content_description',
        'content_description_arabic',
        'status',
        'not_for_export',
        'show_in_menu',
        'show_on_arabyads',
        'nofollow_analytics',
        'noindex_analytics',
        'redirection_link',
        'sell_type',
        'value',
        'parent_category',
        'icon',
        'brand_link',
        'image_link',
        'website_image',
        'mobile_image',
        'creator_id',
        'sorting'
    ];

    protected $table = 'productcategories';
    protected $primaryKey = 'id';

    public function filters(){
        return $this->belongsToMany(Subtag::class, 'category_filter', 'category_id', 'filter_id');
    }

    public function brands() {
        return $this->belongsToMany(Brand::class, 'brand_categories', 'category_id', 'brand_id');
    }

    public function productrelatedCategories() {
        return $this->belongsToMany(Product::class, 'product_related_categories', 'category_id', 'product_id');
    }


    public function product(){
        return $this->belongsToMany(Product::class, 'product_categories', 'category_id', 'product_id');
    }
}
