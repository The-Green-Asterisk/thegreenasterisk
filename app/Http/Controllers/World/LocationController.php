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
        if ($world->locations()->count() === 0) {
            return redirect()->route('many-worlds.locations.create', $world->short_name);
        }
        return view('many-worlds.asset.index', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'assets' => $world->locations()->get(),
            'type' => 'locations'
        ]);
    }

    public function show(World $world, Location $location)
    {
        return view('many-worlds.asset.show', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'asset' => $location,
            'type' => 'locations'
        ]);
    }

    public function create(World $world)
    {
        return view('many-worlds.asset.create', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'locations' => $world->locations()->get(),
            'type' => 'locations'
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
            'location_id' => $request->parent_location,
            'created_at' => now()
        ]);

        return redirect()->route('many-worlds.locations.show', [$world->short_name, $location->id]);
    }

    public function edit(World $world, Location $location)
    {
        return view('many-worlds.asset.edit', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'asset' => $location,
            'locations' => $world->locations()->get(),
            'type' => 'locations'
        ]);
    }

    public function update(Request $request, World $world, Location $location)
    {
        $location->name = $request->name;
        $location->image = $request->file('image')?->store('images');
        $location->summary = $request->summary;
        $location->description = $request->description;
        $location->location_id = $request->parent_location;
        $location->updated_at = now();
        $location->save();

        return redirect()->route('many-worlds.locations.show', [$world->short_name, $location->id]);
    }

    public function destroy(World $world, Location $location)
    {
        $location->delete();
        return redirect()->route('many-worlds.locations.index', $world->short_name);
    }
}
