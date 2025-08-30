@extends('layouts.master')

@section('title', trans('dashboard.duration'))

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
                <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.duration') }}</li>
            </ol>
        </nav>
    </div>
</div>
<button type="button" class="btn btn-primary m-1 w-25 block" data-bs-toggle="modal" data-bs-target="#backdrop">{{ trans('dashboard.add') }}</button>
@include('Dashboard.Admin.duration.add')
<div class="table-responsive">
    <table class="table table-striped table-dark table-hover mb-0">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ trans('dashboard.duration_name') }}</th>
                <th scope="col">{{ trans('dashboard.delivery_time') }}</th>
                <th scope="col">{{ trans('dashboard.created_at') }}</th>
                <th scope="col">{{ trans('dashboard.operations') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($durations as $duration)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Str::limit($duration->duration_name,35) }}</td>
                <td>{{ $duration->number }}</td>
                <td>{{ $duration->created_at->diffForHumans() }}</td>
                <td class="d-flex justify-content-start align-items-center gap-2">
                    <!-- زر التعديل -->
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editBackdrop{{$duration->id}}">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                    <!-- زر الحذف -->
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteBackdrop{{$duration->id}}">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </td>
                @include('Dashboard.Admin.duration.update')
                @include('Dashboard.Admin.duration.delete')
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3 d-flex justify-content-center">
        {{$durations->links()}}
    </div>
</div>

@endsection
