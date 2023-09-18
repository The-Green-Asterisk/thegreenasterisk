<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\World;

class WorldController extends Controller
{
    public function index($shortName = null)
    {
        $world = World::where('short_name', $shortName)->first();

        return view('many-worlds.index', [
            'tabs' => World::all()->map(function ($w) use ($shortName) {
                return (object) [
                    'name' => $w->name,
                    'link' => route('many-worlds', $w->short_name),
                    'active' => $w->short_name === $shortName,
                    'shortName' => $w->short_name
                ];
            }),
            'world' => $world,
            'worldActive' => !!$world,
            'bg' => !!$world
                ? asset('/storage/images/'.$shortName.'_bg.jpg')
                : asset('/storage/images/graph-paper.jpg')
        ]);
    }
}
