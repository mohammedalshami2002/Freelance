@extends('layouts.master')

@section('title', $project->name)

@section('css')
    <style>
        /* Global Styles for a clean, modern look */
        body {
            background-color: #f4f7f9;
            font-family: 'Poppins', sans-serif;
        }

        /* Breadcrumb Header */
        .breadcrumb-header {
            background-color: #ffffff;
            border: 1px solid #e0e6ed;
            border-radius: .75rem;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .breadcrumb-item a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .breadcrumb-item a:hover {
            color: #0056b3;
        }

        /* Project Card */
        .project-details-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .project-header {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: #fff;
            padding: 1.5rem;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        .project-header h6 {
            font-weight: 600;
            font-size: 1.5rem;
            margin: 0;
        }

        .project-body {
            padding: 2rem;
        }

        .project-description {
            line-height: 1.8;
            color: #555;
            font-size: 1rem;
        }

        .project-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1rem;
            color: #555;
        }

        .info-item strong {
            color: #333;
        }

        .info-item i {
            font-size: 1.25rem;
            color: #007bff;
        }

        .skill-section {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e0e6ed;
        }

        .skill-badge {
            background-color: #e9ecef;
            color: #495057;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.4rem 1rem;
            border-radius: 1.5rem;
            margin: 0.25rem;
        }

        /* Offers Section */
        .offers-section {
            background-color: #f8f9fa;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .offer-card {
            background-color: #ffffff;
            border: 1px solid #e0e6ed;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .offer-card:hover {
            transform: translateY(-3px);
        }

        .offer-header {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .offer-header strong {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }

        .rating-stars i {
            color: #ffc107;
        }

        .rating-stars .bi-star {
            color: #ccc;
        }

        .offer-description {
            margin-top: 1rem;
            color: #6c757d;
            line-height: 1.6;
        }

        .offer-details {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1.5rem;
            margin-top: 1rem;
            border-top: 1px dashed #e0e6ed;
            padding-top: 1rem;
        }

        .offer-details .price {
            font-weight: 600;
            color: #198754;
            font-size: 1.1rem;
        }

        .offer-details .status {
            font-size: 0.9rem;
        }

        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 1rem;
            font-weight: 600;
        }

        .status-pending {
            background-color: #ffc107;
            color: #664d03;
        }

        .status-rejected {
            background-color: #dc3545;
            color: #fff;
        }

        .status-accepted {
            background-color: #198754;
            color: #fff;
        }

        .offer-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 1rem;
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
                        <a href="{{ route('Client.dashboard') }}">{{ trans('dashboard.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('Prosodic.index') }}">{{ trans('dashboard.Prosodic') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $project->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card project-details-card">
                <div class="card-header project-header">
                    <h6 class="card-title mb-0">{{ $project->name }}</h6>
                </div>
                <div class="card-body project-body">
                    <p class="project-description">{{ $project->description }}</p>

                    <div class="project-info-grid">
                        <div class="info-item">
                            <i class="bi bi-info-circle"></i>
                            <span>
                                <strong>{{ trans('dashboard.status') }}:</strong>
                                <span
                                    class="status-badge
                                @if ($project->status == 'قيد التنفيذ') status-accepted
                                @elseif ($project->status == 'مستبعد') status-rejected
                                @elseif ($project->status == 'مكتمل') status-accepted
                                @elseif ($project->status == 'قيد الانتظار') status-pending @endif">
                                    {{ trans($project->status) }}
                                </span>
                            </span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-clock"></i>
                            <span><strong>{{ trans('dashboard.created_at') }}:</strong>
                                {{ $project->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-folder"></i>
                            <span><strong>{{ trans('dashboard.categorie') }}:</strong>
                                {{ $project->categorie->name }}</span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-currency-dollar"></i>
                            <span><strong>{{ trans('dashboard.price') }}:</strong> {{ $project->prise }}</span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-person-fill"></i>
                            <span><strong>{{ trans('dashboard.offer') }}:</strong> {{ $project->offer->count() }}</span>
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

                    @if ($project->skills->count())
                        <div class="skill-section">
                            <strong>{{ trans('dashboard.skill') }}:</strong>
                            @foreach ($project->skills as $skill)
                                <span class="badge skill-badge">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="offers-section">
                <h5 class="mb-4">{{ trans('dashboard.offer') }}</h5>
                @forelse ($project->offer as $offer)
                    <div class="offer-card mb-4">
                        <div class="offer-header">
                            <i class="bi bi-person-circle"></i>
                            <strong>{{ $offer->user->name }}</strong>
                            <div class="rating-stars">
                                @php
                                    $averageRating = $offer->user->ratings()->avg('rating') ?? 0;
                                    $fullStars = floor($averageRating);
                                    $halfStar = $averageRating - $fullStars >= 0.5;
                                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                @endphp
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor
                                @if ($halfStar)
                                    <i class="bi bi-star-half"></i>
                                @endif
                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <i class="bi bi-star"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="offer-description mt-3 mb-2">
                            <strong>{{ trans('dashboard.description') }}:</strong>
                            <span>{{ $offer->description }}</span>
                        </p>
                        <div class="offer-details">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-currency-dollar text-success"></i>
                                <span class="price">{{ $offer->price }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock text-muted"></i>
                                <span>{{ $offer->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-info-circle text-primary"></i>
                                <span class="status">
                                    <strong>{{ trans('dashboard.status') }}:</strong>
                                    <span
                                        class="status-badge
                                    @if ($offer->status == 0) status-pending
                                    @elseif($offer->status == 1) status-rejected
                                    @elseif($offer->status == 2) status-accepted @endif">
                                        @if ($offer->status == 0)
                                            {{ trans('dashboard.pending') }}
                                        @elseif($offer->status == 1)
                                            {{ trans('dashboard.rejected') }}
                                        @elseif($offer->status == 2)
                                            {{ trans('dashboard.accepted') }}
                                        @endif
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="offer-actions">
                            @if ($offer->status == 0)
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#confirmEnableModal" data-offer-id="{{ $offer->id }}">
                                    <i class="bi bi-check-circle"></i> {{ trans('dashboard.enable') }}
                                </button>
                            @endif
                            <a href="{{ route('Profile.show', $offer->user->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-person-lines-fill"></i> {{ trans('dashboard.Present_his_information') }}
                            </a>
                            @if ($offer->status == 2)
                                @php
                                    $firstRating = $project->ratings->first();
                                @endphp

                                @if (is_null($firstRating) || $firstRating->project_id != $project->id)
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#ratingModal">
                                        <i class="bi bi-star-fill me-2"></i>
                                        <span>{{ trans('dashboard.add_rating') }}</span>
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                    @include('Dashboard.Client.project.rating')
                @empty
                    <div class="alert alert-info text-center">{{ trans('dashboard.No_offers_found') }}</div>
                @endforelse
            </div>
        </div>
        @include('Dashboard.Client.project.enable')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const enableModal = document.getElementById('confirmEnableModal');
            if (enableModal) {
                enableModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const offerId = button.getAttribute('data-offer-id');
                    const form = this.querySelector('#enableForm');

                    // تأكد من أن route() يعمل بشكل صحيح في JavaScript
                    const actionUrl = `{{ route('offer.enable', ':id') }}`.replace(':id', offerId);

                    form.setAttribute('action', actionUrl);
                });
            }
        });
    </script>
@endsection
