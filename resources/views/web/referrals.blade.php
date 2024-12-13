@extends('web.layouts.app')

@section('content')
    <div class="wrapper">
        <header class="header">
            <div class="header__container">
            </div>
        </header>
        <main class="page">

            <section class="users">
                <div class="profile__container">
                    <a href="{{ route('cabinet') }}" class="page__back _icon-back"></a>

                    <h1 class="users__title title">Foydalanuvchilar</h1>

                    <div class="users__items">
                        @foreach(auth()->user()->referrals as $item)
                        <div class="users__item item-user">
                            <div class="item-user__name">ID:{{ $item->id }}</div>

                            <div class="item-user__data">
                                <div class="item-user__text">Ro'yxatdan o'tish sanasi:</div>
                                <div class="item-user__num">{{ $item?->created_at?->format('d.m.Y') }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>


                </div>
            </section>

        </main>
        <footer class="footer">
            <div class="footer__container">
            </div>
        </footer>
    </div>
@endsection