<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function world()
    {
        return $this->belongsTo(World::class);
    }

    public function primaryLocation()
    {
        return $this->belongsTo(Location::class);
    }

    public function leaderOf()
    {
        return $this->hasMany(Organization::class, 'leader_id');
    }

    public function memberOf()
    {
        return $this->belongsToMany(Organization::class, 'character_organization', 'character_id', 'organization_id');
    }
}
