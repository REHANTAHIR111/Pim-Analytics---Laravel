<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;

class Subtag extends Model
{
    use HasFactory;
    protected $fillable = [
        'tag_id',
        'name',
        'name_ar',
        'sorting',
        'icon',
        'image_link_app',
        'status',
        'creator_id',
    ];

    protected $table = 'sub_tags';
    protected $primaryKey = 'id';

    public function tag(){
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    public function categories(){
        return $this->belongsToMany(Categories::class, 'category_filter', 'filter_id', 'category_id');
    }
}
