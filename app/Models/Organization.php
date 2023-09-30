<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function world()
    {
        return $this->belongsTo(World::class);
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'character_organization', 'organization_id', 'character_id');
    }

    public function leader()
    {
        return $this->belongsTo(Character::class, 'leader_id');
    }

    public function members()
    {
        return $this->belongsToMany(Character::class, 'character_organization', 'organization_id', 'character_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
