@extends('web.layouts.app')

@section('content')
    <div class="wrapper">
        <header class="header">
            <div class="header__container">
            </div>
        </header>
        <main class="page">

            <section class="profile">
                <div class="profile__container">
                    <a href="#" class="page__back _icon-back" id="closeButton"></a>

                    <h1 class="profile__title title">Sizning hisobingiz</h1>

                    <p>{{ auth()->user()?->name }}</p>
                    <div class="profile__referal referal">

                        <div class="referal__title">Mening referal havolam</div>
                        <div class="referal__link" style="display:none; margin-bottom: 10px;">
                            <input type="text" id="referralLink" readonly>
                        </div>
                        <div class="referal__buttons">
                            <button id="inviteFriend" class="referal__button button">Do'stimni chaqirish</button>
                            <button id="copyLink" class="referal__copy button _icon-copy" style="display:none;">
                            </button>
                        </div>

                    </div>

                    <div class="profile__blocks">
                        <div class="profile__block block-profile">
                            <div class="block-profile__users">
                                <div class="block-profile__icon _icon-user"></div>
                                <b>{{ auth()->user()?->referrals?->count() }}</b>
                            </div>
                            <div class="block-profile__text">havola orqali kelishdi</div>

                            <a href="{{ route('referrals') }}" class="block-profile__link">Посмотреть</a>
                        </div>
                        <div class="profile__block block-profile">
                            <div class="block-profile__text"><b>{{ auth()->user()?->activeSubscription?->ends_at?->format('d.m.Y') }}</b> Gacha</div>

                            <div class="block-profile__text">Bonus oylar soni</div>
                        </div>
                    </div>


                </div>
            </section>

        </main>
        <footer class="footer">
            <div class="footer__container">
            </div>
        </footer>
    </div>

    <script>
        document.getElementById('inviteFriend').addEventListener('click', function () {
            fetch('/referrals/link', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Если нужен CSRF токен
                },
                body: JSON.stringify({}) // Можно отправить дополнительные данные, если нужно
            })
                .then(response => response.json())
                .then(data => {
                    const referralLink = data.referral_link;
                    const linkInput = document.getElementById('referralLink');
                    const copyButton = document.getElementById('copyLink');

                    // Показать input с ссылкой
                    linkInput.value = referralLink;
                    document.querySelector('.referal__link').style.display = 'block';

                    // Показать кнопку "Скопировать"
                    copyButton.style.display = 'inline-block';
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                });
        });

        document.getElementById('copyLink').addEventListener('click', function () {
            const referralInput = document.getElementById('referralLink');

            // Выделить текст в input
            referralInput.select();
            referralInput.setSelectionRange(0, 99999); // Для мобильных устройств

            // Скопировать текст в буфер обмена
            document.execCommand('copy');

            // Изменение текста кнопки на "Скопированный текст"
            this.setAttribute('data-copy', referralInput.value);
        });
    </script>
@endsection