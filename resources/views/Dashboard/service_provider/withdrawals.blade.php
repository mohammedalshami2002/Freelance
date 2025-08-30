@extends('layouts.master')
@section('title', trans('dashboard.withdraw_funds'))

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Inter', sans-serif;
            color: #333;
        }

        .breadcrumb-header {
            background-color: #ffffff;
            border-radius: 0.75rem;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .withdraw-card {
            border-radius: 1rem;
            background: #fff;
            padding: 2rem;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .withdraw-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.08);
        }

        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #ddd;
            padding: 0.75rem;
            font-size: 0.95rem;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #4a90e2, #357bd9);
            border: none;
            border-radius: 0.6rem;
            font-weight: 600;
            color: #fff;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #357bd9, #2c6ecb);
        }

        .balance-info {
            font-size: 1.1rem;
            font-weight: 600;
            color: #444;
        }

        .card.shadow {
            border-radius: 1rem;
            border: none;
        }

        .table {
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .table thead {
            background: #f0f3f7;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.5em 0.8em;
            border-radius: 0.5rem;
        }
    </style>
@endsection

@section('page-header')
    @include('meesage')

    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('service_provider.dashboard') }}">
                            {{ trans('dashboard.dashboard') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ trans('dashboard.withdraw_funds') }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="withdraw-card">
                <h4 class="mb-4"><i class="fa-solid fa-wallet me-2 text-primary"></i>
                    {{ trans('dashboard.request_withdrawal') }}</h4>

                <p class="balance-info">
                    {{ trans('dashboard.current_balance') }}:
                    <span class="text-success">${{ number_format($currentBalance, 2) }}</span>
                </p>
                <p class="text-danger mt-1">
                    {{ trans('dashboard.minimum_withdrawal_amount') }}:
                    <span class="fw-bold">${{ number_format($minimumWithdrawal, 2) }}</span>
                </p>

                <p class="text-danger mt-1">
                    {{ trans('dashboard.transaction_fee') }}:
                    <span class="fw-bold">${{ number_format($transactionFee, 2) }}</span>
                </p>


                <form action="{{ route('service_provider.withdraw.request') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label">{{ trans('dashboard.withdrawal_amount') }}</label>
                        <input type="number" class="form-control" id="amount" name="amount" required step="0.01"
                            min="{{ $minimumWithdrawal }}">
                    </div>
                    <div class="mb-3">
                        <label for="method" class="form-label">{{ trans('dashboard.withdrawal_method') }}</label>
                        <select class="form-control" id="method" name="method" required>
                            <option value="bank_transfer">{{ trans('dashboard.bank_transfer') }}</option>
                            <option value="other">{{ trans('dashboard.other_method') }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="details" class="form-label">{{ trans('dashboard.withdrawal_details') }}</label>
                        <textarea class="form-control" id="details" name="details" rows="3"
                            placeholder="{{ trans('dashboard.enter_payment_details') }}"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100 mt-3">
                        <i class="fa-solid fa-paper-plane me-1"></i> {{ trans('dashboard.submit_request') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-4"><i class="fa-solid fa-list me-2 text-secondary"></i>
                        {{ trans('dashboard.withdrawal_history') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('dashboard.date') }}</th>
                                    <th>{{ trans('dashboard.amount') }}</th>
                                    <th>{{ trans('dashboard.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdrawals as $withdrawal)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $withdrawal->created_at->format('Y-m-d H:i') }}</td>
                                        <td>{{ number_format($withdrawal->amount, 2) }}</td>
                                        <td>
                                            @if ($withdrawal->status == 'pending')
                                                <span class="badge bg-warning"><i class="fa-solid fa-clock me-1"></i>
                                                    {{ trans('dashboard.pending') }}</span>
                                            @elseif($withdrawal->status == 'completed')
                                                <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i>
                                                    {{ trans('dashboard.completed') }}</span>
                                            @else
                                                <span class="badge bg-danger"><i class="fa-solid fa-xmark me-1"></i>
                                                    {{ trans('dashboard.rejected') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
