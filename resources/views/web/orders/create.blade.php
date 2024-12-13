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

    <div class="form-container">
        <div class="form-box container">
            @if($order)
            <h2 class="text-center">{{ $order->plan->name }}</h2>
            <br>
            <pre class="text-center">{{ number_format($order->plan->price, 0, '', ' ') }}</pre>
            <br>
            <p class="text-center">{{ $order->plan?->description }}</p>
            <hr>
            <div class="text-center mt-4">
                <form method="POST" action="https://checkout.paycom.uz">
                    <input type="hidden" name="merchant" value="{{ env('PAYME_MERCHANT_ID') }}">
                    <input type="hidden" name="amount" value="{{ intval($order->price * 100) }}">
                    <input type="hidden" name="account[order_id]" value="{{ $order->id }}">
                    <input type="hidden" name="account[user_id]" value="{{ $user->id }}">
                    <button class="btn btn-primary" id="submitPayment">To'lash</button>
                </form>
            </div>
            @else
                <h2>Hech narsa topilmadi</h2>
            @endif
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
</html>