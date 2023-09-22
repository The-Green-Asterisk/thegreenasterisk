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
        return view('many-worlds.characters.index', [
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
            'characters' => $world->characters()->get()
        ]);
    }

    public function show(World $world, Character $character)
    {
        return view('many-worlds.characters.show', [
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
            'character' => $character
        ]);
    }

    public function create(World $world)
    {
        return view('many-worlds.characters.create', [
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
            'locations' => $world->locations()->get(),
            'organizations' => $world->organizations()->get()
        ]);
    }

    public function store(World $world, Character $character)
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
        return view('many-worlds.characters.edit', [
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
            'character' => $character
        ]);
    }

    public function update(Request $request, World $world, Character $character)
    {
        $character->name = $request->name;
        $character->image = $request->file('image')?->store('images');
        $character->summary = $request->summary;
        $character->description = $request->description;
        $character->location_id = $request->location_id;
        $character->organization_id = $request->organization_id;
        $character->updated_at = now();
        $character->save();

        return redirect()->route('many-worlds.characters.show', [$world->short_name, $character->id]);
    }
}
