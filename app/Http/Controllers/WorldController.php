<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\World;
use App\Http\Controllers\World\TabsController;

class WorldController extends Controller
{
    public function index()
    {
        return view('many-worlds.index', [
            'tabs' => TabsController::makeTabs(),
            'world' => null,
            'bg' => asset('/storage/images/graph-paper.jpg')
        ]);
    }

    public function show(World $world)
    {
        return view('many-worlds.show', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg')
        ]);
    }

    public function create()
    {
        return view('many-worlds.create', [
            'tabs' => TabsController::makeTabs(),
            'world' => null,
            'bg' => asset('/storage/images/graph-paper.jpg')
        ]);
    }

    public function store(Request $request)
    {
        $world = World::create([
            'name' => $request->name,
            'image' => $request->file('image') && $request->file('image')->storeAs('images', $request->short_name.'_bg.jpg'),
            'short_name' => strtolower($request->short_name),
            'article' => $request->article
        ]);

        return redirect()->route('many-worlds.show', $world->short_name);
    }

    public function edit(World $world)
    {
        return view('many-worlds.edit', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg')
        ]);
    }

    public function update(Request $request, World $world)
    {
        $world->update([
            'name' => $request->name,
            'image' => $request->file('image') != null ? $request->file('image')->storeAs('images', $request->short_name.'_bg.jpg') : $world->image,
            'short_name' => strtolower($request->short_name),
            'article' => $request->article
        ]);

        return redirect()->route('many-worlds.show', $world->short_name);
    }

    public function destroy(World $world)
    {
        $world->delete();

        return redirect()->route('many-worlds.index');
    }
}
