<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $tags = collect(['VIP', 'Новичок', 'Спикер', 'Онлайн', 'Студент'])->map(function ($name) {
            return Tag::create([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
            ]);
        });

        $registrationEvent = Event::create([
            'title' => 'Регистрация',
            'slug' => 'registration',
            'description' => 'Общая регистрация участников',
            'starts_at' => now()->addDays(30),
            'location' => 'Онлайн',
            'is_published' => true,
        ]);

        $conference = Event::create([
            'title' => 'Laravel Conference',
            'slug' => 'laravel-conference',
            'description' => 'Конференция по Laravel и экосистеме PHP',
            'starts_at' => now()->addDays(10),
            'location' => 'Москва',
            'is_published' => true,
        ]);

        $draftEvent = Event::create([
            'title' => 'Черновик мероприятия',
            'slug' => 'draft-event',
            'description' => 'Неопубликованное мероприятие',
            'starts_at' => now()->addDays(60),
            'location' => 'Санкт-Петербург',
            'is_published' => false,
        ]);

        $registrationEvent->tags()->sync($tags->take(2)->pluck('id'));
        $conference->tags()->sync($tags->slice(1, 3)->pluck('id'));

        $participants = Participant::factory()->count(5)->create([
            'event_id' => $conference->id,
            'agreed' => true,
        ]);

        $participants->each(function (Participant $participant, $index) use ($tags) {
            $participant->tags()->sync($tags->random(2)->pluck('id'));
            $participant->comments()->create([
                'body' => 'Комментарий к участнику #'.($index + 1),
            ]);
        });

        Participant::factory()->count(2)->create([
            'event_id' => $registrationEvent->id,
            'agreed' => true,
        ])->each(function (Participant $participant) use ($tags) {
            $participant->tags()->sync([$tags->first()->id]);
        });

        $conference->comments()->create(['body' => 'Ждём всех на конференции!']);
        $conference->comments()->create(['body' => 'Будет много интересных докладов.']);
        $registrationEvent->comments()->create(['body' => 'Добро пожаловать!']);
    }
}
