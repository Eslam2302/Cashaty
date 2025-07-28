@extends('layouts.app')

@section('content')
<div class="container my-4">

    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">{{ $product->name }}</h2>


    </div>

    <div class="row">
        <div class="col-md-4">
            @php
                $imagePath = $product->image ? asset('uploads/products/' . $product->image) : asset('images/no.jpeg');
            @endphp
            <img src="{{ $imagePath }}" class="border rounded img-fluid" alt="{{ $product->name }}">
        </div>

        <div class="col-md-8">
            <h5 class="text-muted">@lang('products.price') :</h5>
            <p>{{ number_format($product->price, 2) }} @lang('products.egp')</p>

            <h5 class="text-muted">@lang('products.description') :</h5>
            <p>{{ $product->description ?? __('products.no_descripton') }}</p>

            <h5 class="text-muted">@lang('products.category') :</h5>
            <p>{{ $product->category->name ?? __('products.no_select') }}</p>
        </div>
    </div>
    <div class="product-btns">
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-md btn-warning">@lang('products.edit')</a>
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('@lang('products.confirm_delete')')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-md btn-danger">@lang('products.delete')</button>
        </form>
    </div>
</div>
@endsection
