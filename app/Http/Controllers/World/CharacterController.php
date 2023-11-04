<?php

namespace App\Http\Controllers\World;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\World;
use App\Models\Character;

class CharacterController extends Controller
{
    public function index(World $world)
    {
        if ($world->characters()->count() === 0) {
            return redirect()->route('many-worlds.characters.create', $world->short_name);
        }
        return view('many-worlds.asset.index', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'assets' => $world->characters()->get(),
            'type' => 'characters'
        ]);
    }

    public function show(World $world, Character $character)
    {
        return view('many-worlds.asset.show', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'asset' => $character,
            'type' => 'characters'
        ]);
    }

    public function create(World $world)
    {
        return view('many-worlds.asset.create', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'locations' => $world->locations()->get(),
            'organizations' => $world->organizations()->get(),
            'type' => 'characters'
        ]);
    }

    public function store(Request $request, World $world)
    {
        $character = Character::create([
            'name' => $request->name,
            'image' => $request->file('image')?->store('images'),
            'summary' => $request->summary,
            'description' => $request->description,
            'world_id' => $world->id,
            'location_id' => $request->location_id,
            'organization_id' => $request->organization_id,
            'created_at' => now()
        ]);

        return redirect()->route('many-worlds.characters.show', [$world->short_name, $character->id]);
    }

    public function edit(World $world, Character $character)
    {
        return view('many-worlds.asset.edit', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'locations' => $world->locations()->get(),
            'organizations' => $world->organizations()->get(),
            'asset' => $character,
            'type' => 'characters'
        ]);
    }

    public function update(Request $request, World $world, Character $character)
    {
        $character->world_id = $world->id;
        $character->name = $request->name;
        $character->image = $request->file('image') != null ? $request->file('image')->store('images') : $character->image;
        $character->summary = $request->summary;
        $character->description = $request->description;
        $character->location_id = $request->location_id;
        $character->organization_id = $request->organization_id;
        $character->updated_at = now();
        $character->save();

        return redirect()->route('many-worlds.characters.show', [$world->short_name, $character->id]);
    }

    public function destroy(World $world, Character $character)
    {
        $character->delete();
        return redirect()->route('many-worlds.characters.index', $world->short_name);
    }
}
