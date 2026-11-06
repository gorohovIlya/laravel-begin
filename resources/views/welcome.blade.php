@extends('layouts.app')

@section('content')
<div class="card text-center">
    <h1>Мой первый сайт на Laravel</h1>
    <p>На Самом деле второй =)</p>
    <div style="margin-top: 24px;">
        <a href="{{ route('register') }}" class="btn">Регистрация</a>
    </div>
</div>
@endsection
