@extends('layouts.master')

@section('title', trans('dashboard.Site_Setting'))

@section('css')
    <style>
        .breadcrumb-header {
            background-color: #ffffff;
            border-radius: 1rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .form-card {
            background: #ffffff;
            border-radius: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .form-control {
            background-color: #fdfdfd;
            border-radius: 2rem;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: #0052b1;
            box-shadow: 0 0 8px rgba(25, 82, 135, 0.3);
        }

        .btn-custom {
            border-radius: 2rem;
            padding: 0.75rem;
            font-size: 1.1rem;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0, 132, 255, 0.6);
            transition: all 0.3s;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection

@section('page-header')
    @include('meesage')
    <div class="row mb-3">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">
                            {{ trans('dashboard.dashboard') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard.Site_Setting') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('Site_Setting.update') }}">
            @csrf
            <div class="row g-4">
                <!-- رقم حساب السحب -->
                <div class="col-12">
                    <label for="withdrawal_account_number" class="form-label">
                        {{ trans('dashboard.withdrawal_account_number') }}
                    </label>
                    <input type="text" id="withdrawal_account_number" name="withdrawal_account_number"
                        value="{{ $sitesetting->withdrawal_account_number ?? '' }}" class="form-control form-control-lg"
                        required>
                </div>

                <!-- نسبة العمولة -->
                <div class="col-md-6">
                    <label for="commission_percentage" class="form-label">
                        {{ trans('dashboard.commission_percentage') }}
                    </label>
                    <input type="number" step="0.01" id="commission_percentage" name="commission_percentage"
                        value="{{ $sitesetting->commission_percentage ?? '' }}" class="form-control form-control-lg"
                        required>
                </div>

                <!-- الحد الأدنى للسحب -->
                <div class="col-md-6">
                    <label for="minimum_withdrawal_amount" class="form-label">
                        {{ trans('dashboard.minimum_withdrawal_amount') }}
                    </label>
                    <input type="number" step="0.01" id="minimum_withdrawal_amount" name="minimum_withdrawal_amount"
                        value="{{ $sitesetting->minimum_withdrawal_amount ?? '' }}" class="form-control form-control-lg"
                        required>
                </div>

                <!-- رسوم المعاملة -->
                <div class="col-md-6">
                    <label for="transaction_fee" class="form-label">
                        {{ trans('dashboard.transaction_fee') }}
                    </label>
                    <input type="number" step="0.01" id="transaction_fee" name="transaction_fee"
                        value="{{ $sitesetting->transaction_fee ?? '' }}" class="form-control form-control-lg" required>
                </div>

                <!-- زر التحديث -->
                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary w-50">
                        {{ trans('dashboard.update') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
