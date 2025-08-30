@extends('layouts.master')

@section('title', trans('dashboard.Experience_level'))

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
                <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.Experience_level') }}</li>
            </ol>
        </nav>
    </div>
</div>
<button type="button" class="btn btn-primary m-1 w-25 block" data-bs-toggle="modal" data-bs-target="#backdrop">{{ trans('dashboard.add') }}</button>
@include('Dashboard.Admin.experience.add')
<div class="table-responsive">
    <table class="table table-striped table-dark table-hover mb-0">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ trans('dashboard.name') }}</th>
                <th scope="col">{{ trans('dashboard.created_at') }}</th>
                <th scope="col">{{ trans('dashboard.operations') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($experiences as $experience)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Str::limit($experience->name,35) }}</td>
                <td>{{ $experience->created_at->diffForHumans() }}</td>
                <td class="d-flex justify-content-start align-items-center gap-2">
                    <!-- زر التعديل -->
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editBackdrop{{$experience->id}}">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                    <!-- زر الحذف -->
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteBackdrop{{$experience->id}}">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </td>
                @include('Dashboard.Admin.experience.update')
                @include('Dashboard.Admin.experience.delete')
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3 d-flex justify-content-center">
        {{$experiences->links()}}
    </div>
</div>

@endsection
