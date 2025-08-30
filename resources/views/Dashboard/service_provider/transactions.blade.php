@extends('layouts.master')
@section('title', trans('dashboard.transactions'))
@section('page-header')
    @include('meesage')
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('service_provider.dashboard') }}">{{ trans('dashboard.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">{{ trans('dashboard.transactions') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <table class="table table-striped table-dark mb-0">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>@lang('dashboard.user_name')</th>
                <th>@lang('dashboard.amount')</th>
                <th>@lang('dashboard.type')</th>
                <th>@lang('dashboard.status')</th>
                <th>@lang('dashboard.created_at')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ trans('dashboard.' . $transaction->type) }}</td>
                    <td>
                        @php
                            $badgeClass = '';
                            switch ($transaction->status) {
                                case 'completed':
                                    $badgeClass = 'badge bg-success';
                                    break;
                                case 'pending':
                                    $badgeClass = 'badge bg-warning text-dark';
                                    break;
                                default:
                                    $badgeClass = 'badge bg-secondary';
                                    break;
                            }
                        @endphp
                        <span class="{{ $badgeClass }}">{{ trans('dashboard.' . $transaction->status) }}</span>
                    </td>
                    <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">@lang('dashboard.no_transactions_found')</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $transactions->links() }}
@endsection
