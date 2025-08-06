@extends('layouts.app')
@section('content')

<div class="">
    <h3 class="mb-4">@lang('orders.orders')</h3>
    {{-- Searh Form of products or category select --}}

    <form method="GET" action="{{ route('orders.index') }}" class="mb-4 row g-2">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="@lang('orders.search_placeholder')">
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">@lang('orders.search')</button>
        </div>
    </form>

    {{-- END search --}}

    {{-- Orders List --}}
    <div class="table-responsive">
        <table class="table text-center table-bordered table-striped">
            <thead>
                <tr>
                    <th>@lang('orders.order_id')</th>
                    <th>@lang('orders.customer')</th>
                    <th>@lang('orders.status')</th>
                    <th>@lang('orders.total_price')</th>
                    <th>@lang('orders.created_at')</th>
                    <th>@lang('orders.actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer ? $order->customer->name : __('orders.no-customer') }}</td>
                        <td class="order-status">{{ $order->status }}</td>
                        <td>{{ $order->total }} @lang('orders.egp')</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">@lang('orders.view')</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
