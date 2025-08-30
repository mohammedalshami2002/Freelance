@extends('layouts.master')
@section('title', trans('dashboard.dispute_details'))
@section('css')
    <style>
        .breadcrumb-header {
            background-color: #f9fafb;
            border-radius: .5rem;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: none;
        }

        .card-header {
            background: #f5f7fa;
            border-bottom: 1px solid #e5e7eb;
        }

        .card-body {
            background-color: #ffffff;
        }

        .callout-info {
            border-left: 5px solid #3b82f6;
            background: #eff6ff;
            padding: 1rem;
            border-radius: 8px;
        }

        .badge {
            font-size: 0.85rem;
            padding: .4rem .7rem;
            border-radius: 20px;
        }

        .badge-warning {
            background: #fde68a !important;
            color: #92400e !important;
        }

        .badge-success {
            background: #bbf7d0 !important;
            color: #065f46 !important;
        }

        .badge-secondary {
            background: #e5e7eb !important;
            color: #374151 !important;
        }

        .alert {
            border-radius: 12px;
        }

        .timeline-item {
            position: relative;
            padding-left: 40px;
            border-left: 2px solid #e9ecef;
            margin-bottom: 20px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: #4e73df;
        }

        .timeline-user-client::before {
            background-color: #4e73df;
        }

        .timeline-user-provider::before {
            background-color: #28a745;
        }

        .timeline-user-admin::before {
            background-color: #dc3545;
        }

        .message-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
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
                        <a href="{{ auth()->user()->typre == 'client' ? route('Client.dashboard'):route('service_provider.dashboard') }}">{{ trans('dashboard.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('user.disputes.index') }}">{{ trans('dashboard.disputes') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('dashboard.dispute_details')</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">

                <div class="card card-outline">
                    <div class="card-body">

                        <!-- معلومات النزاع -->
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info-circle"></i> @lang('dashboard.dispute_info')</h5>
                            <p>
                                <strong>@lang('dashboard.initial_reason'):</strong>
                                {{ $dispute->initial_reason ?? trans('dashboard.null') }}<br>
                                <strong>@lang('dashboard.project_name'):</strong>
                                {{ $dispute->project->name ?? trans('dashboard.null') }}<br>
                                <strong>@lang('login.client'):</strong>
                                {{ $dispute->client->name ?? trans('dashboard.null') }}<br>
                                <strong>@lang('login.service_provider'):</strong>
                                {{ $dispute->serviceProvider->name ?? trans('dashboard.null') }}<br>
                                <strong>@lang('dashboard.status'):</strong>
                                @php
                                    $statusClass = match ($dispute->status) {
                                        'open' => 'badge badge-warning',
                                        'resolved' => 'badge badge-success',
                                        default => 'badge badge-secondary',
                                    };
                                @endphp
                                <span class="{{ $statusClass }}">{{ trans('dashboard.' . $dispute->status) }}</span>
                            </p>
                        </div>

                        <!-- خط الزمن للرسائل -->
                        <h5 class="mt-4">@lang('dashboard.dispute_timeline')</h5>
                        <hr>
                        @if ($dispute->messages->isEmpty())
                            <div class="alert alert-warning text-center">
                                @lang('dashboard.no_messages_in_dispute')
                            </div>
                        @else
                            @foreach ($dispute->messages as $message)
                                <div class="timeline-item">
                                    <div class="card mb-3 border-0 shadow-sm">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">
                                                <strong>{{ $message->user->name ?? trans('dashboard.null') }}</strong>
                                                @if ($message->user_id == $dispute->client_id)
                                                    <small class="text-primary">(@lang('login.client'))</small>
                                                @elseif($message->user_id == $dispute->service_provider_id)
                                                    <small class="text-info">(@lang('login.service_provider'))</small>
                                                @else
                                                    <small class="text-danger">(@lang('dashboard.admin'))</small>
                                                @endif
                                            </h6>
                                            <small class="text-muted">{{ $message->created_at->format('Y-m-d H:i') }}</small>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text">{{ $message->message }}</p>
                                            @if ($message->attachment_path)
                                                <a href="{{ Storage::url($message->attachment_path) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-secondary mt-2">
                                                    <i class="fas fa-paperclip"></i> @lang('dashboard.view_attachment')
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
                    <!-- نموذج الرد (يظهر فقط إذا كان النزاع مفتوحًا) -->
                    @if ($dispute->status !== 'resolved')
                        <div class="card-footer message-form">
                            <form action="{{ route('user.disputes.addMessage', $dispute->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="message" class="form-label">@lang('dashboard.your_reply')</label>
                                    <textarea name="message" id="message" rows="4" class="form-control" placeholder="@lang('dashboard.write_your_message_here')" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="attachment" class="form-label">@lang('dashboard.attachment')</label>
                                    <input type="file" name="attachment" id="attachment" class="form-control">
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-reply me-2"></i>@lang('dashboard.send_reply')
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="card-footer alert-success text-center">
                            <i class="fas fa-check"></i> @lang('dashboard.dispute_resolved_cannot_reply')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
