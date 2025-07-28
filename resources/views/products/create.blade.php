@extends('layouts.app')

@section('content')
<div class="container">
    <h2>@lang('products.add_product')</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">@lang('products.product_name')</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="description">@lang('products.product_description')</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">@lang('products.product_price')</label>
            <input type="number" step="0.01" name="price" class="form-control" required value="{{ old('price') }}">
        </div>

        <div class="form-group">
            <label for="category_id">@lang('products.category')</label>
            <select name="category_id" class="form-control" required>
                <option value="">@lang('products.choose_category')</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="image" class="form-label">@lang('products.image')</label>
            <input class="form-control" name="image" type="file" id="imageInput">
        </div>

        <button type="submit" class="mt-2 btn btn-primary">@lang('products.add_product')</button>
    </form>
</div>
@endsection
