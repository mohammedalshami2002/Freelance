@extends('layouts.master')

@section('title', $project->name)

@section('css')
    <style>
        .breadcrumb-header {
            background-color: #f8f9fa;
            border-radius: .75rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            border-radius: 1rem 1rem 0 0 !important;
        }

        .offer-card {
            transition: all 0.3s ease;
            border-radius: .75rem;
        }

        .offer-card:hover {
            background-color: #f9fafc;
            transform: translateY(-2px);
        }

        .badge {
            border-radius: 20px;
            padding: .4em .8em;
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
                    <li class="breadcrumb-item">
                        <a href="{{ route('projects.index') }}">
                            {{ trans('dashboard.projects') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $project->name }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="card-title mb-0">{{ $project->name }}</h5>
            </div>

            <div class="card-body">
                <!-- وصف المشروع -->
                <p class="text-muted mb-4">{{ $project->description }}</p>

                <!-- بيانات المشروع -->
                <div class="row text-center text-md-start g-3 mb-3">
                    <div class="col-6 col-md-4 col-lg-2">
                        <i class="bi bi-person me-1"></i>
                        <strong>{{ $project->user->name }}</strong>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <strong>{{ trans('dashboard.status') }}:</strong>
                        <span class="text-primary">
                            @if ($project->status == 'قيد التنفيذ')
                                {{ trans('dashboard.in_progress') }}
                            @elseif ($project->status == 'مستبعد')
                                {{ trans('dashboard.excluded') }}
                            @elseif ($project->status == 'مكتمل')
                                {{ trans('dashboard.completed') }}
                            @elseif ($project->status == 'قيد الانتظار')
                                {{ trans('dashboard.pending') }}
                            @else
                                {{ $project->status }}
                            @endif
                        </span>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <i class="bi bi-clock me-1"></i>
                        <small>{{ $project->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <strong>{{ trans('dashboard.categorie') }}:</strong>
                        {{ $project->categorie->name }}
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <strong>{{ trans('dashboard.price') }}:</strong>
                        <span class="text-success">{{ $project->prise }}</span>
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <strong>{{ trans('dashboard.offer') }}:</strong>
                        {{ $project->offer->count() }}
                    </div>
                    <div class="info-item">
                        <i class="bi bi-calendar-check"></i>
                        <span><strong>{{ trans('dashboard.duration') }}:</strong> {{ $project->duration->number }}
                            {{ $project->duration->duration_name }}</span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-award"></i>
                        <span><strong>{{ trans('dashboard.Experience_level') }}:</strong>
                            {{ $project->experience->name }}</span>
                    </div>
                </div>

                <!-- المهارات -->
                <div class="mb-4">
                    <strong>{{ trans('dashboard.skill') }}:</strong>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @foreach ($project->skills as $skill)
                            <span class="badge bg-secondary">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                </div>

                <!-- إضافة عرض -->
                @if ($project->offer->where('user_id', auth()->id())->isEmpty() && $project->status == 'قيد الانتظار')
                    <div class="alert alert-light border rounded-3 p-3">
                        <strong class="d-block mb-3">{{ trans('dashboard.Add_Offer') }}</strong>
                        <form method="post" action="{{ route('projects.offer_add', $project->id) }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" name="description" class="form-control rounded-pill shadow-sm"
                                        placeholder="{{ trans('dashboard.description') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="price" class="form-control rounded-pill shadow-sm"
                                        placeholder="{{ trans('dashboard.price') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">
                                        {{ trans('dashboard.add') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- العروض -->
                @foreach ($project->offer as $offer)
                    <div class="offer-card mb-3 p-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <i class="bi bi-person me-1"></i>
                                <strong>{{ $offer->user->name }}</strong>
                            </div>
                            <div>
                                @php
                                    $averageRating = $project->ratings->avg('rating');
                                    $maxStars = 5;
                                    $fullStars = floor($averageRating);
                                    $halfStar = $averageRating - $fullStars >= 0.5;
                                    $emptyStars = $maxStars - $fullStars - ($halfStar ? 1 : 0);
                                @endphp
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @endfor
                                @if ($halfStar)
                                    <i class="bi bi-star-half text-warning"></i>
                                @endif
                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <i class="bi bi-star text-muted"></i>
                                @endfor
                            </div>
                        </div>

                        <div class="text-muted mb-2">
                            <strong>{{ trans('dashboard.description') }}:</strong>
                            {{ \Str::limit($offer->description, 200) }}
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ trans('dashboard.price') }}:</strong>
                                <span class="text-success">{{ $offer->price }}</span>
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div>
                                <strong>{{ trans('dashboard.status') }}:</strong>
                                @if ($offer->status == 0)
                                    <span class="text-warning">{{ trans('dashboard.pending') }}</span>
                                @elseif($offer->status == 1)
                                    <span class="text-danger">{{ trans('dashboard.rejected') }}</span>
                                @elseif($offer->status == 2)
                                    <span class="text-success">{{ trans('dashboard.accepted') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
