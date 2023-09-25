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
        if ($world->items()->count() === 0) {
            return redirect()->route('many-worlds.items.create', $world->short_name);
        }
        return view('many-worlds.asset.index', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'assets' => $world->items()->get(),
            'type' => 'items'
        ]);
    }

    public function show(World $world, Item $item)
    {
        return view('many-worlds.asset.show', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'asset' => $item,
            'type' => 'items'
        ]);
    }

    public function create(World $world)
    {
        return view('many-worlds.asset.create', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'type' => 'items'
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
        return view('many-worlds.asset.edit', [
            'tabs' => TabsController::makeTabs($world),
            'asset' => $item,
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'items' => $world->items()->get(),
            'type' => 'items'
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

    public function destroy(World $world, Item $item)
    {
        $item->delete();
        return redirect()->route('many-worlds.items.index', $world->short_name);
    }
}
