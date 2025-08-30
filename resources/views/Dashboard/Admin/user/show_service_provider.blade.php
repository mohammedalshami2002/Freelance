@extends('layouts.master')

@section('title', $user->name)

@section('css')
    <style>
        :root {
            --primary-color: #5B86E5;
            --secondary-color: #3f68a5;
            --background-color: #F0F2F5;
            --card-bg: #FFFFFF;
            --text-dark: #333;
            --text-light: #777;
            --text-white: #fff;
            --warning-color: #FFC107;
            --success-color: #28A745;
            --danger-color: #DC3545;
        }

        body {
            background-color: var(--background-color);
            font-family: 'Tajawal', sans-serif;
        }

        .breadcrumb-header {
            background-color: #f8f9fa;
            border-radius: .25rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .profile-card {
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            background-color: var(--card-bg);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .profile-card-top-section {
            background: linear-gradient(to right, #5B86E5, #36a2b8);
            padding: 2rem;
            color: var(--text-white);
            position: relative;
            text-align: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .profile-card-top-section h3 {
            color: var(--text-white);
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .profile-card-body {
            padding: 2rem;
            position: relative;
        }

        .profile-img-container {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 4px solid var(--card-bg);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: -85px;
            margin-right: 2rem;
            position: relative;
            z-index: 10;
            align-self: flex-start;
        }

        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-body-content {
            text-align: right;
            direction: rtl;
            width: 100%;
        }

        .user-info-header {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: right;
            margin-top: -60px;
            padding-right: 155px;
        }

        .user-info-header h3 {
            color: var(--text-dark);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .badge-status {
            font-size: 0.85rem;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .rating-stars {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .rating-stars i {
            font-size: 1.4rem;
            color: var(--warning-color);
            transition: transform 0.2s ease;
        }

        .info-section {
            margin-top: 1.5rem;
            width: 100%;
        }

        .info-section-title {
            color: var(--primary-color);
            font-weight: 600;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
            text-align: right;
        }

        .list-group-item {
            background-color: transparent !important;
            border-color: #EEE !important;
            padding: 1rem 0;
            color: var(--text-dark);
            font-size: 1rem;
            text-align: right;
            direction: rtl;
        }

        .list-group-item strong {
            font-weight: 600;
            color: var(--text-dark);
        }

        .skill-badge {
            background-color: #E9ECEF;
            color: var(--text-light);
            padding: 0.6rem 1.4rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .skill-badge:hover {
            background-color: var(--primary-color);
            color: var(--text-white);
        }

        .no-skills-text {
            color: var(--text-light);
            font-style: italic;
        }

        /* --- START OF NEW CSS FOR MY WORKS SECTION --- */
        .my-works-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .my-work-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            direction: rtl;
            text-align: right;
        }

        .my-work-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .my-work-image-container {
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .my-work-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }

        .my-work-card:hover .my-work-image {
            transform: scale(1.05);
        }

        .my-work-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .my-work-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .my-work-description {
            font-size: 0.95rem;
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 0.5rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* Limit text to 3 lines */
            -webkit-box-orient: vertical;
        }

        .my-work-link {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--text-white);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            text-align: center;
            font-weight: 600;
        }

        .my-work-link:hover {
            background-color: var(--secondary-color);
        }

        /* --- END OF NEW CSS --- */

        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css");

        /* Responsive adjustments */
        @media (min-width: 768px) {
            .profile-card {
                flex-direction: row;
                padding: 2rem;
            }

            .profile-card-top-section {
                background: none;
                padding: 0;
                margin-right: 2rem;
                flex-grow: 1;
                align-self: flex-start;
            }

            .profile-card-body {
                flex-grow: 2;
                padding: 0;
                margin-top: 0;
                display: flex;
                flex-direction: column;
                align-items: flex-end;
            }

            .profile-img-container {
                width: 150px;
                height: 150px;
                margin-top: 0;
                margin-right: 0;
                align-self: flex-end;
            }

            .user-info-header {
                margin-top: 0;
                padding-right: 0;
                align-items: flex-end;
                text-align: right;
                order: -1;
                margin-bottom: 1.5rem;
            }
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
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{ route('user.service_provider') }}">{{ trans('dashboard.service_providers') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.profile') }}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-9">
                <div class="profile-card">
                    <div class="profile-card-top-section">
                        <div class="profile-img-container">
                            <img src="{{ URL::asset('assets/image/Profile/' . $user->image) }}" alt="Profile Image"
                                class="profile-img">
                        </div>
                    </div>

                    <div class="profile-card-body">
                        <div class="user-info-header">
                            <h3>{{ $user->name }}</h3>
                            @php
                                $averageRating = $user->ratings->avg('rating');
                                $maxStars = 5;
                                $fullStars = floor($averageRating);
                                $halfStar = $averageRating - $fullStars >= 0.5;
                                $emptyStars = $maxStars - $fullStars - ($halfStar ? 1 : 0);
                            @endphp
                            <div class="rating-stars">
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

                        <div class="info-section">
                            @if (empty($user->profile) || !$user->profile->authenticated)
                                <span class="badge bg-danger badge-status">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ trans('dashboard.unverified_account') }}
                                </span>
                            @else
                                <span class="badge bg-success badge-status">
                                    <i class="bi bi-check-circle me-1"></i>{{ trans('dashboard.verified_account') }}
                                </span>
                            @endif
                            <h5 class="info-section-title">{{ trans('dashboard.personal_information') }}</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>{{ trans('dashboard.name') }}</strong>
                                    <span>{{ $user->name }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>{{ trans('login.email') }}</strong>
                                    <span>{{ $user->email }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>{{ trans('dashboard.categorie') }}</strong>
                                    <span>{{ $user->category->name ?? trans('dashboard.null') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>{{ trans('dashboard.phone_number') }}</strong>
                                    <span>{{ $user->profile->phone_number ?? trans('dashboard.null') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>{{ trans('dashboard.University_name') }}</strong>
                                    <span>{{ $user->profile->university_name ?? trans('dashboard.null') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>{{ trans('dashboard.Specialization') }}</strong>
                                    <span>{{ $user->profile->specialization ?? trans('dashboard.null') }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="info-section">
                            <h5 class="info-section-title">{{ trans('dashboard.description') }}</h5>
                            <p class="text-muted profile-description" style="direction: rtl; text-align: right;">
                                {{ $user->profile->profile ?? trans('dashboard.no_profile_description') }}
                            </p>
                        </div>

                        <div class="info-section">
                            <h5 class="info-section-title">{{ trans('dashboard.skill') }}</h5>
                            @if ($user->skills->isNotEmpty())
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    @foreach ($user->skills as $skill)
                                        <span class="badge skill-badge">{{ $skill->name }}</span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mt-2 no-skills-text">{{ trans('dashboard.no_skills') }}</p>
                            @endif
                        </div>

                        <!-- NEW SECTION: My Works -->
                        <div class="info-section">
                            <h5 class="info-section-title">{{ trans('dashboard.MyWork') }}</h5>
                            @if ($user->myWorks->isNotEmpty())
                                <div class="my-works-grid">
                                    @foreach ($user->myWorks as $work)
                                        <div class="my-work-card">
                                            <div class="my-work-image-container">
                                                <img src="{{ URL::asset('assets/image/myworks/' . $work->image) }}"
                                                    alt="{{ $work->name }}" class="my-work-image">
                                            </div>
                                            <div class="my-work-body">
                                                <h6 class="my-work-title">{{ \Str::limit($work->name, 50) }}</h6>
                                                <p class="my-work-description">{{ \Str::limit($work->description, 100) }}
                                                </p>
                                                <button class="btn btn-primary btn-lg" data-bs-toggle="modal"
                                                    data-bs-target="#showBackdrop{{ $work->id }}">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @include('Dashboard.Admin.user.view')
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mt-2 no-skills-text">{{ trans('dashboard.null') }}</p>
                            @endif
                        </div>
                        <!-- END OF NEW SECTION -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
