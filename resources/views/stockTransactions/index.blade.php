@extends('layouts.app')
@section('content')
<div class="container">

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h3>@lang('stockTransactions.stockTransactions')</h3>
        <a href="{{ route('stockTransactions.create') }}" class="btn btn-primary">
            @lang('stockTransactions.create_transactions')
        </a>
    </div>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('stockTransactions.index') }}" class="mb-4 row g-2">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="@lang('stockTransactions.search_placeholder')">
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">@lang('stockTransactions.search')</button>
        </div>
    </form>
    {{-- END Search Form --}}

    {{-- Stock Transactions List --}}

    <div class="table-responsive">
        <table class="table text-center table-bordered table-striped">
            <thead>
                <tr>
                    <th>@lang('stockTransactions.product')</th>
                    <th>@lang('stockTransactions.quantity')</th>
                    <th>@lang('stockTransactions.type')</th>
                    <th>@lang('stockTransactions.storekeeper_name')</th>
                    <th>@lang('stockTransactions.notes')</th>
                    <th>@lang('stockTransactions.transaction_time')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stockTransactions as $transaction)
                    <tr>
                        <td>{{ $transaction->product->name }}</td>
                        <td>{{ $transaction->quantity }}</td>
                        <td>{{ $transaction->type == 'in' ? __('stockTransactions.incoming') : __('stockTransactions.outgoing') }}</td>
                        <td>{{ $transaction->lastActivity?->causer?->name ?? 'System' }}</td>
                        <td>{{ $transaction->notes }}</td>
                        <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



</div>
@endsection
