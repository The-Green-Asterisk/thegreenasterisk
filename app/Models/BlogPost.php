<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'slug',
        'image',
        'title',
        'content',
        'user_id',
        'is_draft',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('published_at' ?? 'created_at', 'desc');
    }

    public function scopeFilter($query, $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('title', 'like', '%'.request('search').'%')
                ->orWhere('content', 'like', '%'.request('search').'%');
        }
    }

    public function getExcerpt()
    {
        return substr($this->content, 0, 300).'...';
    }

    public function getTagList()
    {
        return $this->tags->pluck('name');
    }

    public static function getAllByTag($tag)
    {
        return BlogPost::whereHas('tags', function ($query) use ($tag) {
            $query->where('name', $tag);
        })->latestFirst()->get();
    }

    public static function getAll()
    {
        return BlogPost::orderBy('is_draft', 'desc')->latestFirst();
    }

    public function getCommentCount()
    {
        return $this->comments->count();
    }

    public function getPublishedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }
}
