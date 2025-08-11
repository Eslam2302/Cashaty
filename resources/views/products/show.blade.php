@extends('layouts.app')

@section('content')
<div class="container my-4">


    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h2 class="mb-4">{{ $product->name }}</h2>

        <h2 class="mb-4">@lang('stockTransactions.stockTransactions')</h2>
    </div>

    <div class="row">
        <div class="col-md-3">
            @php
                $imagePath = $product->image ? asset('uploads/products/' . $product->image) : asset('images/no.jpeg');
            @endphp
            <img src="{{ $imagePath }}" class="border rounded img-fluid" alt="{{ $product->name }}">

            <div class="product-btns">
                @can('edit product')
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-md btn-warning">@lang('products.edit')</a>
                @endcan

                @can('delete product')
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('@lang('products.confirm_delete')')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-md btn-danger">@lang('products.delete')</button>
                    </form>
                @endcan

            </div>

        </div>

        <div class="col-md-3">

            <h5 class="mb-1 text-muted">@lang('products.price') :</h5>
            @if ($product->discount > 0)
                <span class="mb-1 mr-3 card-text ">{{ number_format($product->discount_price, 2) }} @lang('products.egp')</span>
                <del class="mb-1 card-text text-muted">{{ number_format($product->price, 2) }}  @lang('products.egp')</del>
            @else
                <p class="mb-1 card-text">{{ number_format($product->price, 2) }} @lang('products.egp')</p>
            @endif

            <h5 class="mb-1 text-muted">@lang('products.discount') :</h5>
            <p>{{ number_format($product->discount) }} %</p>

            <h5 class="mb-1 text-muted">@lang('products.description') :</h5>
            <p>{{ $product->description ?? __('products.no_descripton') }}</p>

            <h5 class="mb-1 text-muted">@lang('products.category') :</h5>
            <p>{{ $product->category->name ?? __('products.no_select') }}</p>

            <h5 class="mb-1 text-muted">@lang('products.available_stock') :</h5>
            @if ($product->available_stock <= 0)
                <p class="text-danger">@lang('products.out_of_stock')</p>
            @elseif ($product->available_stock < 5)
                <p>{{ $product->available_stock }}</p>
            @else
                <p><span>{{ $product->available_stock }}</span></p>
            @endif
        </div>

        @can('view stock')
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('stockTransactions.quantity')</th>
                                <th>@lang('stockTransactions.type')</th>
                                <th>@lang('stockTransactions.notes')</th>
                                <th>@lang('stockTransactions.transaction_time')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stockTransactions as $transaction )

                            <tr>
                                <td>{{ $transaction->quantity }}</td>
                                <td>{{ $transaction->type }}</td>
                                <td>{{ $transaction->notes }}</td>
                                <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>

                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        @endcan

    </div>

</div>
@endsection
