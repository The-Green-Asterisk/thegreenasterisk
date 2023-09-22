<?php

namespace App\Http\Controllers\World;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\World;
use App\Models\Location;

class LocationController extends Controller
{
    public function index(World $world)
    {
        return view('many-worlds.locations.index', [
            'tabs' => World::all()->map(function ($w) use($world) {
                return (object) [
                    'name' => $w->name,
                    'link' => route('many-worlds.show', $w->short_name),
                    'active' => $w->short_name === $world->short_name,
                    'shortName' => $w->short_name
                ];
            }),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'locations' => $world->locations()->get()
        ]);
    }

    public function show(World $world, Location $location)
    {
        return view('many-worlds.locations.show', [
            'tabs' => World::all()->map(function ($w) use($world) {
                return (object) [
                    'name' => $w->name,
                    'link' => route('many-worlds.show', $w->short_name),
                    'active' => $w->short_name === $world->short_name,
                    'shortName' => $w->short_name
                ];
            }),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'location' => $location
        ]);
    }

    public function create(World $world)
    {
        return view('many-worlds.locations.create', [
            'tabs' => World::all()->map(function ($w) use($world) {
                return (object) [
                    'name' => $w->name,
                    'link' => route('many-worlds.show', $w->short_name),
                    'active' => $w->short_name === $world->short_name,
                    'shortName' => $w->short_name
                ];
            }),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'locations' => $world->locations()->get()
        ]);
    }

    public function store(Request $request, World $world)
    {
        $location = Location::create([
            'name' => $request->name,
            'image' => $request->file('image')?->store('images'),
            'summary' => $request->summary,
            'description' => $request->description,
            'world_id' => $world->id,
            'location_id' => $request->location_id,
            'created_at' => now()
        ]);

        return redirect()->route('many-worlds.locations.show', [$world->short_name, $location->id]);
    }

    public function edit(World $world)
    {
        return view('many-worlds.edit', [
            'tabs' => World::all()->map(function ($w) use($world) {
                return (object) [
                    'name' => $w->name,
                    'link' => route('many-worlds.show', $w->short_name),
                    'active' => $w->short_name === $world->short_name,
                    'shortName' => $w->short_name
                ];
            }),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'locations' => $world->locations()->get()
        ]);
    }

    public function update(Request $request, World $world, Location $location)
    {
        $location->name = $request->name;
        $location->image = $request->file('image')?->store('images');
        $location->summary = $request->summary;
        $location->description = $request->description;
        $location->location_id = $world->location_id;
        $location->updated_at = now();
        $location->save();

        return redirect()->route('many-worlds.locations.show', [$world->short_name, $location->id]);
    }
}
