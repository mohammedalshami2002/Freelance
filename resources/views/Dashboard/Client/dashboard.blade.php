@extends('layouts.master')
@section('title', trans('dashboard.dashboard'))
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/compiled/css/dashborad.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* General body and container styles */
        body {
            background-color: #f4f7f9;
            font-family: 'Inter', sans-serif;
        }

        /* Card styles for a modern look */
        .dashboard-card {
            border-radius: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            background: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        /* Icon styles */
        .icon-container {
            font-size: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-bottom: 1rem;
            color: #fff;
        }

        /* Specific icon background colors */
        .bg-blue-light {
            background-color: #4a90e2;
        }

        .bg-teal-light {
            background-color: #50e3c2;
        }

        .bg-orange-light {
            background-color: #f5a623;
        }

        .bg-red-light {
            background-color: #d0021b;
        }

        .bg-green-light {
            background-color: #7ed321;
        }

        .bg-purple-light {
            background-color: #6a11cb;
        }

        /* Text and header styles */
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .card-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a1a1a;
        }

        .card-text {
            font-size: 0.9rem;
            color: #666;
        }
    </style>
@endsection

@section('page-header')
    @include('meesage')
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('Client.dashboard') }}">
                            {{ trans('dashboard.dashboard') }}
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Main Client Stats -->
        <div class="col-12 mb-4">
            <h4 class="text-secondary mb-3"><i class="fas fa-chart-line me-2"></i>
                {{ trans('dashboard.Your_Projects_Status') }}</h4>
            <div class="row">
                <!-- Projects in Progress -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="dashboard-card text-center">
                        <div class="icon-container bg-purple-light mx-auto">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h4 class="card-value">{{ $projectsInProgress }}</h4>
                        <p class="card-text">{{ trans('dashboard.Projects_in_Progress') }}</p>
                    </div>
                </div>

                <!-- Received Offers -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="dashboard-card text-center">
                        <div class="icon-container bg-orange-light mx-auto">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <h4 class="card-value">{{ $offersReceived }}</h4>
                        <p class="card-text">{{ trans('dashboard.Offers_Received_on_Your_Projects') }}</p>
                    </div>
                </div>

                <!-- Open Disputes -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="dashboard-card text-center">
                        <div class="icon-container bg-red-light mx-auto">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h4 class="card-value">{{ $disputesPendingCount }}</h4>
                        <p class="card-text">{{ trans('dashboard.Open_Disputes') }}</p>
                    </div>
                </div>

                <!-- Resolved Disputes -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="dashboard-card text-center">
                        <div class="icon-container bg-green-light mx-auto">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <h4 class="card-value">{{ $disputesResolvedCount }}</h4>
                        <p class="card-text">{{ trans('dashboard.Resolved_Disputes') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Latest Projects Section -->
    <div class="row">
        <div class="col-12 mb-4">
            <h4 class="text-secondary mb-3">
                <i class="fas fa-tasks me-2"></i> {{ trans('dashboard.Your_Latest_Projects') }}
            </h4>

            @forelse($projects as $project)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title mb-1">{{ $project->name }}</h5>
                            <p class="card-text text-muted mb-2">
                                {{ Str::limit($project->description, 100) }}
                            </p>
                            <span class="badge bg-primary">
                                {{ number_format($project->prise, 2) }} $
                            </span>
                            <span class="badge">
                                <a href="{{ route('Profile.show', $project->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> {{ trans('dashboard.show') }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">{{ trans('dashboard.No_Projects_Found') }}</p>
            @endforelse
        </div>
    </div>

@endsection
