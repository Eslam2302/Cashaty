@extends('layouts.app')

@section('content')
<div class="container my-4">


    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h2 class="mb-4">
            @if (isset($selectedCategory))
                @lang('products.category_product') : {{ $selectedCategory->name }}
            @else
                @lang('products.products')
            @endif
        </h2>

        <a href="{{ route('products.create') }}" class="btn btn-primary">
            @lang('products.add_product')
        </a>
    </div>

    {{-- Searh Form of products or category select --}}

    <form method="GET" action="{{ route('products.index') }}" class="mb-4 row g-2">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="@lang('products.search_product')">
        </div>

        <div class="col-md-4">
            <select name="category_id" class="form-select">
                <option value="">@lang('products.all_categories')</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">@lang('products.search')</button>
        </div>
    </form>

    {{-- END search --}}

    <div class="row">
        @forelse ($products as $product)
            @php
                $imagePath = $product->image && file_exists(public_path('uploads/products/' . $product->image))
                    ? asset('uploads/products/' . $product->image)
                    : asset('images/no.jpeg');
            @endphp

            <div class="mb-4 col-6 col-md-4 col-lg-2">
                <div class="shadow-sm card h-100">
                    <img src="{{ $imagePath }}" class="card-img-top img-thumbnail product-img img-fluid" alt="{{ $product->name }}" style="height: 150px; object-fit: cover;">

                    <div class="p-2 card-body">
                        <h5 class="mb-1 card-title text-truncate">{{ $product->name }}</h5>
                        <p class="mb-2 card-text text-muted small">{{ number_format($product->price, 2) }} @lang('products.egp')</p>

                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary w-100">@lang('products.preview')</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center alert alert-info">@lang('products.no_product')</div>
            </div>
        @endforelse
    </div>
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection
