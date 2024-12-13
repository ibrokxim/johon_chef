@extends('admin.layouts.app')

@section('title')
    настройки
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Настройки</h1>
                    </div>

                </div>
            </div>
        </div>

        @if(session('success'))
            <span id="events" data-message="{{ session('success') }}" data-action="success"></span>
        @endif

        @if(session('error'))
            <span id="events" data-message="{{ session('error') }}" data-action="error"></span>
        @endif

    <!-- Main content -->
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
                                        <form class="form-horizontal" action="{{ route('setting_update', [$setting?->id]) }}" method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="row">

                                                <div class="form-group col-md">
                                                    <label for="markup[public_offer_title]" class="col-sm-12 col-form-label">Публичная оферта заголовок</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="markup[public_offer_title]" class="form-control" id="markup[public_offer_title]" value="{{ $setting->markup?->public_offer_title ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="form-group col-md">
                                                    <label for="markup[public_offer]" class="col-sm-12 col-form-label">Публичная оферта</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="markup[public_offer]" class="form-control" id="markup[public_offer]" value="{{ $setting->markup?->public_offer ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="form-group col-md">
                                                    <label for="markup[manager]" class="col-sm-12 col-form-label">Контакт менеджера</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="markup[manager]" class="form-control" id="markup[manager]" value="{{ $setting->markup?->manager ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="form-group col-md">
                                                    <label for="markup[youtube_link]" class="col-sm-12 col-form-label">Видео - инструкция youtube</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="markup[youtube_link]" class="form-control" id="markup[youtube_link]" value="{{ $setting->markup?->youtube_link ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="form-group col-md">
                                                    <label for="markup[video_link]" class="col-sm-12 col-form-label">Видео - инструкция (mp4)</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="markup[video_link]" class="form-control" id="markup[video_link]" value="{{ $setting->markup?->video_link ?? '' }}">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="markup[greetings]">Приветствие</label>
                                                    <textarea id="markup[greetings]" class="form-control summernote" name="markup[greetings]">{{ $setting->markup->greetings ?? ''}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="markup[about]">О канале</label>
                                                    <textarea id="markup[about]" class="form-control summernote" name="markup[about]">{{ $setting->markup->about ?? ''}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="markup[tariff_description]">Описание тарифов</label>
                                                    <textarea id="markup[tariff_description]" class="form-control summernote" name="markup[tariff_description]">{{ $setting->markup->tariff_description ?? ''}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="markup[payment]">Описание оплаты</label>
                                                    <textarea id="markup[payment]" class="form-control summernote" name="markup[payment]">{{ $setting->markup->payment ?? ''}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-primary">Сохранить</button>
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
