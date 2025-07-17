<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'question_english',
        'question_arabic',
        'answer_english',
        'answer_arabic',
        'status',
        'creator_id',
    ];

    protected $table = 'product_faqs';
    protected $primaryKey = 'id';
}
