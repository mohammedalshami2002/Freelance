@extends('layouts.master')

@section('title', trans('dashboard.service_providers'))

@section('css')
    <style>
        .breadcrumb-header {
            background-color: #f8f9fa;
            border-radius: .25rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection

@section('page-header')
    @include('meesage')
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">
                            {{ trans('dashboard.dashboard') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.service_providers') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-dark table-hover mb-0">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">{{ trans('dashboard.image') }}</th>
                    <th scope="col">{{ trans('dashboard.name') }}</th>
                    <th scope="col">{{ trans('login.email') }}</th>
                    <th scope="col" class="text-center">{{ trans('dashboard.blocked') }}</th>
                    <th scope="col" class="text-center">{{ trans('dashboard.created_at') }}</th>
                    <th scope="col" class="text-center">{{ trans('dashboard.operations') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                        <td class="text-center align-middle">
                            <img src="{{ URL::asset('assets/image/Profile/' . $user->image) }}" alt="Default Image"
                                class="img-thumbnail rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td class="align-middle">{{ $user->name }}</td>
                        <td class="align-middle">{{ $user->email }}</td>
                        <td class="text-center align-middle">
                            <span class="badge {{ $user->is_blocked ? 'bg-danger' : 'bg-success' }}">
                                {{ $user->is_blocked ? trans('dashboard.yes') : trans('dashboard.no') }}
                            </span>
                        </td>
                        <td class="text-center align-middle">{{ $user->created_at->diffForHumans() }}</td>
                        <td class="text-center align-middle">
                            <div class="d-flex justify-content-center gap-2">
                                @if ($user->is_blocked)
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#unblockedBackdrop{{ $user->id }}">
                                        <i class="bi bi-unlock-fill me-1"></i>{{ trans('dashboard.unblocked') }}
                                    </button>
                                    @include('Dashboard.Admin.user.unblocked')
                                @else
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#is_blockedBackdrop{{ $user->id }}">
                                        <i class="bi bi-lock-fill me-1"></i>{{ trans('dashboard.is_blocked') }}
                                    </button>
                                    @include('Dashboard.Admin.user.is_blocked')
                                @endif

                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteBackdrop{{ $user->id }}">
                                    <i class="bi bi-trash-fill me-1"></i>
                                </button>
                                @include('Dashboard.Admin.user.delete')

                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary">
                                    <i class="bi bi-eye me-1"></i>
                                </a>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3 d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>

@endsection
