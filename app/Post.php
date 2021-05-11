<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    //use HasFactory;
    protected $table = 'posts';

    const DRAFT = 'draft';
    const PUBLISHED = 'published';

    protected $fillable = ['title', 'slug', 'image', 'content', 'tags', 'status'];


    public function scopePublished(Builder $query)
    {
        return $query->where('status', '=', static::PUBLISHED);
    }
}
