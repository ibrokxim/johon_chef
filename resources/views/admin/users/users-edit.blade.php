@extends('admin.layouts.app')

@section('title')
    просмотр профиля
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Просмотр профиля</h1>
                    </div>

                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                    <li class="nav-item active">
                                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Основное</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-three-tabContent">

                                    <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                        @if($errors->has('error'))<div class="alert alert-danger"> {{ $errors->first('error') }}</div>@endif
                                        <form class="form-horizontal" action="{{ route('users_update', [$user->id]) }}" method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="status"><u>Статус</u></label>
                                                    <select class="custom-select rounded-0 js-select" name="status" id="status">
                                                        <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Включен</option>
                                                        <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Скрыт</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-form-label">Имя</label>
                                                <div class="col-sm-12">
                                                    <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}">
                                                    @if($errors->has('name'))<span class="text-danger"> {{ $errors->first('name') }}</span>@endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-12">
                                                    <input type="text" name="email" class="form-control" id="email" value="{{ $user->email }}">
                                                    @if($errors->has('email'))<span class="text-danger"> {{ $errors->first('email') }}</span>@endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                @if( $user?->activeSubscription)
                                                <input type="hidden" name="ends_at" value="{{ $user?->activeSubscription?->ends_at?->format('Y-m-d') }}">
                                                <label for="date" class="col-sm-12 col-form-label">Подписан до:</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" id="daterange" name="daterange" value="{{ $user?->activeSubscription?->ends_at?->format('d.m.Y') }}">
                                                </div>
                                                @else
                                                <div class="col-sm-12">
                                                    <p>
                                                        <mark>Без подписки</mark>
                                                    </p>
                                                </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="ends_at" class="col-sm-2 col-form-label">Рефералы:</label>
                                                <div class="col-sm-12">
                                                    @if($user->referrals->isNotEmpty())
                                                    @foreach($user->referrals as $referral)
                                                    <p><mark>
                                                        <a href="{{ route('users_edit', $referral->id) }}">{{ $referral->name }}</a>
                                                    </mark></p>
                                                    @endforeach
                                                    @else
                                                        <p><mark>0</mark></p>
                                                    @endif
                                                </div>
                                            </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary">Сохранить</button>
                                            <a href="{{ route('users_admin') }}" type="submit" class="btn btn-primary">Отменить</a>
                                        </div>
                                    </div>

                                    </form>

                                </div>
                            </div>

                        </div>


                    </div>
                </div>

            </div>

            </div>

        </section>

    </div>
@endsection
