@extends('layouts.master')

@section('title', trans('dashboard.projects'))

@section('css')
    <style>
        /* Custom styles for a cleaner, more elegant look */
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
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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

        .skill-badge {
            font-size: 0.8em;
            font-weight: 500;
            padding: 0.4em 0.8em;
            border-radius: 1rem;
            background-color: #e9ecef;
            color: #495057;
        }

        .card-actions {
            display: flex;
            justify-content: flex-end;
            gap: .75rem;
            margin-top: 1.5rem;
        }

        .btn-action {
            border-radius: .5rem;
            font-weight: 500;
        }

        .btn-edit {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-delete {
            background-color: #dc3545;
            border-color: #dc3545;
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
                        <a href="{{ route('Client.dashboard') }}">
                            {{ trans('dashboard.dashboard') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.projects') }}</li>
                </ol>
            </nav>
        </div>
    </div>
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
                            {{ \Str::limit($project->description, 300) }}
                        </p>

                        <div class="project-info-grid">
                            <div class="info-item">
                                <i class="bi bi-person-workspace text-primary"></i>
                                <span><strong>{{ trans('dashboard.categorie') }}:</strong>
                                    {{ $project->categorie->name }}</span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-clock text-primary"></i>
                                <span>{{ $project->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-graph-up-arrow text-primary"></i>
                                <span><strong>{{ trans('dashboard.offer') }}:</strong>
                                    {{ $project->offer->count() }}</span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-currency-dollar text-primary"></i>
                                <span><strong>{{ trans('dashboard.price') }}:</strong> {{ $project->prise }}</span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-calendar-check text-primary"></i>
                                <span><strong>{{ trans('dashboard.duration') }}:</strong> {{ $project->duration->number }}
                                    {{ $project->duration->duration_name }}</span>
                            </div>
                            <div class="info-item">
                                <i class="bi bi-award text-primary"></i>
                                <span><strong>{{ trans('dashboard.Experience_level') }}:</strong>
                                    {{ $project->experience->name }}</span>
                            </div>
                        </div>

                        @if ($project->skills->count())
                            <div class="mt-4">
                                <strong>{{ trans('dashboard.skill') }}:</strong>
                                @foreach ($project->skills as $skill)
                                    <span class="badge skill-badge">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        <div class="card-actions">
                            <a href="{{ route('Prosodic.show', $project->id) }}" class="btn btn-primary btn-action">
                                {{ trans('dashboard.show') }}
                            </a>
                            @if ($project->status == 'قيد الانتظار')
                                <a href="{{ route('Prosodic.edit', $project->id) }}"
                                    class="btn btn-warning text-white btn-action">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-danger btn-action" data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal" data-project-id="{{ $project->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @endif
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
        @include('Dashboard.Client.project.delete')
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $projects->links() }}
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#confirmDeleteModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const projectId = button.data('project-id');
                const form = $(this).find('#deleteForm');
                const actionUrl = `{{ route('Prosodic.destroy', '') }}/${projectId}`;
                form.attr('action', actionUrl);
            });
        });
    </script>
@endsection
