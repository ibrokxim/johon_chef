<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Telegram</title>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <script>
        let tg = window?.Telegram.WebApp?.initData;
    </script>
</head>
<body>

</body>
</html>
    <script>
        fetch('/check', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify({ telegram_data: tg })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '{{ route('cabinet') }}'
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });

    </script>
