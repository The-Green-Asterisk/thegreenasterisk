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
        return view('many-worlds.events.index', [
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
            'events' => $world->events()->get()
        ]);
    }

    public function show(World $world, Event $event)
    {
        return view('many-worlds.events.show', [
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
            'event' => $event
        ]);
    }

    public function create(World $world)
    {
        return view('many-worlds.events.create', [
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
            'events' => $world->events()->get()
        ]);
    }

    public function store(Request $request)
    {
        $event = Event::create([
            'name' => $request->name,
            'summary' => $request->summary,
            'description' => $request->description,
            'image' => $request->file('image')?->store('images'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'world_id' => $request->world_id
        ]);

        return redirect()->route('many-worlds.events.show', [
            'world' => $event->world,
            'event' => $event
        ]);
    }

    public function edit(World $world, Event $event)
    {
        return view('many-worlds.events.edit', [
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
            'event' => $event
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
}
