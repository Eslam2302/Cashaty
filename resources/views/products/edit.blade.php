@extends('layouts.app')

@section('content')
<div class="container">
    <h2>@lang('products.edit_product')</h2>

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name">@lang('products.name')</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="description">@lang('products.product_description')</label>
            <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price">@lang('products.price')</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
        </div>

        <div class="mb-3">
            <label for="discount">@lang('products.discount') (%)</label>
            <input type="number" step="0.01" name="discount" class="form-control" value="{{ old('discount', $product->discount) }}" required>
        </div>

        <div class="mb-3">
            <label for="category_id">@lang('products.category')</label>
            <select name="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

         <div class="mt-3 form-group">
            <label for="image" class="form-label">@lang('products.image_update') (@lang('products.optional'))</label>
            <input class="form-control" name="image" type="file" id="imageInput">
        </div>

        <input type="hidden" name="old_image" value="{{ $product->image }}">

        <button type="submit" class="btn btn-primary">@lang('products.update')</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">@lang('products.cancel')</a>
    </form>
</div>
@endsection
