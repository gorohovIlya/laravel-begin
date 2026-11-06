@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Регистрация</h1>
    <form method="POST" action="{{ route('register.handle') }}">
        @csrf

        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
            @error('name')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="lastname">Фамилия</label>
            <input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}">
            @error('lastname')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">Номер телефона</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="+7XXXXXXXXXX или 8XXXXXXXXXX">
            @error('phone')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="agreed" id="agreed" value="1" {{ old('agreed') ? 'checked' : '' }}>
                Я согласен с обработкой персональных данных
            </label>
            @error('agreed')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn">Отправить</button>
    </form>
</div>
@endsection
