@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Display order details --}}
    <h2>@lang('orders.order_details') #{{ $order->id }}</h2>

    <div class="mb-3">
        <strong>@lang('orders.date')</strong> {{ $order->created_at->format('Y-m-d H:i') }}
    </div>

    @if($order->customer)
        <div class="mb-3">
            <strong>@lang('orders.customer_name')</strong> {{ $order->customer->name }}
        </div>
    @endif

    <table class="table text-center table-bordered">
        <thead>
            <tr>
                <th>@lang('orders.product')</th>
                <th>@lang('orders.price')</th>
                <th>@lang('orders.quantity')</th>
                <th>@lang('orders.subtotal')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->pivot->price, 2) }} @lang('orders.egp')</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }} @lang('orders.egp')</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="mt-3">@lang('orders.total_receipt'): {{ number_format($order->total, 2) }} @lang('orders.egp')</h4>

    <a href="{{ route('orders.index') }}" class="mt-3 btn btn-secondary">@lang('orders.orders_back')</a>
    <button  class="mt-3 btn btn-warning" onclick="printReceipt()">@lang('orders.print_receipt') <i class="fas fa-print"></i></button>

    @if ($order->status === 'pending')
    <form method="POST" action="{{ route('orders.complete', $order->id) }}" onsubmit="return confirm('@lang('orders.confirm_complete')')">
        @csrf
        <button class="btn btn-success" type="submit" >@lang('orders.complete_order')</button>
    </form>

    <form method="POST" action="{{ route('orders.cancel', $order->id) }}"  onsubmit="return confirm('@lang('orders.confirm_cancel')')">
        @csrf
        <button class="btn btn-danger" type="submit">@lang('orders.cancel_order')</button>
    </form>

    @elseif ($order->status === 'completed')
        <form method="POST" action="{{ route('orders.refund', $order->id) }}"  onsubmit="return confirm('@lang('orders.confirm_refund')')">
            @csrf
            <button class="btn btn-danger" type="submit">@lang('orders.refund_order')</button>
        </form>
    @endif
    {{-- END order details --}}


    {{-- Order receipt to print --}}

    <div id="receipt" style="width: 300px; margin: auto;">
        <h3>@lang('orders.purchase_receipt')</h3>
        <p>@lang('orders.order_number') {{ $order->id }}</p>
        <p>@lang('orders.date') : {{ $order->created_at->format('Y-m-d H:i') }}</p>
        @if($order->customer)
            <p>@lang('orders.customer') {{ $order->customer->name }}</p>
        @endif

        <table class="text-center" style="width: 100%; border-collapse: collapse; margin-top: 10px;" border="1">
            <thead>
                <tr>
                    <th>@lang('orders.product')</th>
                    <th>@lang('orders.price')</th>
                    <th>@lang('orders.quantity')</th>
                    <th>@lang('orders.total')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->pivot->price, 2) }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>@lang('orders.total_receipt'):</strong> {{ number_format($order->total, 2) }} @lang('orders.egp')</p>
        <p>@lang('orders.thanks')</p>
    </div>

    {{-- End order receipt --}}




</div>




@endsection
