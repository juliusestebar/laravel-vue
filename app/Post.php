<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    //use HasFactory;
    use HasSlug;
    protected $table = 'posts';

    const DRAFT = 'draft';
    const PUBLISHED = 'published';

    protected $fillable = ['title', 'slug', 'image', 'content', 'tags', 'status'];


    public function scopePublished(Builder $query)
    {
        return $query->where('status', '=', static::PUBLISHED);
    }


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
        ->generateSlugsFrom('title')
        //->generateSlugsFrom(['title', 'tags'])
        ->saveSlugsTo('slug');
        //->slugsShouldBeNoLongerThan(50);
    }
}
