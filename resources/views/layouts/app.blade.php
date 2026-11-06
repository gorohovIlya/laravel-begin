<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; margin: 0; background: #f8f9fa; color: #1b1b18; }
        header { background: #ffffff; border-bottom: 1px solid #e5e7eb; }
        .container { max-width: 960px; margin: 0 auto; padding: 0 16px; }
        .header-inner { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; }
        .logo { font-weight: 600; font-size: 18px; text-decoration: none; color: #1b1b18; }
        nav a { margin-left: 12px; text-decoration: none; color: #1b1b18; padding: 6px 10px; border-radius: 6px; }
        nav a:hover { background: #f3f4f6; }
        main { padding: 24px 0 40px; }
        footer { border-top: 1px solid #e5e7eb; background: #ffffff; padding: 16px 0; margin-top: 40px; }
        .footer-inner { text-align: center; color: #6b7280; font-size: 14px; }
        .card { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 24px; max-width: 640px; margin: 0 auto; box-shadow: 0 1px 2px rgba(0,0,0,0.01); }
        .card-wide { max-width: 960px; }
        .text-center { text-align: center; }
        .btn { display: inline-block; background: #1b1b18; color: #ffffff; text-decoration: none; padding: 10px 18px; border-radius: 8px; border: 1px solid #1b1b18; }
        .btn:hover { background: #000000; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 6px; font-weight: 500; }
        input[type="text"] { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; }
        input[type="checkbox"] { margin-right: 8px; }
        .error { color: #dc2626; font-size: 13px; margin-top: 6px; display: block; }
        table { width: 100%; border-collapse: collapse; background: #ffffff; }
        th, td { border: 1px solid #e5e7eb; padding: 10px 12px; text-align: left; font-size: 14px; }
        th { background: #f9fafb; font-weight: 600; }
        h1 { margin-top: 0; }
    </style>
</head>
<body>
<header>
    <div class="container header-inner">
        <a href="{{ url('/') }}" class="logo">Мой первый сайт</a>
        <nav>
            <a href="{{ url('/') }}">Главная</a>
            <a href="{{ route('register') }}">Регистрация</a>
            <a href="{{ route('participants') }}">Заявки</a>
        </nav>
    </div>
</header>

<main>
    <div class="container">
        @yield('content')
    </div>
</main>

<footer>
    <div class="container footer-inner">
        &copy; {{ date('Y') }} Мой первый сайт на Laravel
    </div>
</footer>
</body>
</html>
