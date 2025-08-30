@extends('layouts.master')
@section('title',trans('dashboard.dashboard'))
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/compiled/css/dashborad.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    /* Custom styles for a calm and professional dashboard */
    body {
        background-color: #f0f2f5;
        font-family: 'Inter', sans-serif;
    }
    .stats-card {
        border-radius: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        border: none;
        background: #fff;
        padding: 1.5rem;
    }
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important;
    }
    .bg-custom-blue {
        background-color: #56b3a3 !important;
    }
    .bg-custom-green {
        background-color: #4CAF50 !important;
    }
    .bg-custom-red {
        background-color: #E57373 !important;
    }
    .bg-custom-orange {
        background-color: #FFB74D !important;
    }
    .text-custom-light {
        color: #f8f9fa !important;
    }
    .card {
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.05);
        border: none;
        background-color: #ffffff;
    }
    .card-header {
        background-color: transparent;
        border-bottom: none;
        padding-bottom: 0;
    }
    .card-header h5 {
        color: #333;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .breadcrumb-header {
        background: #ffffff;
        border-radius: .75rem;
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
    }
    .stats-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
    }
    .stats-label {
        font-size: 1rem;
        color: #6c757d;
    }
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
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
                    <a href="{{ route('dashboard') }}">{{ trans('dashboard.dashboard') }}</a>
                </li>
            </ol>
        </nav>
    </div>
</div>

@php
    // Prepare data for charts in PHP by calculating from passed variables
    $inProgressCount = $projects->where('status', 'قيد التنفيذ')->count();
    $excludedCount = $projects->where('status', 'مستبعد')->count();
    $completedCount = $projects->where('status', 'مكتمل')->count();
    $pendingCount = $projects->where('status', 'قيد الانتظار')->count();
    
    $users_service_provider = $users->where('type_user', 'service_provider')->count();
    $users_client = $users->where('type_user', 'client')->count();
    
    $requests_pending = $requests->where('status', 0)->count();
    $requests_accepted = $requests->where('status', 1)->count();
    $requests_rejected = $requests->where('status', 2)->count();
    
    $projectsStatusData = [
        'in_progress' => $inProgressCount,
        'excluded' => $excludedCount,
        'completed' => $completedCount,
        'pending' => $pendingCount,
    ];
    
    $usersTypeData = [
        'service_providers' => $users_service_provider,
        'clients' => $users_client,
    ];
    
    $requestsStatusData = [
        'pending' => $requests_pending,
        'accepted' => $requests_accepted,
        'rejected' => $requests_rejected,
    ];

    $projectLabels = [
        trans('dashboard.in_progress'),
        trans('dashboard.excluded'),
        trans('dashboard.completed'),
        trans('dashboard.pending')
    ];

    $userLabels = [
        trans('dashboard.service_providers'),
        trans('dashboard.clients')
    ];

    $requestLabels = [
        trans('dashboard.pending_requests'),
        trans('dashboard.accepted_requests'),
        trans('dashboard.rejected_requests')
    ];

@endphp

<div class="row mt-4">
    <!-- بطاقة إجمالي المعاملات المكتملة -->
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card shadow stats-card">
            <div class="card-body">
                <h3 class="stats-value text-success">{{ number_format($totalCompletedTransactions, 2) }}</h3>
                <p class="stats-label">{{ trans('dashboard.total_transactions') }}</p>
            </div>
        </div>
    </div>
    <!-- بطاقة النزاعات المفتوحة -->
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card shadow stats-card">
            <div class="card-body">
                <h3 class="stats-value text-danger">{{ $openDisputesCount }}</h3>
                <p class="stats-label">{{ trans('dashboard.open_disputes') }}</p>
            </div>
        </div>
    </div>
    <!-- بطاقة مقدمي الخدمة -->
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card shadow stats-card">
            <div class="card-body">
                <h3 class="stats-value text-primary">{{ $users_service_provider }}</h3>
                <p class="stats-label">{{ trans('dashboard.service_providers') }}</p>
            </div>
        </div>
    </div>
    <!-- بطاقة العملاء -->
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card shadow stats-card">
            <div class="card-body">
                <h3 class="stats-value text-info">{{ $users_client }}</h3>
                <p class="stats-label">{{ trans('dashboard.clients') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- مخطط حالة المشاريع (مخطط شريطي) -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar text-primary"></i> {{ trans('dashboard.project_status') }}</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="projectsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- مخطط توزيع المستخدمين (مخطط دائري) -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-pie text-success"></i> {{ trans('dashboard.user_distribution') }}</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- إضافة صف جديد لطلبات التوثيق -->
<div class="row mt-4">
    <!-- مخطط حالة طلبات التوثيق -->
    <div class="col-lg-6 offset-lg-3 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-check text-warning"></i> {{ trans('dashboard.requests') }}</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="requestsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- تضمين مكتبة Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prepare data and labels from PHP
        const projectsData = @json($projectsStatusData);
        const usersData = @json($usersTypeData);
        const requestsData = @json($requestsStatusData);

        const projectLabels = @json($projectLabels);
        const userLabels = @json($userLabels);
        const requestLabels = @json($requestLabels);

        // Chart.js global settings for better text display
        Chart.defaults.font.family = 'Inter, sans-serif';
        Chart.defaults.font.size = 12;

        // مخطط حالة المشاريع
        const projectsCtx = document.getElementById('projectsChart').getContext('2d');
        new Chart(projectsCtx, {
            type: 'bar',
            data: {
                labels: projectLabels,
                datasets: [{
                    label: 'عدد المشاريع',
                    data: [
                        projectsData.in_progress, 
                        projectsData.excluded, 
                        projectsData.completed, 
                        projectsData.pending
                    ],
                    backgroundColor: [
                        '#56b3a3',
                        '#E57373',
                        '#4CAF50',
                        '#FFB74D'
                    ],
                    borderRadius: 12,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#eee'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // مخطط توزيع المستخدمين
        const usersCtx = document.getElementById('usersChart').getContext('2d');
        new Chart(usersCtx, {
            type: 'doughnut',
            data: {
                labels: userLabels,
                datasets: [{
                    data: [usersData.service_providers, usersData.clients],
                    backgroundColor: [
                        '#56b3a3',
                        '#FFB74D'
                    ],
                    hoverOffset: 8,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#eee'
                    }
                }
            }
        });

        // مخطط حالة طلبات التوثيق
        const requestsCtx = document.getElementById('requestsChart').getContext('2d');
        new Chart(requestsCtx, {
            type: 'doughnut',
            data: {
                labels: requestLabels,
                datasets: [{
                    data: [requestsData.pending, requestsData.accepted, requestsData.rejected],
                    backgroundColor: [
                        '#FFB74D', // Pending
                        '#4CAF50', // Accepted
                        '#E57373'  // Rejected
                    ],
                    hoverOffset: 8,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#eee'
                    }
                }
            }
        });
    });
</script>
@endsection