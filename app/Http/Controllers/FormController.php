<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function show()
    {
        return view('register');
    }

    public function handle(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'regex:/^(?:\+7|8)\d{10}$/',
            ],
            'agreed' => 'accepted',
        ]);

        $event = Event::firstOrCreate(
            ['slug' => 'registration'],
            [
                'title' => 'Регистрация',
                'description' => 'Общая регистрация участников',
                'is_published' => true,
                'starts_at' => now()->addMonth(),
                'location' => 'Онлайн',
            ]
        );

        Participant::create([
            'event_id' => $event->id,
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'phone' => $data['phone'],
            'agreed' => true,
        ]);

        return redirect()->route('register.success');
    }

    public function success()
    {
        return view('success');
    }

    public function participants()
    {
        $participants = Participant::with('event')->recent()->get();

        return view('participants', ['participants' => $participants]);
    }
}
