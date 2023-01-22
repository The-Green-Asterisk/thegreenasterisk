<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function blogPosts()
    {
        return $this->belongsToMany(BlogPost::class);
    }

    public function getBlogPostCount()
    {
        return $this->blogPosts->count();
    }

    public function getBlogPostList()
    {
        return $this->blogPosts->pluck('title');
    }

    public function getBlogPostListWithLinks()
    {
        return $this->blogPosts->map(function ($blogPost) {
            return '<a href="'.route('blog-posts.show', ['blogPost' => $blogPost->id]).'">'.$blogPost->title.'</a>';
        });
    }

    public function getBlogPostListWithLinksAsString()
    {
        return $this->getBlogPostListWithLinks()->implode(', ');
    }

    public function getBlogPostListAsString()
    {
        return $this->getBlogPostList()->implode(', ');
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

    public function scopeFilter($query, $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('name', 'like', '%'.request('search').'%');
        }
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeMostUsed($query)
    {
        return $query->withCount('blogPosts')->orderBy('blog_posts_count', 'desc');
    }

    public function scopeWithBlogPostCount($query)
    {
        return $query->withCount('blogPosts');
    }
}
