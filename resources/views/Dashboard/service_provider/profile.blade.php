@extends('layouts.master')

@section('title', trans('dashboard.profile'))

@section('css')
    <style>
        :root {
            --primary-color: #5B86E5;
            --secondary-color: #3f68a5;
            --background-color: #F0F2F5;
            --card-bg: #FFFFFF;
            --text-dark: #333;
            --text-light: #777;
            --border-color: #E9ECEF;
            --success-color: #28A745;
        }

        body {
            background-color: var(--background-color);
            font-family: 'Tajawal', sans-serif;
        }

        .breadcrumb-header {
            background-color: var(--card-bg);
            border-radius: .5rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .profile-form-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background-color: var(--card-bg);
            padding: 3rem;
        }

        .form-section {
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 2rem;
            margin-bottom: 2rem;
        }

        .form-section-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            text-align: right;
            border-bottom: 2px solid var(--primary-color);
            display: inline-block;
            padding-bottom: 0.5rem;
        }

        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .profile-image-container {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid var(--border-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .profile-image-container:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .profile-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rating-stars i {
            font-size: 1.6rem;
            color: var(--warning-color);
            margin: 0 2px;
        }

        .form-group label {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-align: right;
            width: 100%;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            box-shadow: none;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(91, 134, 229, 0.25);
        }

        .skill-badges-container {
            border: 1px dashed var(--border-color);
            border-radius: 10px;
            padding: 1rem;
            background-color: #f8f9fa;
            min-height: 50px;
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            direction: rtl;
            justify-content: flex-end;
        }

        .form-check {
            padding-right: 2rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            letter-spacing: 1px;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .alert-success {
            background-color: var(--success-color);
            color: var(--text-white);
            border-radius: 10px;
            font-weight: 600;
            padding: 1rem;
        }
    </style>
@endsection

@section('page-header')
    @include('meesage')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb" class="breadcrumb-header">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('service_provider.dashboard') }}">
                                {{ trans('dashboard.dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.profile') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-lg-10 col-md-12">
                <div class="card profile-form-card">
                    <form method="post" action="{{ route('Profiles.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="profile-header">
                            <div class="profile-image-container">
                                <img src="{{ URL::asset('assets/image/Profile/' . auth()->user()->image) }}"
                                    alt="Profile Image" class="img-fluid">
                            </div>
                            <input type="file" name="image" class="form-control w-75 mx-auto">
                        </div>

                        <div class="form-section">
                            <h4 class="form-section-title">{{ trans('dashboard.personal_information') }}</h4>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ trans('dashboard.name') }}</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ auth()->user()->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="profile">{{ trans('dashboard.phone_number') }}</label>
                                        <input type="text" class="form-control" name="phone_number" required
                                            value="{{ $profiles->phone_number ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="profile">{{ trans('dashboard.A_brief_introduction') }}</label>
                                        <textarea class="form-control" name="profile" rows="3" required>{{ $profiles->profile ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="profile">{{ trans('dashboard.University_name') }}</label>
                                        <input class="form-control" name="university_name" rows="3"
                                            required{{ $profiles->university_name ?? '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="profile">{{ trans('dashboard.Specialization') }}</label>
                                        <input class="form-control" name="specialization" rows="3"
                                            required{{ $profiles->specialization ?? '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ trans('dashboard.rating') }}</label>
                                        <div class="rating-stars text-right">
                                            @php
                                                $averageRating = $user->ratings->avg('rating');
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
                                </div>
                            </div>

                            {{-- Section for account verification --}}
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ trans('dashboard.Account_verification') }}</label>
                                        @php
                                            $requestVerification = auth()->user()->latestVerificationRequest;
                                        @endphp

                                        @if (!$requestVerification)
                                            {{-- لا يوجد أي طلب سابق --}}
                                            <div class="form-group mt-4">
                                                <label
                                                    for="image_authenticated">{{ trans('dashboard.image_to_verify_account') }}</label>
                                                <input type="file" class="form-control" name="image_authenticated"
                                                    required>
                                            </div>
                                        @elseif ($requestVerification->status == 0)
                                            {{-- الطلب قيد المراجعة --}}
                                            <div class="alert alert-info mt-4 text-white" role="alert">
                                                <i class="bi bi-hourglass-split me-2"></i>
                                                {{ trans('dashboard.verification_pending') }}
                                            </div>
                                        @elseif ($requestVerification->status == 1)
                                            {{-- الحساب موثق --}}
                                            <div class="alert alert-success mt-4 text-white" role="alert">
                                                <i class="bi bi-check-circle-fill me-2"></i>
                                                {{ trans('dashboard.verified_account') }}
                                            </div>
                                        @elseif ($requestVerification->status == 2)
                                            {{-- الطلب مرفوض --}}
                                            <div class="alert alert-danger mt-4" role="alert">
                                                <i class="bi bi-x-circle-fill me-2"></i>
                                                {{ trans('dashboard.verification_rejected') }}
                                            </div>
                                            <div class="form-group mt-4">
                                                <label
                                                    for="image_authenticated">{{ trans('dashboard.reupload_verification_image') }}</label>
                                                <input type="file" class="form-control" name="image_authenticated"
                                                    required>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h4 class="form-section-title">{{ trans('dashboard.skills_and_categories') }}</h4>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="categorie_id">{{ trans('dashboard.categories') }}</label>
                                        <select class="form-select" name="categorie_id" id="categorie_id">

                                            @foreach ($Categories as $Categorie)
                                                <option value="{{ $Categorie->id }}"
                                                    {{ $requestVerification->categorie_id == $Categorie->id ? 'selected' : '' }}>
                                                    {{ $Categorie->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="skills">{{ trans('dashboard.skill') }}</label>
                                        <div id="skills-container" class="skill-badges-container">
                                            @foreach ($user->skills as $skill)
                                                <div class="form-check me-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="{{ $skill->id }}" name="skills[]" checked>
                                                    <label class="form-check-label">{{ $skill->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h4 class="form-section-title">{{ trans('login.change_the_password') }}</h4>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="password_old">{{ trans('login.password_old') }}</label>
                                        <input type="password" class="form-control" name="password_old">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_password">{{ trans('login.password_new') }}</label>
                                        <input type="password" class="form-control" name="new_password">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="confirm_password">{{ trans('login.password_check') }}</label>
                                        <input type="password" class="form-control" name="confirm_password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="btn btn-primary btn-block mt-4">{{ trans('login.save_change') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#categorie_id').on('change', function() {
                const categoryId = $(this).val();
                const skillsContainer = $('#skills-container');

                $.ajax({
                    url: `/service_provider/categories/skills/${categoryId}`,
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        skillsContainer.empty();
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
