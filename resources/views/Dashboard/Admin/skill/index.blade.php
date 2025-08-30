@extends('layouts.master')

@section('title', trans('dashboard.skill'))

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
                <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.skill') }}</li>
            </ol>
        </nav>
    </div>
</div>
<button type="button" class="btn btn-primary m-1 w-25 block" data-bs-toggle="modal" data-bs-target="#backdrop">{{ trans('dashboard.add') }}</button>
@include('Dashboard.Admin.skill.add')
<class="table-responsive">
    <table class="table table-striped table-dark mb-0">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ trans('dashboard.name') }}</th>
                <th scope="col">{{ trans('dashboard.categories') }}</th>
                <th scope="col">{{ trans('dashboard.created_at') }}</th>
                <th scope="col">{{ trans('dashboard.operations') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($skills as $skill)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Str::limit($skill->name,35) }}</td>
                <td>
                    @foreach ($categories as $categorie)
                        @if($categorie->id == $skill->categorie_id)
                            {{ $categorie->name }}
                        @endif
                    @endforeach
                </td>
                <td>{{ $skill->created_at->diffForHumans() }}</td>
                <td>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editBackdrop{{$skill->id}}">
                        <i class="bi bi-pencil-fill"></i> <!-- أيقونة التعديل -->
                    </button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBackdrop{{$skill->id}}">
                        <i class="bi bi-trash-fill"></i> <!-- أيقونة الحذف -->
                    </button>
                </td>
                @include('Dashboard.Admin.skill.update')
                @include('Dashboard.Admin.skill.delete')
            </tr>
            @endforeach
        </tbody>
    </table><br>
    {{$skills->links()}}
    </div>
    @endsection
