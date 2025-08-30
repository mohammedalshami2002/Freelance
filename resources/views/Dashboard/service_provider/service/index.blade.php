@extends('layouts.master')

@section('title', trans('dashboard.My_services'))
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
                        <a href="{{ route('service_provider.dashboard') }}">
                            {{ trans('dashboard.dashboard') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.My_services') }}</li>
                </ol>
            </nav>
        </div>
    </div>
<button type="button" class="btn btn-primary m-2 w-25 block" data-bs-toggle="modal" data-bs-target="#backdrop">{{ trans('dashboard.add') }}</button>
@include('Dashboard.service_provider.service.add')
<div class="row">
    @foreach ($servicers as $servicer)
        <div class="col-12 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $servicer->name }}</h5>
                    <p class="card-text">{{ \Str::limit($servicer->description, 50) }}</p>
                    <p class="card-text">
                        <strong>{{ trans('dashboard.price') }}:</strong> {{ $servicer->price }}
                    </p>
                    <p class="card-text">
                        <strong>{{ trans('dashboard.categorie') }}:</strong> {{ $servicer->categorie->name }}
                    </p>
                    <p class="card-text">
                        <strong>{{ trans('dashboard.status') }}:</strong>
                        @if ($servicer->status)
                            <span class="badge bg-success">{{ trans('dashboard.active') }}</span>
                        @else
                            <span class="badge bg-danger">{{ trans('dashboard.Inactive') }}</span>
                        @endif
                    </p>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editBackdrop{{$servicer->id}}">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteBackdrop{{$servicer->id}}">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                    @include('Dashboard.service_provider.service.delete')
                    @include('Dashboard.service_provider.service.update')
                </div>
            </div>
        </div>
    @endforeach
</div>
{{$servicers->links()}}
@endsection
