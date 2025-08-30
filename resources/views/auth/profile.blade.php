@extends('layouts.master')
@section('title', trans('dashboard.profile'))
@section('css')
<style>
    .breadcrumb-header {
        background-color: #f8f9fa;
        border-radius: .25rem;
        padding: 1rem 1.5rem;
        margin-bottom: 0rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    .page-title h5 {
        display: inline-block;
        margin-right: .5rem;
        color: #007bff;
        font-weight: bold;
    }
    .img-thumbnail {
        width: 150px;
        height: 150px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .img-thumbnail:hover {
        transform: scale(1.1);
    }

    .btn {
        border-radius: 20px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        box-shadow: 0 0 10px rgba(0, 91, 187, 0.5);
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s, transform 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
    .form-control {
        transition: box-shadow 0.3s;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        border-color: #007bff;
    }
    hr {
        margin: 20px 0;
        border-top: 1px solid #e9ecef;
    }
    .profile-box {
        padding: 5px;
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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
                <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.profile') }}</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 profile-box">
            <form method="post" action="{{route('profile.admin.update')}}" enctype="multipart/form-data">
                @csrf
                <img src="{{URL::asset('assets/image/Profile/'.auth()->user()->image)}}" alt="Default Image"  class="img-thumbnail">
                <div class='fs-6'>Profile image should have jpg, jpeg, gif, png extension and size should not be more than 5MB</div>
                <div><input type="file" name="image" class="btn btn-secondary w-25"></div>
                <div class="d-flex mt-2 gap-2">
                    <div class="form-group w-50">
                        <label for="name">{{ trans('dashboard.name') }}:</label>
                        <input type="text" class="form-control" name="name" value="{{auth()->user()->name}}" required>
                    </div>
                    <div class="form-group w-50">
                        <label for="email"> {{ trans('login.email') }} :</label>
                        <input type="email" class="form-control" name="email" value="{{auth()->user()->email}}" required>
                    </div>
                </div>
                <hr>
                <div class="d-flex mt-2 gap-2">
                    <div class="form-group w-50">
                        <label for="new-password">{{trans('login.password_old')}}</label>
                        <input type="password" class="form-control" name="password_old">
                    </div>
                    <div class="form-group w-50">
                        <label for="new-password">{{trans('login.password_new')}}</label>
                        <input type="password" class="form-control" name="new_password">
                    </div>
                    <div class="form-group w-50">
                        <label for="confirm-password">{{trans('login.password_check')}}</label>
                        <input type="password" class="form-control" nmae="confirm_password">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">{{trans('login.save_change')}}</button>
            </form>
        </div>
    </div>
</div>


@endsection
