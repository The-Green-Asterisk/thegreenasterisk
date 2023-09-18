<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function world()
    {
        return $this->belongsTo(World::class);
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
