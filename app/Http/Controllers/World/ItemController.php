<?php

namespace App\Http\Controllers\World;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\World;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(World $world)
    {
        return view('many-worlds.items.index', [
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
            'items' => $world->items()->get()
        ]);
    }

    public function show(World $world, Item $item)
    {
        return view('many-worlds.items.show', [
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
            'item' => $item
        ]);
    }

    public function create(World $world)
    {
        return view('many-worlds.items.create', [
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
            'items' => $world->items()->get()
        ]);
    }

    public function store(Request $request, World $world)
    {
        $item = Item::create([
            'name' => $request->name,
            'summary' => $request->summary,
            'description' => $request->description,
            'world_id' => $world->id,
            'image' => $request->file('image')?->store('images'),
            'created_at' => now()
        ]);

        return redirect()->route('many-worlds.items.show', [$world->short_name, $item->id]);
    }

    public function edit(World $world, Item $item)
    {
        return view('many-worlds.items.edit', [
            'tabs' => World::all()->map(function ($w) use($world) {
                return (object) [
                    'name' => $w->name,
                    'link' => route('many-worlds.show', $w->short_name),
                    'active' => $w->short_name === $world->short_name,
                    'shortName' => $w->short_name
                ];
            }),
            'item' => $item,
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'items' => $world->items()->get()
        ]);
    }

    public function update(Request $request, World $world, Item $item)
    {
        $item->update([
            'name' => $request->name,
            'summary' => $request->summary,
            'description' => $request->description,
            'world_id' => $world->id,
            'image' => $request->file('image')?->store('images'),
            'created_at' => now()
        ]);

        return redirect()->route('many-worlds.items.show', [$world->short_name, $item->id]);
    }
}
