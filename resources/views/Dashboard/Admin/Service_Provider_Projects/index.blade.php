@extends('layouts.master')

@section('title', trans('dashboard.Service_Provider_Projects'))

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
                <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.Service_Provider_Projects') }}</li>
            </ol>
        </nav>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-dark table-hover mb-0">
        <thead>
            <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col">{{ trans('dashboard.name') }}</th>
                <th scope="col">{{ trans('login.email') }}</th>
                <th scope="col">{{ trans('dashboard.service_name') }}</th>
                <th scope="col">{{ trans('dashboard.description') }}</th>
                <th scope="col">{{ trans('dashboard.price') }}</th>
                <th scope="col">{{ trans('dashboard.categorie') }}</th>
                <th scope="col" class="text-center">{{ trans('dashboard.created_at') }}</th>
                <th scope="col" class="text-center">{{ trans('dashboard.operations') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($servicers as $servicer)
            <tr>
                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                <td class="align-middle">{{ $servicer->user->name }}</td>
                <td class="align-middle">{{ $servicer->user->email }}</td>
                <td class="align-middle">{{ $servicer->name }}</td>
                <td class="align-middle">{{ \Str::limit($servicer->description, 35) }}</td>
                <td class="align-middle">{{ $servicer->price }}</td>
                <td class="align-middle">{{ $servicer->categorie->name }}</td>
                <td class="text-center align-middle">{{ $servicer->created_at->diffForHumans() }}</td>
                <td class="text-center align-middle">
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteBackdrop{{$servicer->id}}">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </td>
                @include('Dashboard.Admin.Service_Provider_Projects.delete')
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3 d-flex justify-content-center">
        {{$servicers->links()}}
    </div>
</div>

@endsection
