<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
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
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeFilter($query, $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('content', 'like', '%' . request('search') . '%');
        }
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getExcerpt()
    {
        return substr($this->content, 0, 100) . '...';
    }

    public function getTagList()
    {
        return $this->tags->pluck('name');
    }

    public function getCommentCount()
    {
        return $this->comments->count();
    }
}
