{{--@extends('web.layouts.app')--}}

{{--@section('content')--}}

{{--    <div class="form-container">--}}
{{--        <div class="form-box container">--}}
{{--            <!-- Gutter g-1 -->--}}
{{--            <div class="row g-1 mt-3">--}}
{{--                <div class="col">--}}
{{--                    <!-- Card Number input -->--}}
{{--                    <div data-mdb-input-init class="form-outline">--}}
{{--                        <input type="text" id="card" class="form-control" placeholder="0000 0000 0000 0000">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="row g-1 mt-3">--}}

{{--                <div class="col">--}}
{{--                    <!-- Card Number input -->--}}
{{--                    <div data-mdb-input-init class="form-outline">--}}
{{--                        <input type="text" id="expirense" class="form-control" placeholder="00/00">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <hr />--}}

{{--            <div class="info-text">--}}
{{--                To’lovlar faqatgina UzCard va Humo kartalari orqali amalga oshiriladi.<br />--}}
{{--                Xavfsizlik maqsadida sizning bank kartangiz ma’lumotlari PayMe xizmatining serverlarida saqlanadi.<br />--}}
{{--                <a target="_blank" href="https://cdn.payme.uz/terms/main.html?target=_blank">Payme ofertasi</a>--}}
{{--            </div>--}}

{{--            <div class="logo-container">--}}
{{--                <img src="{{ asset('assets/img/payme.png') }}" alt="Payme Logo">--}}
{{--                <div class="powered-by">Powered by Payme</div>--}}
{{--            </div>--}}

{{--            <!-- Кнопка отправки данных (без action) -->--}}
{{--            <div class="text-center mt-4">--}}
{{--                <button class="btn btn-primary" id="submitPayment">Оплатить</button>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

@extends('web.layouts.app')

@section('content')
    <div class="form-container">
        <div class="form-box container">
            <form id="cardBindForm" method="POST">
                @csrf
                <div class="row g-1 mt-3">
                    <div class="col">
                        <div class="form-outline">
                            <label for="card_number" class="form-label">Karta raqami</label>
                            <input
                                type="text"
                                id="card_number"
                                name="card_number"
                                class="form-control"
                                placeholder="8600 0000 0000 0000"
                                required
                                pattern="\d{16}"
                                maxlength="16"
                            >
                        </div>
                    </div>
                </div>

                <div class="row g-1 mt-3">
                    <div class="col">
                        <div class="form-outline">
                            <label for="expiry" class="form-label">Amal qilish muddati</label>
                            <input
                                type="text"
                                id="expiry"
                                name="expiry"
                                class="form-control"
                                placeholder="MM/YY"
                                required
                                pattern="\d{2}/\d{2}"
                                maxlength="5"
                            >
                        </div>
                    </div>
                </div>

                <hr />

                <div class="info-text">
                    To'lovlar faqat UzCard va Humo kartalari orqali amalga oshiriladi.<br />
                    Xavfsizlik maqsadida sizning bank kartangiz ma'lumotlari xavfsiz serverda saqlanadi.<br />
                    <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Shartlar bilan tanishish</a>
                </div>

                <div class="logo-container text-center mt-3">
                    <img src="{{ asset('assets/img/atmos_logo.png') }}" alt="ATMOS Logo" style="max-width: 150px;">
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary" id="submitPayment">
                        <span id="submitText">Kartani bog'lash</span>
                        <span id="loadingSpinner" class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Terms Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xizmat shartlari</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Добавьте текст ваших условий -->
                    Karta ma'lumotlarini saqlash va foydalanish shartlari...
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('cardBindForm');
            const submitButton = document.getElementById('submitPayment');
            const submitText = document.getElementById('submitText');
            const loadingSpinner = document.getElementById('loadingSpinner');

            document.getElementById('card_number').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                e.target.value = value;
            });

            document.getElementById('expiry').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 2) {
                    value = value.slice(0, 2) + '/' + value.slice(2, 4);
                }
                e.target.value = value;
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const cardNumber = document.getElementById('card_number').value;
                const expiry = document.getElementById('expiry').value;

                if (cardNumber.length !== 16 || expiry.length !== 5) {
                    alert('Iltimos, karta ma\'lumotlarini to\'g\'ri kiriting');
                    return;
                }

                submitButton.disabled = true;
                submitText.classList.add('d-none');
                loadingSpinner.classList.remove('d-none');

                fetch('{{ route("card.bind") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        card_number: cardNumber,
                        expiry: expiry.replace('/', '')
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Karta muvaffaqiyatli bog\'landi!');

                        } else {
                            alert('Xatolik: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Tizimda xatolik yuz berdi');
                    })
                    .finally(() => {
                        submitButton.disabled = false;
                        submitText.classList.remove('d-none');
                        loadingSpinner.classList.add('d-none');
                    });
            });
        });
    </script>
@endpush
