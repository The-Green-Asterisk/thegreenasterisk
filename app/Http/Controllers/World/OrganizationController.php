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
        if ($world->organizations()->count() === 0) {
            return redirect()->route('many-worlds.organizations.create', $world->short_name);
        }
        return view('many-worlds.asset.index', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'assets' => $world->organizations()->get(),
            'type' => 'organizations'
        ]);
    }

    public function show(World $world, Organization $organization)
    {
        return view('many-worlds.asset.show', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'asset' => $organization,
            'type' => 'organizations'
        ]);
    }

    public function create(World $world)
    {
        return view('many-worlds.asset.create', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'characters' => $world->characters()->get(),
            'locations' => $world->locations()->get(),
            'type' => 'organizations'
        ]);
    }

    public function store(Request $request, World $world)
    {
        $organization = Organization::create([
            'name' => $request->name,
            'summary' => $request->summary,
            'description' => $request->description,
            'world_id' => $world->id,
            'location_id' => $request->parent_location,
            'leader_id' => $request->leader,
            'image' => $request->file('image')?->store('images'),
            'created_at' => now()
        ]);

        return redirect()->route('many-worlds.organizations.show', [$world->short_name, $organization->id]);
    }

    public function edit(World $world, Organization $organization)
    {
        return view('many-worlds.asset.edit', [
            'tabs' => TabsController::makeTabs($world),
            'asset' => $organization,
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'characters' => $world->characters()->get(),
            'locations' => $world->locations()->get(),
            'type' => 'organizations'
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

    public function destroy(World $world, Organization $organization)
    {
        $organization->delete();
        return redirect()->route('many-worlds.organizations.index', $world->short_name);
    }
}
