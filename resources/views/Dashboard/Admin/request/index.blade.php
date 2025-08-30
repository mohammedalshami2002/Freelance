@extends('layouts.master')

@section('title', trans('dashboard.requests'))

@section('css')
    <style>
        .breadcrumb-header {
            background-color: #f8f9fa;
            border-radius: .25rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .card-request {
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .card-request img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            cursor: pointer;
            transition: transform 0.4s ease-in-out, box-shadow 0.4s ease-in-out;
        }

        .card-request img:hover {
            transform: scale(1.08);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
            z-index: 2;
        }

        /* أنيميشن تكبير الصورة داخل الـ Modal */
        .modal-content img {
            animation: zoomIn 0.5s ease;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.6);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .status-badge {
            font-size: 0.9rem;
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
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.requests') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        @foreach ($requests as $request)
            <div class="col-md-6 col-lg-4">
                <div class="card card-request">
                    <!-- صورة الطلب -->
                    <img src="{{ URL::asset('assets/image/request/' . $request->image) }}" alt="Request Image"
                        data-bs-toggle="modal" data-bs-target="#imageModal{{ $request->id }}">

                    <div class="card-body">
                        <h5 class="card-title">{{ $request->request_type }}</h5>
                        <p class="mb-2">
                            <strong>{{ trans('dashboard.status') }}: </strong>
                            @if ($request->status == 0)
                                <span class="badge bg-warning status-badge">{{ trans('dashboard.under_review') }}</span>
                            @elseif ($request->status == 1)
                                <span
                                    class="badge bg-success status-badge">{{ trans('dashboard.Your_application_has_been_approved') }}</span>
                            @else
                                <span
                                    class="badge bg-danger status-badge">{{ trans('dashboard.Your_application_has_been_rejected') }}</span>
                            @endif
                        </p>
                        <p class="text-muted">{{ $request->created_at->diffForHumans() }}</p>

                        @if ($request->status == 0)
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#enableBackdrop{{ $request->id }}">
                                    {{ trans('dashboard.enable') }}
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#notenableBackdrop{{ $request->id }}">
                                    {{ trans('dashboard.not_enable') }}
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Modal عرض الصورة -->
                <div class="modal fade" id="imageModal{{ $request->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content bg-transparent border-0 shadow-none">
                            <img src="{{ URL::asset('assets/image/request/' . $request->image) }}"
                                class="img-fluid rounded shadow-lg">
                        </div>
                    </div>
                </div>

                @include('Dashboard.Admin.request.update')
                @include('Dashboard.Admin.request.delete')
            </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $requests->links() }}
    </div>
@endsection
