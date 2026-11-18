<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'nullable|integer|exists:events,id',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^(?:\+7|8)\d{10}$/'],
            'agreed' => 'sometimes|boolean',
            'tag_ids' => 'sometimes|array',
            'tag_ids.*' => 'integer|exists:tags,id',
            'comment' => 'sometimes|string|max:1000',
        ];
    }
}
