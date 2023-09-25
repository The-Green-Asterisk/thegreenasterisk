<?php

namespace App\Http\Controllers\World;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\World;
use App\Models\Event;

class EventController extends Controller
{
    public function index(World $world)
    {
        if ($world->events()->count() === 0) {
            return redirect()->route('many-worlds.events.create', $world->short_name);
        }
        return view('many-worlds.asset.index', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'assets' => $world->events()->get(),
            'type' => 'events'
        ]);
    }

    public function show(World $world, Event $event)
    {
        return view('many-worlds.asset.show', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'asset' => $event,
            'type' => 'events'
        ]);
    }

    public function create(World $world)
    {
        return view('many-worlds.asset.create', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'type' => 'events'
        ]);
    }

    public function store(Request $request, World $world)
    {
        $event = Event::create([
            'name' => $request->name,
            'summary' => $request->summary,
            'description' => $request->description,
            'image' => $request->file('image')?->store('images'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'world_id' => $world->id
        ]);

        return redirect()->route('many-worlds.events.show', [
            'world' => $world->short_name,
            'event' => $event->id
        ]);
    }

    public function edit(World $world, Event $event)
    {
        return view('many-worlds.asset.edit', [
            'tabs' => TabsController::makeTabs($world),
            'world' => $world,
            'bg' => asset('/storage/images/'.$world->short_name.'_bg.jpg'),
            'asset' => $event,
            'type' => 'events'
        ]);
    }

    public function update(Request $request, World $world, Event $event)
    {
        $event->name = $request->name;
        $event->summary = $request->summary;
        $event->description = $request->description;
        $event->image = $request->file('image')?->store('images');
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->world_id = $request->world_id;
        $event->save();

        return redirect()->route('many-worlds.events.show', [
            'world' => $event->world,
            'event' => $event
        ]);
    }

    public function destroy(World $world, Event $event)
    {
        $event->delete();
        return redirect()->route('many-worlds.events.index', $world->short_name);
    }
}
