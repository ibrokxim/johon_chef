@extends('admin.layouts.app')

@section('title')
    Пользователи
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Пользователи</h1>
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
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Имя</th>
                                            <th>Статус</th>
                                            <th>Рефералов</th>
                                            <th>Подписка до:</th>
                                            <th style="text-align: right">Действие</th></tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td style="vertical-align: middle;">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td> <!-- Порядковый номер с учётом пагинации -->
                                                    <td style="vertical-align: middle;">{{ $user->name }}</td>
                                                    <td style="vertical-align: middle;">
                                                        @if($user->status)
                                                        <span class="bg-success p-1">Активен</span>
                                                        @else
                                                        <span class="bg-danger p-1">Не активен</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $user?->referrals?->count() }}</td>
                                                    <td>
                                                        @if($user->activeSubscription)
                                                        <mark>{{ $user->activeSubscription?->ends_at?->format('d.m.Y') }}</mark>
                                                        @else
                                                        <mark>Без подписки</mark>
                                                        @endif
                                                    </td>
                                                    <td style="width: 5%; vertical-align: middle;">
                                                        <a href="{{ route('users_edit', [$user->id]) }}" style="padding: 0 15px;"><i class="fas fa-pen"></i></a>
{{--                                                        @if(auth()->user()->role->isAdmin())--}}
{{--                                                            <a href="{{ route('users_delete', [$user->id]) }}" onclick="return confirm('Вы уверены, что хотите удалить пользователя {{ $user->name }}?');"><i class="fa fa-trash"></i></a>--}}
{{--                                                        @endif--}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card-footer clearfix d-flex justify-content-end">
                                    {{ $users->appends(request()->input())->links('pagination::bootstrap-5') }}
                                </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
