@extends('layouts.master')

@section('title', trans('dashboard.edit_Offer'))

@section('css')
    <style>
        body {
            background: #f5f7fa;
        }

        .breadcrumb-header {
            background: #ffffff;
            border-radius: 1rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            background: #fff;
        }

        .form-control,
        .form-select {
            border: 1px solid #e0e6ed;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: 0.3s ease-in-out;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.15);
        }

        textarea.form-control {
            min-height: 120px;
        }

        label {
            font-weight: 500;
            margin-bottom: 0.4rem;
            color: #333;
        }

        .form-check-label {
            margin-left: 0.25rem;
        }

        .btn-success {
            border-radius: 2rem;
            font-size: 1rem;
            font-weight: 600;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease-in-out;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(25, 135, 84, 0.3);
        }

        .section-title {
            font-weight: 600;
            color: #555;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .skills-box {
            min-height: 70px;
            border: 1px solid #e0e6ed;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            background: #fafafa;
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
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.edit_Offer') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <form method="POST" action="{{ route('Prosodic.update', $project->id) }}">
        @csrf
        @method('PUT')
        <div class="card p-4">

            <!-- الاسم والسعر -->
            <div class="row g-3">
                <div class="col-md-6">
                    <label>{{ trans('dashboard.name') }}</label>
                    <input type="text" name="name" class="form-control" placeholder="{{ trans('dashboard.name') }}"
                        value="{{ old('name', $project->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label>{{ trans('dashboard.price') }}</label>
                    <input type="number" name="prise" class="form-control" placeholder="{{ trans('dashboard.price') }}"
                        value="{{ old('prise', $project->prise) }}" required>
                </div>
            </div>

            <!-- الوصف والفئة -->
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label>{{ trans('dashboard.description') }}</label>
                    <textarea name="description" class="form-control" placeholder="{{ trans('dashboard.description') }}" required>{{ old('description', $project->description) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label>{{ trans('dashboard.categories') }}</label>
                    <select class="form-select" name="categorie_id" id="categorie_id">
                        <option disabled>{{ trans('dashboard.categories') }}</option>
                        @foreach ($categories as $Categorie)
                            <option value="{{ $Categorie->id }}"
                                {{ $project->categorie_id == $Categorie->id ? 'selected' : '' }}>
                                {{ $Categorie->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- المدة والخبرة -->
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label>{{ trans('dashboard.duration') }}</label>
                    <select class="form-select" name="duration_id" id="duration_id">
                        <option disabled>{{ trans('dashboard.duration') }}</option>
                        @foreach ($durations as $Duration)
                            <option value="{{ $Duration->id }}"
                                {{ $project->duration_id == $Duration->id ? 'selected' : '' }}>
                                {{ $Duration->number }} {{ $Duration->duration_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>{{ trans('dashboard.Experience_level') }}</label>
                    <select class="form-select" name="experience_id" id="experience_id">
                        <option disabled>{{ trans('dashboard.Experience_level') }}</option>
                        @foreach ($experiences as $Experience)
                            <option value="{{ $Experience->id }}"
                                {{ $project->experience_id == $Experience->id ? 'selected' : '' }}>
                                {{ $Experience->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- المهارات -->
            <div class="row g-3 mt-3">
                <div class="col-12">
                    <label class="section-title">{{ trans('dashboard.skill') }}</label>
                    <div id="skills-container" class="skills-box">
                        @foreach ($project->skills as $skill)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $skill->id }}" name="skills[]"
                                    checked>
                                <label class="form-check-label">{{ $skill->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- زر -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-success">
                        {{ trans('dashboard.update') }}
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#categorie_id').on('change', function() {
                const categoryId = $(this).val();
                const skillsContainer = $('#skills-container');

                $.ajax({
                    url: `/client/categories/skills/${categoryId}`,
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        skillsContainer.empty();
                        $.each(data, function(index, skill) {
                            skillsContainer.append(`
                            <div class="form-check">
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
