<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $table='posts';
    protected $fillable=[
        'author',
        'status'
    ];

    public function postLang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PostLang::class, 'postId', 'id');
    }
}
