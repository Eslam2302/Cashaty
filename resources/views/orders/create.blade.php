@extends('layouts.app')

@section('content')
<div class="">
    <div class="m-2 row">

        {{-- left section of products that selected --}}
        <div class="table-responsive col-4 order-total" style="max-height: 500px; overflow-y: auto;">
            <table class="table table-bordered table-light ">
                <select id="customer_id" class="form-control">
                    <option value="">@lang('orders.no-customer')</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
                <thead>
                    <tr>
                        <th class="col-4">@lang('orders.product')</th>
                        <th class="col-4">@lang('orders.quantity')</th>
                        <th class="col-4">@lang('orders.price')</th>
                    </tr>
                </thead>
                <tbody id="order-items">

                </tbody>
            </table>
            <p class="mt-3"><strong>@lang('orders.total_price'): <span id="total-price">0</span> @lang('orders.egp')</strong></p>
            <button id="save-order" class="mt-3 btn btn-success w-100">
                @lang('orders.confirm_order')
            </button>
        </div>

        {{-- Right section of products that selected --}}
        <div class="col-8">

            {{-- Searh Form of products --}}
            <div class="search-products">

                {{-- Search Form --}}
                <form method="GET" action="{{ route('products.index') }}" class="mb-4 row g-2">
                    <div class="col-md-9">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="@lang('products.search_product')">
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">@lang('products.search')</button>
                    </div>
                </form>
            </div>

            {{-- END search --}}

            {{-- Products List --}}
            <div class="products-list row">

                {{-- Here you can loop through the products and display them --}}
                    @foreach($products as $product)

                    @php
                        $imagePath = $product->image && file_exists(public_path('uploads/products/' . $product->image))
                            ? asset('uploads/products/' . $product->image)
                            : asset('images/no.jpeg');
                    @endphp

                        <div
                            class="m-1 text-center card product-item btn"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->discount_price }}"

                            @if ($product->available_stock <= 0)
                                style="pointer-events: none;opacity: 0.7;"
                            @endif
                        >

                            <img src="{{ $imagePath }}" class="mb-3 card-img-top img-thumbnail product-img img-fluid" alt="{{ $product->name }}" style="height: 150px; object-fit: cover;">

                            @if ($product->discount > 0)
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="mb-1 card-text small">{{ number_format($product->discount_price, 2) }} @lang('products.egp')</span>
                                    <del class="mb-1 card-text text-muted small">{{ number_format($product->price, 2) }}  @lang('products.egp')</del>
                                </div>
                            @else
                                <p class="mb-1 card-text">{{ number_format($product->price, 2) }} @lang('products.egp')</p>
                            @endif

                            <p class="mb-1">{{ $product->name }}</p>
                            @if ($product->available_stock <= 0)
                                <p class="mb-1 card-text text-danger small">@lang('products.out_of_stock')</p>
                            @elseif ($product->available_stock < 5)
                                <p class="mb-1 card-text text-warning small">@lang('products.available_stock'): <span>{{ $product->available_stock }}</span></p>
                            @else
                                <p class="mb-1 card-text text-success small">@lang('products.available_stock'): <span>{{ $product->available_stock }}</span></p>
                            @endif
                        </div>
                    @endforeach

            </div>


        </div>


    </div>
</div>
@endsection


