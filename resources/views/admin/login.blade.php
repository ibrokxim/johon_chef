<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- favicon --}}
    <link rel="icon" href="{{ asset('cms/favicon/favicon.png') }}">
    <title>Jahon Chef - вход</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="{{ asset('cms/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/dist/css/main.css') }}">
</head>

<body>
<div class="login-container login-page" style="background: url('{{ asset('cms/dist/img/login.jpg') }}'); background-size: cover; background-repeat: no-repeat;">
    <div class="mask rgba-gradient d-flex justify-content-center align-items-center">
        <div class="login-box">
            <div class="login-card-body">
                <div class="login-logo logo mb-4">
                    <img src="{{ asset('cms/favicon/favicon.png') }}" width="100" alt="">
                </div>
                <style>
                    .alert {
                        position: relative;
                        padding: 0.75rem 1.25rem;
                        margin-bottom: 1rem;
                        border: 1px solid transparent;
                        border-radius: 0.25rem;
                        opacity: 1;
                        right: 0;
                    }
                    .alert-danger {
                        --bs-alert-color: #842029;
                        --bs-alert-bg: #f8d7da;
                        --bs-alert-border-color: #f5c2c7;
                    }
                    .alert .alert-danger {
                        color: #fff;
                        background-color: #dc3545;
                        border-color: #d32535;
                    }
                </style>
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
                <form action="{{ route('admin_auth') }}" method="POST">
                    @csrf
                    <div class="input-group mb-2">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-4 password">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Пароль" value="">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-end">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Вход</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('focus', (event) => {
        if (event.target.matches('.form-control')) {
            event.target.classList.add('admin_auth');
        }
    }, true);

    document.addEventListener('blur', (event) => {
        if (event.target.matches('.form-control')) {
            event.target.classList.remove('admin_auth');
        }
    }, true);


</script>

</body>
</html>