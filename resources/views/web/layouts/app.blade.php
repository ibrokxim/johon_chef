<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Jahon Chef community bot</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
{{--    <link rel="stylesheet" href="https://655b-84-54-78-4.ngrok-free.app/assets/css/style.css">--}}
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <script>
        let tg = window?.Telegram.WebApp?.initData;
    </script>
</head>
<body>
<style>
    body, html {
        height: 100%;
    }
    .form-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .form-box {
        max-width: 600px;
        width: 100%;
    }
    .info-text {
        margin-top: 20px;
        text-align: center;
        font-size: 14px;
        color: #555;
    }
    .info-text a {
        color: #007bff;
        text-decoration: none;
    }
    .info-text a:hover {
        text-decoration: underline;
    }
    .logo-container {
        text-align: center;
        margin-top: 20px;
    }
    .logo-container img {
        width: 100px;
    }
    .powered-by {
        font-size: 12px;
        color: #555;
        margin-top: 10px;
    }
</style>
    @auth
        @yield('content')
    @else
        <img src="{{ asset('cms/favicon/favicon.png') }}" style="width: 100%;height: 100%;object-fit: contain;">
    @endauth
</body>

<script>
    // Получаем ссылку на кнопку
    document.getElementById('closeButton')?.addEventListener('click', function(event) {
        event.preventDefault(); // Отключаем стандартное поведение кнопки

        // Закрываем веб-приложение в Telegram
        if (window?.Telegram?.WebApp) {
            window.Telegram.WebApp.close();
        } else {
            console.log('Telegram WebApp API не поддерживается.');
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
{{--<script src="https://655b-84-54-78-4.ngrok-free.app/assets/js/app.js"></script>--}}
</html>
