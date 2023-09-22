<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\World;

class WorldController extends Controller
{
    public function index()
    {
        return view('many-worlds.index', [
            'tabs' => World::all()->map(function ($w) {
                return (object) [
                    'name' => $w->name,
                    'link' => route('many-worlds.show', $w->short_name),
                    'active' => false,
                    'shortName' => $w->short_name
                ];
            }),
            'world' => null,
            'bg' => asset('/storage/images/graph-paper.jpg')
        ]);
    }

    public function show(World $world)
    {
        return view('many-worlds.show', [
            'tabs' => World::all()->map(function ($w) use($world) {
                return (object) [
                    'name' => $w->name,
                    'link' => route('many-worlds.show', $w->short_name),
                    'active' => $w->short_name === $world->short_name,
                    'shortName' => $w->short_name
                ];
            }),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg')
        ]);
    }

    public function create()
    {
        return view('many-worlds.create', [
            'tabs' => World::all()->map(function ($w) {
                return (object) [
                    'name' => $w->name,
                    'link' => route('many-worlds.show', $w->short_name),
                    'active' => false,
                    'shortName' => $w->short_name
                ];
            }),
            'world' => null,
            'bg' => asset('/storage/images/graph-paper.jpg')
        ]);
    }

    public function store(Request $request)
    {
        $world = World::create([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'article' => $request->article
        ]);

        return redirect()->route('many-worlds.show', $world->short_name);
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
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg')
        ]);
    }

    public function update(Request $request, World $world)
    {
        $world->update([
            'name' => $request->name,
            'short_name' => $request->short_name,
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
