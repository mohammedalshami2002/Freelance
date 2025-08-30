@extends('layouts.master')

@section('title', trans('dashboard.clients'))

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
                <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.clients') }}</li>
            </ol>
        </nav>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-dark table-hover mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col">{{ trans('dashboard.image') }}</th>
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
                <td class="align-middle">
                    <img src="{{ URL::asset('assets/image/Profile/' . $user->image) }}"
                        alt="Default Image"
                        class="img-thumbnail rounded-circle"
                        style="width: 50px; height: 50px; object-fit: cover;">
                </td>
                <td class="align-middle">{{ $user->name }}</td>
                <td class="align-middle">{{ $user->email }}</td>
                <td class="text-center align-middle">
                    @if ($user->is_blocked)
                    <span class="badge bg-danger">{{ trans('dashboard.yes') }}</span>
                    @else
                    <span class="badge bg-success">{{ trans('dashboard.no') }}</span>
                    @endif
                </td>
                <td class="text-center align-middle">{{ $user->created_at->diffForHumans() }}</td>
                <td class="text-center align-middle d-flex justify-content-center gap-2">
                    @if ($user->is_blocked)
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#unblockedBackdrop{{$user->id}}">
                        {{ trans('dashboard.unblocked') }}
                    </button>
                    @else
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#is_blockedBackdrop{{$user->id}}">
                        {{ trans('dashboard.is_blocked') }}
                    </button>
                    @endif
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteBackdrop{{$user->id}}">
                        {{ trans('dashboard.delete') }}
                    </button>
                </td>
                @include('Dashboard.Admin.user.delete')
                @include('Dashboard.Admin.user.is_blocked')
                @include('Dashboard.Admin.user.unblocked')
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3 d-flex justify-content-center">
        {{$users->links()}}
    </div>
</div>

@endsection
