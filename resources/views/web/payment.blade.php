@extends('web.layouts.app')

@section('content')

    <div class="form-container">
        <div class="form-box container">
            <!-- Gutter g-1 -->
            <div class="row g-1 mt-3">
                <div class="col">
                    <!-- Card Number input -->
                    <div data-mdb-input-init class="form-outline">
                        <input type="text" id="card" class="form-control" placeholder="0000 0000 0000 0000">
                    </div>
                </div>
            </div>

            <div class="row g-1 mt-3">

                <div class="col">
                    <!-- Card Number input -->
                    <div data-mdb-input-init class="form-outline">
                        <input type="text" id="expirense" class="form-control" placeholder="00/00">
                    </div>
                </div>
            </div>

            <hr />

            <div class="info-text">
                To’lovlar faqatgina UzCard va Humo kartalari orqali amalga oshiriladi.<br />
                Xavfsizlik maqsadida sizning bank kartangiz ma’lumotlari PayMe xizmatining serverlarida saqlanadi.<br />
                <a target="_blank" href="https://cdn.payme.uz/terms/main.html?target=_blank">Payme ofertasi</a>
            </div>

            <div class="logo-container">
                <img src="{{ asset('assets/img/payme.png') }}" alt="Payme Logo">
                <div class="powered-by">Powered by Payme</div>
            </div>

            <!-- Кнопка отправки данных (без action) -->
            <div class="text-center mt-4">
                <button class="btn btn-primary" id="submitPayment">Оплатить</button>
            </div>

        </div>
    </div>
@endsection
