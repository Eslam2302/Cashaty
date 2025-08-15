@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- KPIs --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($todayOrdersCount) }}</h3>
                    <p>@lang('dashboard.today_orders')</p>
                </div>
                <div class="icon"><i class="fas fa-clipboard-list"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($todayRevenue, 2) }} <sup style="font-size:14px">@lang('dashboard.egp')</sup></h3>
                    <p>@lang('dashboard.sales_today')</p>
                </div>
                <div class="icon"><i class="fas fa-coins"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($lowStockCount) }}</h3>
                    <p>@lang('dashboard.low_product_stock')</p>
                </div>
                <div class="icon"><i class="fas fa-battery-quarter"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ number_format($inStockProductsCount) }}</h3>
                    <p>@lang('dashboard.available_products')</p>
                </div>
                <div class="icon"><i class="fas fa-boxes"></i></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ number_format($monthlyRevenue ?? 0, 2) }} @lang('dashboard.egp')</h3>
                    <p>@lang('dashboard.sales_this_month')</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-alt"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ $completedOrdersCount ?? 0 }}</h3>
                    <p>@lang('dashboard.completed_orders')</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $customersCount ?? 0 }}</h3>
                    <p>@lang('dashboard.count_customers')</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $topProductName ?? '-' }}</h3>
                    <p>@lang('dashboard.top_sales_product')</p>
                </div>
                <div class="icon"><i class="fas fa-star"></i></div>
            </div>
        </div>
    </div>

    {{-- Last 10 orders table --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 card-title">@lang('dashboard.last_10_orders')</h3>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-list-check"></i> @lang('dashboard.all_orders')
                    </a>
                </div>
                <div class="p-0 card-body table-responsive">
                    <table class="table mb-0 table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('dashboard.customer')</th>
                                <th>@lang('dashboard.total')</th>
                                <th>@lang('dashboard.status')</th>
                                <th>@lang('dashboard.payment')</th>
                                <th>@lang('dashboard.date')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentOrders as $o)
                                <tr>
                                    <td><a href="{{ route('orders.show', $o->id) }}">#{{ $o->id }}</a></td>
                                    <td>{{ optional($o->customer)->name ?? __('dashboard.no_customer') }}</td>
                                    <td>{{ number_format($o->total, 2) }} @lang('dashboard.egp')</td>
                                    <td>
                                        <span class="badge badge-{{ $o->status === 'completed' ? 'success' : ($o->status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ $o->status }}
                                        </span>
                                    </td>
                                    <td>{{ strtoupper($o->payment_method ?? '-') }}</td>
                                    <td>{{ $o->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">@lang('dashboard.no_information')</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
