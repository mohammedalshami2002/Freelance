@extends('layouts.master2')
@section('title', trans('login.change_the_password'))
@section('css')
    <style>
        :root {
            --primary-color: #5b7db1;
            --secondary-color: #a3c4f3;
            --text-dark: #2b2b2b;
            --text-light: #666;
            --border-color: #dddddd;
            --card-bg: #ffffff;
            --shadow-light: 0 4px 15px rgba(0, 0, 0, 0.05);
            --shadow-strong: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        body {
            background-color: var(--secondary-color);
            font-family: 'Cairo', sans-serif;
        }

        .main-container {
            min-height: 100vh;
        }

        /* الصورة */
        .login-image {
            background: url('{{ URL::asset('assets/image/logo2.png') }}') center center / cover no-repeat;
            min-height: 100vh;
        }

        /* الفورم */
        .form-side {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .form-container {
            width: 100%;
            max-width: 420px;
            background-color: var(--card-bg);
            padding: 2.5rem 2rem;
            border-radius: 1rem;
            box-shadow: var(--shadow-light);
            text-align: center;
        }

        /* أيقونة */
        .user-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .form-container h2 {
            color: var(--primary-color);
            font-weight: 900;
            margin-bottom: 0.5rem;
        }

        .form-container h5 {
            font-size: 0.95rem;
            font-weight: 400;
            color: var(--text-light);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        /* حقل الكود */
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-control {
            height: 50px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding-left: 45px;
            font-size: 1.1rem;
            letter-spacing: 5px;
            text-align: center;
            font-weight: bold;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(91, 125, 177, 0.2);
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            transition: color 0.3s ease;
        }

        .form-control:focus+i {
            color: var(--primary-color);
        }

        /* زر */
        .btn-submit {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.9rem;
            font-weight: 700;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-light);
        }

        .btn-submit:hover {
            background-color: #476a99;
            transform: translateY(-2px);
            box-shadow: var(--shadow-strong);
        }
        @media (max-width: 991.98px) {
            .login-image {
                display: none; 
            }
            .form-side {
                padding: 1.5rem;
            }
            .form-container {
                max-width: 100%;
                padding: 2rem 1.5rem;
            }
        }
    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
@endsection
@section('body')
    <div class="container-fluid main-container p-0">
        <div class="row g-0 h-100 justify-content-center">
            <div class="col-12 col-lg-6 login-image"></div>
            <div class="col-12 col-md-8 col-lg-6 form-side">
                <div class="form-container">
                    <div class="user-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    @include('meesage')
                    <h2 class="mb-4">{{ trans('login.change_the_password') }}</h2>
                    <form method="POST" action="{{ route('change.password') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <div class="input-group">
                            <input type="password" name="new_password" class="form-control"
                                placeholder="{{ trans('login.password_new') }}" required>
                            <i class="bi bi-lock"></i>
                        </div>
                        <div class="input-group">
                            <input type="password" name="confirm_password" class="form-control"
                                placeholder="{{ trans('login.password_check') }}" required>
                            <i class="bi bi-lock"></i>
                        </div>
                        <button type="submit" class="btn-submit shadow-sm mt-5">
                            <i class="bi bi-arrow-repeat"></i> {{ trans('login.enable') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
