@extends('layouts.master')

@section('title', trans('dashboard.categories'))

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
                <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.categories') }}</li>
            </ol>
        </nav>
    </div>
</div>
<button type="button" class="btn btn-primary m-1 w-25 block" data-bs-toggle="modal" data-bs-target="#backdrop">{{ trans('dashboard.add') }}</button>
@include('Dashboard.Admin.Categorie.add')
<div class="table-responsive">
    <table class="table table-striped table-dark mb-0">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ trans('dashboard.name') }}</th>
                <th scope="col">{{ trans('dashboard.description') }}</th>
                <th scope="col">{{ trans('dashboard.created_at') }}</th>
                <th scope="col">{{ trans('dashboard.operations') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $categorie)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Str::limit($categorie->name,35) }}</td>
                <td>{{ \Str::limit($categorie->description,35) }}</td>
                <td>{{ $categorie->created_at->diffForHumans() }}</td>
                <td>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editBackdrop{{$categorie->id}}">
                        <i class="bi bi-pencil-fill"></i> <!-- أيقونة التعديل -->
                    </button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBackdrop{{$categorie->id}}">
                        <i class="bi bi-trash-fill"></i> <!-- أيقونة الحذف -->
                    </button>
                </td>
                @include('Dashboard.Admin.Categorie.update')
                @include('Dashboard.Admin.Categorie.delete')
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Adding pagination with responsive display -->
    <div class="d-flex justify-content-center">
        {{$categories->links()}}
    </div>
</div>

    @endsection
