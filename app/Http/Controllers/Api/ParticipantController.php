<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use App\Http\Resources\ParticipantResource;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $query = Participant::query()->with(['event', 'tags']);

        if ($request->boolean('agreed')) {
            $query->agreed();
        }

        if ($request->filled('event_id')) {
            $query->forEvent($request->integer('event_id'));
        }

        $query->recent();

        $participants = $query->get();

        return ParticipantResource::collection($participants);
    }

    public function store(StoreParticipantRequest $request)
    {
        $data = $request->validated();
        $tagIds = $data['tag_ids'] ?? [];
        $commentBody = $data['comment'] ?? null;
        unset($data['tag_ids'], $data['comment']);

        $data['agreed'] = $request->boolean('agreed');

        $participant = Participant::create($data);

        if (!empty($tagIds)) {
            $participant->tags()->sync($tagIds);
        }

        if ($commentBody) {
            $participant->comments()->create(['body' => $commentBody]);
        }

        $participant->load(['event', 'tags', 'comments']);

        return (new ParticipantResource($participant))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Participant $participant)
    {
        $participant->load(['event', 'tags', 'comments']);

        return new ParticipantResource($participant);
    }

    public function update(UpdateParticipantRequest $request, Participant $participant)
    {
        $data = $request->validated();
        $tagIds = $data['tag_ids'] ?? null;
        $commentBody = $data['comment'] ?? null;
        unset($data['tag_ids'], $data['comment']);

        if ($request->has('agreed')) {
            $data['agreed'] = $request->boolean('agreed');
        }

        $participant->update($data);

        if (is_array($tagIds)) {
            $participant->tags()->sync($tagIds);
        }

        if ($commentBody) {
            $participant->comments()->create(['body' => $commentBody]);
        }

        $participant->load(['event', 'tags', 'comments']);

        return new ParticipantResource($participant);
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();

        return response()->json(['message' => 'Participant deleted']);
    }
}
