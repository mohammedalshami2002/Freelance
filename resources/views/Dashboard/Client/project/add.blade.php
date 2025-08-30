@extends('layouts.master')

@section('title', trans('dashboard.Add_Offer'))

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
            padding: 2rem;
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
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.Add_Offer') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('Prosodic.store') }}">
            @csrf

            <!-- الاسم والسعر -->
            <div class="row g-3">
                <div class="col-md-6">
                    <label>{{ trans('dashboard.name') }}</label>
                    <input type="text" name="name" class="form-control" placeholder="{{ trans('dashboard.name') }}"
                        required>
                </div>
                <div class="col-md-6">
                    <label>{{ trans('dashboard.price') }}</label>
                    <input type="number" name="prise" class="form-control" placeholder="{{ trans('dashboard.price') }}"
                        required>
                </div>
            </div>

            <!-- الوصف والفئة -->
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label>{{ trans('dashboard.description') }}</label>
                    <textarea name="description" class="form-control" placeholder="{{ trans('dashboard.description') }}" required></textarea>
                </div>
                <div class="col-md-6">
                    <label>{{ trans('dashboard.categories') }}</label>
                    <select class="form-select" name="categorie_id" id="categorie_id">
                        <option disabled selected>{{ trans('dashboard.categories') }}</option>
                        @foreach ($Categories as $Categorie)
                            <option value="{{ $Categorie->id }}">{{ $Categorie->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- المدة والخبرة -->
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label>{{ trans('dashboard.duration') }}</label>
                    <select class="form-select" name="duration_id">
                        <option disabled selected>{{ trans('dashboard.duration') }}</option>
                        @foreach ($Durations as $Duration)
                            <option value="{{ $Duration->id }}">{{ $Duration->number }} {{ $Duration->duration_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>{{ trans('dashboard.Experience_level') }}</label>
                    <select class="form-select" name="experience_id">
                        <option disabled selected>{{ trans('dashboard.Experience_level') }}</option>
                        @foreach ($Experiences as $Experience)
                            <option value="{{ $Experience->id }}">{{ $Experience->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- المهارات -->
            <div class="row g-3 mt-3">
                <div class="col-12">
                    <label>{{ trans('dashboard.skill') }}</label>
                    <div id="skills-container" class="skills-box"></div>
                </div>
            </div>

            <!-- زر -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-success w-50">
                        {{ trans('dashboard.create') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

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
