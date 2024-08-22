<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLang extends Model
{
    use HasFactory;
    protected $table = "post_lang";
    protected $fillable = [
        'postId',
        'postLangType',
        'postTitle',
        'postContent',
    ];
}
