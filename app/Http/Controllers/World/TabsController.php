<?php

namespace App\Http\Controllers\World;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\World;

class TabsController extends Controller
{
    public static function makeTabs($world)
    {
        return World::all()->map(function ($w) use($world) {
            return (object) [
                'name' => $w->name,
                'link' => route('many-worlds.show', $w->short_name),
                'active' => $w->short_name === $world->short_name,
                'shortName' => $w->short_name
            ];
        });
    }
}