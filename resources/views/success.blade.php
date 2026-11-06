@extends('layouts.app')

@section('content')
<div class="card text-center">
    <h1>Регистрация прошла успешно</h1>
    <div style="margin-top: 24px;">
        <a href="{{ url('/') }}" class="btn">Вернуться на главную</a>
    </div>
</div>
@endsection
