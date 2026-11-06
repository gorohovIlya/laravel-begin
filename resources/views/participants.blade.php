@extends('layouts.app')

@section('content')
<div class="card card-wide">
    <h1>Список участников</h1>
    @if(empty($participants))
        <p>Пока нет зарегистрированных участников.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Телефон</th>
                    <th>Согласие</th>
                    <th>Дата регистрации</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participants as $participant)
                    <tr>
                        <td>{{ $participant['name'] ?? '' }}</td>
                        <td>{{ $participant['lastname'] ?? '' }}</td>
                        <td>{{ $participant['phone'] ?? '' }}</td>
                        <td>{{ !empty($participant['agreed']) ? 'Да' : 'Нет' }}</td>
                        <td>{{ $participant['created_at'] ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
