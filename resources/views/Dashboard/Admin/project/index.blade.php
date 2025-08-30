@extends('layouts.master')

@section('title', trans('dashboard.projects'))

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
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
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

        .project-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: .5rem;
            color: #555;
        }

        .info-item strong {
            color: #333;
        }

        .status-badge {
            padding: 0.4em 0.8em;
            border-radius: 1rem;
            font-weight: 600;
            font-size: 0.9em;
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
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.projects') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <form method="post" action="{{ route('admin.project.search') }}" class="mb-4">
        @csrf
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <select class="form-select shadow-sm rounded" name="categorie_id" id="categorie_id">
                    <option disabled selected>{{ trans('dashboard.categories') }}</option>
                    @foreach ($Categories as $Categorie)
                        <option value="{{ $Categorie->id }}">{{ $Categorie->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="skills" class="form-label">{{ trans('dashboard.skill') }}</label>
                <div id="skills-container" class="d-flex flex-wrap gap-2"></div>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary shadow-sm rounded w-100">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </form>

    <div class="row row-cols-1 g-4">
        @forelse ($projects as $project)
            <div class="col-12">
                <div class="card project-card">
                    <div class="project-header">
                        <h6 class="card-title">{{ $project->name }}</h6>
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
                        <p class="card-text text-muted mb-4">
                            {{ \Str::limit($project->description, 200) }}
                        </p>

                        <div class="project-info-grid">
                            <div class="info-item">
                                <i class="bi bi-person"></i>
                                <span>{{ $project->user->name }}</span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-clock"></i>
                                <span>{{ $project->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-tag"></i>
                                <span><strong>{{ trans('dashboard.categorie') }}:</strong>
                                    {{ $project->categorie->name }}</span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-graph-up"></i>
                                <span><strong>{{ trans('dashboard.offer') }}:</strong>
                                    {{ $project->offer->count() }}</span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-currency-dollar"></i>
                                <span><strong>{{ trans('dashboard.price') }}:</strong> {{ $project->prise }}</span>
                            </div>
                        </div>

                        <div class="mt-3 d-flex justify-content-end">
                            <a class="btn btn-primary" href="{{ route('admin.projects.show', $project->id) }}">
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

                $.ajax({
                    url: `/Admin/categories/skills/${categoryId}`,
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        skillsContainer.empty();
                        skillsContainer.css({
                            display: 'flex',
                            flexWrap: 'wrap'
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
