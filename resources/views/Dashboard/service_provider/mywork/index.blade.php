@extends('layouts.master')

@section('title', trans('dashboard.MyWork'))

@section('css')
    <style>
        .breadcrumb-header {
            background-color: #f8f9fa;
            border-radius: .25rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .work-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s;
        }

        .work-card:hover {
            transform: translateY(-5px);
        }

        .work-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .work-card-body {
            padding: 15px;
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
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.MyWork') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <button type="button" class="btn btn-primary m-1 w-25 block" data-bs-toggle="modal" data-bs-target="#addWorkLabel">
        {{ trans('dashboard.add') }}
    </button>
    @include('Dashboard.service_provider.mywork.add')

    <div class="row mt-4">
        @foreach ($works as $work)
            <div class="col-md-4">
                <div class="card work-card">
                    <img src="{{ asset('assets/image/myworks/' . $work->image) }}" alt="{{ $work->name }}">
                    <div class="work-card-body">
                        <h5 class="card-title">{{ \Str::limit($work->name, 50) }}</h5>
                        <p class="card-text">{{ \Str::limit($work->description, 100) }}</p>
                        <p class="text-muted small">{{ $work->created_at->diffForHumans() }}</p>

                        <div class="d-flex gap-2">
                            <!-- زر عرض التفاصيل -->
                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#showBackdrop{{ $work->id }}">
                                <i class="bi bi-eye-fill"></i>
                            </button>

                            <!-- زر تعديل -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editWorkModal{{ $work->id }}">
                                <i class="bi bi-pencil-square me-1"></i>
                            </button>


                            <!-- زر حذف -->
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteBackdrop{{ $work->id }}">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>          

            @include('Dashboard.service_provider.mywork.view')
            @include('Dashboard.service_provider.mywork.update')
            @include('Dashboard.service_provider.mywork.delete')
        @endforeach
    </div>


    <!-- Adding pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $works->links() }}
    </div>
@endsection
