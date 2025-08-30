@extends('layouts.master')

@section('title', trans('dashboard.Search'))

@section('css')
    <style>
        .breadcrumb-header {
            background-color: #ffffff;
            border: 1px solid #e0e6ed;
            border-radius: .5rem;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .project-card {
            border: none;
            border-radius: .75rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .project-header {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: #fff;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .project-header h6 {
            margin: 0;
            font-weight: 600;
        }

        .project-body {
            padding: 1.5rem;
        }

        .status-badge {
            padding: 0.35em 0.8em;
            border-radius: 1rem;
            font-weight: 600;
            font-size: 0.85em;
        }

        .status-pending {
            background-color: #ffc107;
            color: #664d03;
        }

        .status-in_progress {
            background-color: #0d6efd;
            color: #fff;
        }

        .status-completed {
            background-color: #198754;
            color: #fff;
        }

        .status-excluded {
            background-color: #dc3545;
            color: #fff;
        }

        .card-actions {
            margin-top: 1rem;
            display: flex;
            gap: .5rem;
            justify-content: flex-end;
        }

        .btn-action {
            border-radius: .5rem;
            font-weight: 500;
            padding: 0.4rem 0.9rem;
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
                        <a href="{{ route('projects.index') }}">{{ trans('dashboard.projects') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ trans('dashboard.Search') }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <form method="post" action="{{ route('project.search') }}" class="mb-4">
        @csrf
        <div class="row g-3 align-items-center">
            <!-- Dropdown Menu -->
            <div class="col-md-4">
                <select class="form-select shadow-sm rounded" name="categorie_id" id="categorie_id">
                    <option disabled selected>{{ trans('dashboard.categories') }}</option>
                    <option value="all">{{ trans('dashboard.all') }}</option>
                    @foreach ($Categories as $Categorie)
                        <option value="{{ $Categorie->id }}">{{ $Categorie->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Skills Section -->
            <div class="col-md-6">
                <label for="skills" class="form-label">{{ trans('dashboard.skill') }}</label>
                <div id="skills-container" class="d-flex flex-wrap gap-2"></div>
            </div>

            <!-- Submit Button -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary shadow-sm rounded w-100">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </form>

    <div class="row row-cols-1 g-4">
        @forelse ($projects as $project)
            <div class="col">
                <div class="card project-card">
                    <div class="project-header">
                        <h6 class="text-white">{{ $project->name }}</h6>
                        <span
                            class="status-badge
                        @if ($project->status == 'قيد التنفيذ') status-in_progress
                        @elseif ($project->status == 'مستبعد') status-excluded
                        @elseif ($project->status == 'مكتمل') status-completed
                        @elseif ($project->status == 'قيد الانتظار') status-pending @endif">
                            {{ $project->status }}
                        </span>
                    </div>
                    <div class="project-body">
                        <p class="text-muted mb-3">{{ \Str::limit($project->description, 300) }}</p>

                        <div class="row text-center text-md-start">
                            <div class="col-md-3 mb-2">
                                <i class="bi bi-person"></i> {{ $project->user->name }}
                            </div>
                            <div class="col-md-2 mb-2">
                                <i class="bi bi-clock"></i> {{ $project->created_at->diffForHumans() }}
                            </div>
                            <div class="col-md-3 mb-2">
                                <strong>{{ trans('dashboard.categorie') }}:</strong> {{ $project->categorie->name }}
                            </div>
                            <div class="col-md-2 mb-2">
                                <strong>{{ trans('dashboard.offer') }}:</strong> {{ $project->offer->count() }}
                            </div>
                            <div class="col-md-2 mb-2">
                                <strong>{{ trans('dashboard.price') }}:</strong> {{ $project->prise }} <i
                                    class="bi bi-currency-dollar"></i>
                            </div>
                        </div>

                        <div class="card-actions">
                            <a class="btn btn-primary btn-action" href="{{ route('projects.show', $project->id) }}">
                                {{ trans('dashboard.show') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-danger text-white text-center fs-5 rounded-3 shadow-sm">
                    {{ trans('dashboard.No_offers_found') }}
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $projects->links() }}
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#categorie_id').on('change', function() {
                const categoryId = $(this).val();
                const skillsContainer = $('#skills-container');

                if (categoryId === 'all') {
                    window.location.href = '{{ route('projects.index') }}';
                    return;
                }

                $.ajax({
                    url: `/service_provider/categories/skills/${categoryId}`,
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        skillsContainer.empty().css({
                            'display': 'flex',
                            'flex-wrap': 'wrap'
                        });
                        $.each(data, function(index, skill) {
                            skillsContainer.append(`
                            <div class="form-check me-3">
                                <input class="form-check-input" type="checkbox" value="${skill.id}" name="skills[]">
                                <label class="form-check-label">${skill.name}</label>
                            </div>
                        `);
                        });
                    },
                    error: function(error) {
                        console.error('Error fetching skills:', error);
                    }
                });
            });
        });
    </script>
@endsection
