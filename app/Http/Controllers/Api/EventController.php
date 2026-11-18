<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query()->with(['tags'])->withCount('participants');

        if ($request->boolean('published')) {
            $query->published();
        }

        if ($request->boolean('upcoming')) {
            $query->upcoming();
        }

        $events = $query->latest()->get();

        return EventResource::collection($events);
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        $tagIds = $data['tag_ids'] ?? [];
        $commentBody = $data['comment'] ?? null;
        unset($data['tag_ids'], $data['comment']);

        $event = Event::create($data);

        if (!empty($tagIds)) {
            $event->tags()->sync($tagIds);
        }

        if ($commentBody) {
            $event->comments()->create(['body' => $commentBody]);
        }

        $event->load(['participants', 'tags', 'comments']);

        return (new EventResource($event))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Event $event)
    {
        $event->load(['participants.tags', 'participants.comments', 'tags', 'comments']);

        return new EventResource($event);
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $data = $request->validated();
        $tagIds = $data['tag_ids'] ?? null;
        $commentBody = $data['comment'] ?? null;
        unset($data['tag_ids'], $data['comment']);

        $event->update($data);

        if (is_array($tagIds)) {
            $event->tags()->sync($tagIds);
        }

        if ($commentBody) {
            $event->comments()->create(['body' => $commentBody]);
        }

        $event->load(['participants', 'tags', 'comments']);

        return new EventResource($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(['message' => 'Event deleted']);
    }
}
