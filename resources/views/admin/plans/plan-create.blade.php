@extends('admin.layouts.app')

@section('title')
    создание тарифа
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Создание тарифа</h1>
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
                                        <form class="form-horizontal" action="{{ route('plans_store') }}" method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-form-label">Имя</label>
                                                <div class="col-sm-12">
                                                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                                                    @if($errors->has('name'))<span class="text-danger"> {{ $errors->first('name') }}</span>@endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="description"><u>Описание</u></label>
                                                    <textarea id="description" class="form-control summernote" name="description">{{ old('description') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="duration" class="col-sm-2 col-form-label">Срок (месяц)</label>
                                                <div class="col-sm-12">
                                                    <input type="number" name="duration" class="form-control" id="price" value="{{ old('duration') }}">
                                                    @if($errors->has('duration'))<span class="text-danger"> {{ $errors->first('duration') }}</span>@endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="price" class="col-sm-2 col-form-label">Цена</label>
                                                <div class="col-sm-12">
                                                    <input type="number" name="price" class="form-control" id="price" value="{{ old('price') }}">
                                                    @if($errors->has('price'))<span class="text-danger"> {{ $errors->first('price') }}</span>@endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                                    <a href="{{ route('plans_admin') }}" type="submit" class="btn btn-primary">Отменить</a>
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