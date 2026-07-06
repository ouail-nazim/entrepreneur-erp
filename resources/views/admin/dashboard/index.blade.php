@extends('layouts.adminlte')

@section('title', __('menu.dashboard'))
@section('page-header', __('menu.dashboard'))

@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('menu.dashboard') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_contacts'] }}</h3>
                <p>{{ __('dashboard.total_contacts') }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('contacts.index') }}" class="small-box-footer">{{ __('dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['total_products'] }}</h3>
                <p>{{ __('dashboard.total_products') }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
            <a href="{{ route('products.index') }}" class="small-box-footer">{{ __('dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['pending_timesheets'] }}</h3>
                <p>{{ __('dashboard.pending_timesheets') }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('timesheets.index') }}?status=pending" class="small-box-footer">{{ __('dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['low_stock_products'] }}</h3>
                <p>{{ __('dashboard.low_stock_products') }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <a href="{{ route('products.index') }}?filter=low_stock" class="small-box-footer">{{ __('dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-primary"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('dashboard.purchases_this_month') }}</span>
                <span class="info-box-number">{{ $stats['purchases_this_month'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-info"><i class="fas fa-file-invoice-dollar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('dashboard.invoices_this_month') }}</span>
                <span class="info-box-number">{{ $stats['total_invoices_this_month'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-danger"><i class="fas fa-money-bill-wave"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('dashboard.monthly_expenses') }}</span>
                <span class="info-box-number">{{ number_format($stats['monthly_expenses'], 2) }} {{ $settings['currency'] ?? '€' }}</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-success"><i class="fas fa-chart-line"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('dashboard.total_contacts') }}</span>
                <span class="info-box-number">{{ $stats['total_contacts'] }}</span>
            </div>
        </div>
    </div>
</div>

@if(($settings['company_name'] ?? '') == '')
<div class="alert alert-warning">
    <h5><i class="icon fas fa-exclamation-triangle"></i> {{ __('settings.title') }} !</h5>
    {{ __('settings.please_configure') ?? 'Please configure your company settings.' }}
    <a href="{{ route('settings.index') }}" class="btn btn-sm btn-outline-dark ml-2">{{ __('settings.title') }}</a>
</div>
@endif

<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('dashboard.monthly_hours') }}</h3>
            </div>
            <div class="card-body">
                <canvas id="daysChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('dashboard.invoice_types') }}</h3>
            </div>
            <div class="card-body">
                <canvas id="invoiceChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">{{ __('dashboard.recent_contacts') }}</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>{{ __('contacts.full_name') }}</th>
                            <!-- <th>{{ __('contacts.email') }}</th> -->
                            <th>{{ __('contacts.hire_date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_contacts as $contact)
                        <tr>
                            <td>{{ $contact->full_name }}</td>
                            <!-- <td>{{ $contact->email }}</td> -->
                            <td>{{ $contact->hire_date->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('contacts.index') }}">{{ __('contacts.list') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">{{ __('dashboard.recent_purchases') }}</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>{{ __('products.name') }}</th>
                            <th>{{ __('purchases.quantity') }}</th>
                            <th>{{ __('purchases.total') }}</th>
                            <th>{{ __('purchases.date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->product->name }}</td>
                            <td>{{ $purchase->quantity }}</td>
                            <td>{{ number_format($purchase->total, 2) }} {{ $settings['currency'] ?? '€' }}</td>
                            <td>{{ $purchase->purchase_date->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">{{ __('dashboard.recent_timesheets') }}</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>{{ __('timesheets.employee') }}</th>
                            <th>{{ __('timesheets.date') }}</th>
                            <th>{{ __('timesheets.days') }}</th>
                            <th>{{ __('timesheets.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_timesheets as $timesheet)
                        <tr>
                            <td>{{ $timesheet->contact->full_name }}</td>
                            <td>{{ $timesheet->date->format('Y-m-d') }}</td>
                            <td>{{ $timesheet->quantity }}</td>
                            <td>
                                @if($timesheet->status == 'validated')
                                    <span class="badge badge-success">{{ __('timesheets.validated') }}</span>
                                @elseif($timesheet->status == 'pending')
                                    <span class="badge badge-warning">{{ __('timesheets.pending') }}</span>
                                @else
                                    <span class="badge badge-danger">{{ __('timesheets.rejected') }}</span>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(function () {
        var ctx = document.getElementById('daysChart').getContext('2d');
        var chartData = @json($monthly_days);

        var labels = chartData.map(function(item) {
            var monthNames = ["", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            return monthNames[item.month];
        });

        var data = chartData.map(function(item) {
            return item.total_days;
        });

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "{{ __('timesheets.days') }}",
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    data: data
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Invoice Pie Chart
        var invoiceCtx = document.getElementById('invoiceChart').getContext('2d');
        var invoiceData = @json($invoice_stats);

        var invoiceLabels = invoiceData.map(function(item) {
            return item.invoice_type.charAt(0).toUpperCase() + item.invoice_type.slice(1);
        });

        var invoiceCounts = invoiceData.map(function(item) {
            return item.total;
        });

        new Chart(invoiceCtx, {
            type: 'pie',
            data: {
                labels: invoiceLabels,
                datasets: [{
                    data: invoiceCounts,
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
            }
        });
    });
</script>
@endpush
