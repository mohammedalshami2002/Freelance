@extends('layouts.master')
@section('title', trans('dashboard.disputes'))
@section('css')
    <style>
        body {
            background-color: #f5f7fa !important;
        }

        .custom-card {
            border-radius: 16px;
            border: none;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease-in-out;
        }

        .custom-card:hover {
            transform: translateY(-3px);
        }

        .custom-card-header {
            border-radius: 16px 16px 0 0;
            background: linear-gradient(135deg, #4e73df, #6f9ef6);
            color: #fff;
            padding: 16px 20px;
        }

        .custom-badge {
            font-size: 0.8rem;
            padding: 5px 12px;
            border-radius: 12px;
            font-weight: 600;
        }

        .badge-open {
            background: #ffeeba;
            color: #856404;
        }

        .badge-resolved {
            background: #c3e6cb;
            color: #155724;
        }

        .badge-default {
            background: #d6d8d9;
            color: #383d41;
        }

        .custom-btn {
            border-radius: 20px;
            padding: 6px 16px;
            font-size: 0.85rem;
            font-weight: 500;
            border: 1px solid #4e73df;
            color: #4e73df;
            background: transparent;
            transition: all 0.2s ease;
        }

        .custom-btn:hover {
            background: #4e73df;
            color: #fff;
        }

        .custom-info {
            font-size: 0.85rem;
            color: #6c757d;
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
                        <a href="{{ route('dashboard') }}">{{ trans('dashboard.dashboard') }}</a>
                    </li>
                     <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.disputes') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="custom-card">

                    <div class="p-4">
                        <div class="row g-4">
                            @forelse($disputes as $dispute)
                                <div class="col-md-12">
                                    <div class="custom-card h-100">
                                        <div class="p-3 d-flex flex-column">
                                            <div class="d-flex justify-content-between mb-2">
                                                <h6 class="fw-bold text-primary">
                                                    <i class="fa-solid fa-briefcase me-1"></i>
                                                    {{ $dispute->project->name ?? trans('dashboard.null') }}
                                                </h6>
                                                @php
                                                    $badgeClass = match ($dispute->status) {
                                                        'open_for_reply' => 'custom-badge badge-open',
                                                        'resolved' => 'custom-badge badge-resolved',
                                                        default => 'custom-badge badge-default',
                                                    };
                                                @endphp
                                                <span class="{{ $badgeClass }}">
                                                    {{ trans('dashboard.'.$dispute->status) }}
                                                </span>
                                            </div>

                                            <p class="custom-info mb-1">
                                                <i class="fa-regular fa-user me-1"></i>
                                                @lang('login.client'): <span
                                                    class="fw-semibold">{{ $dispute->client->name ?? trans('dashboard.null') }}</span>
                                            </p>
                                            <p class="custom-info mb-2">
                                                <i class="fa-solid fa-user-tie me-1"></i>
                                                @lang('login.service_provider'): <span
                                                    class="fw-semibold">{{ $dispute->serviceProvider->name ?? trans('dashboard.null')  }}</span>
                                            </p>

                                            <small class="text-muted mt-auto">
                                                <i class="fa-regular fa-clock me-1"></i>
                                                @lang('dashboard.opened_at'): {{ $dispute->opened_at}}
                                            </small>

                                            <div class="mt-3 text-end">
                                                <a href="{{ route('admin.disputes.show', $dispute->id) }}"
                                                    class="custom-btn">
                                                    <i class="fa-solid fa-eye"></i> @lang('dashboard.show')
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-light text-center rounded-4" role="alert">
                                        <i class="fa-solid fa-circle-info text-secondary me-2"></i>
                                        @lang('dashboard.no_disputes_found')
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
