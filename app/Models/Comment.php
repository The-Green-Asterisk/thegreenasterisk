<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'blog_post_id',
    ];

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('content', 'like', '%' . request('search') . '%');
        }
    }

    public function getExcerpt()
    {
        return substr($this->content, 0, 24) . '...';
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function getCommenterName()
    {
        return $this->user->name;
    }

    public function getCommenterEmail()
    {
        return $this->user->email;
    }

    public function getCommenterAvatar()
    {
        return $this->user->avatar;
    }

    public function getCommenterUrl()
    {
        return $this->user->url;
    }

    public function getCommenterId()
    {
        return $this->user->id;
    }

    public function isCommenterAdmin()
    {
        return $this->user->isAdmin();
    }
}
