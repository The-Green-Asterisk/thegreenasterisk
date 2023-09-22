<?php

namespace App\Http\Controllers\World;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\World;
use App\Models\Organization;

class OrganizationController extends Controller
{
    public function index(World $world)
    {
        return view('many-worlds.organizations.index', [
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
            'organizations' => $world->organizations()->get()
        ]);
    }

    public function show(World $world, Organization $organization)
    {
        return view('many-worlds.organizations.show', [
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
            'organization' => $organization
        ]);
    }

    public function create(World $world)
    {
        return view('many-worlds.organizations.create', [
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
            'characters' => $world->characters()->get(),
            'locations' => $world->locations()->get()
        ]);
    }

    public function store(Request $request, World $world)
    {
        $organiation = Organization::create([
            'name' => $request->name,
            'summary' => $request->summary,
            'description' => $request->description,
            'world_id' => $world->id,
            'location_id' => $request->location_id,
            'leader_id' => $request->leader_id,
            'image' => $request->file('image')?->store('images'),
            'created_at' => now()
        ]);

        return redirect()->route('many-worlds.organizations.show', [$world->short_name, $organization->id]);
    }

    public function edit(World $world, Organization $organization)
    {
        return view('many-worlds.organizations.edit', [
            'tabs' => World::all()->map(function ($w) use($world) {
                return (object) [
                    'name' => $w->name,
                    'link' => route('many-worlds.show', $w->short_name),
                    'active' => $w->short_name === $world->short_name,
                    'shortName' => $w->short_name
                ];
            }),
            'organization' => $organization,
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'characters' => $world->characters()->get(),
            'locations' => $world->locations()->get()
        ]);
    }

    public function update(Request $request, World $world, Organization $organization)
    {
        $organization->update([
            'name' => $request->name,
            'summary' => $request->summary,
            'description' => $request->description,
            'world_id' => $world->id,
            'location_id' => $request->location_id,
            'leader_id' => $request->leader_id,
            'image' => $request->file('image')?->store('images'),
            'created_at' => now()
        ]);

        return redirect()->route('many-worlds.organizations.show', [$world->short_name, $organization->id]);
    }
}
