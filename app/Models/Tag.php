<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subtag;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'name_ar',
        'sorting',
        'icon',
        'image_link_app',
        'status',
        'creator_id',
    ];

    protected $table = 'tags';
    protected $primaryKey = 'id';

    public function subtags(){
        return $this->hasMany(Subtag::class, 'tag_id');
    }
}
