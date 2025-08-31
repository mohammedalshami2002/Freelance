@extends('layouts.master')
@section('title', trans('dashboard.disputes'))
@section('css')
@endsection
@section('page-header')
    @include('meesage')
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ auth()->user()->type_user == 'client' ? route('Client.dashboard') : route('service_provider.dashboard') }}">
                            {{ trans('dashboard.dashboard') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.Add_a_dispute') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-white border-bottom-0 text-center">
                        <h4 class="fw-bold text-dark mb-0">{{ trans('dashboard.Add_a_dispute') }}</h4>
                        <p class="text-muted mb-0">{{ trans('dashboard.select_project_and_write_reason') }}</p>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('user.disputes.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group mb-4">
                                <label for="project_id" class="form-label text-dark">{{ trans('dashboard.select_project') }}</label>
                                <select name="project_id" id="project_id" class="form-select form-select-lg rounded-pill" required>
                                    <option selected disabled>{{ trans('dashboard.select_a_project') }}</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label for="initial_reason" class="form-label text-dark">{{ trans('dashboard.initial_dispute_reason') }}</label>
                                <textarea rows="5" name="initial_reason" id="initial_reason" class="form-control form-control-lg rounded-3"
                                    placeholder="{{ trans('dashboard.write_your_message_here') }}" required></textarea>
                            </div>

                            <!-- حقل تحميل ملف (اختياري) -->
                            <div class="form-group mb-4">
                                <label for="attachment" class="form-label text-dark">{{ trans('dashboard.attachment') }}</label>
                                <input type="file" name="attachment" id="attachment"
                                    class="form-control form-control-lg rounded-pill">
                            </div>

                            <!-- زر الإرسال -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                                    <i class="fa-solid fa-reply me-2"></i>
                                    {{ trans('dashboard.send_dispute') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection