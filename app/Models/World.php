<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class World extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
