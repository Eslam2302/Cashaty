@extends('layouts.app')
@section('content')
<div class="container">
    <h2>@lang('categories.edit') ({{ $category->name }})</h2>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3 form-group">
            <label for="name">@lang('categories.name')</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control" required>
        </div>

        <div class="mb-3 form-group">
            <label for="description">@lang('categories.description')</label>
            <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">@lang('categories.update')</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">@lang('categories.back')</a>
    </form>
</div>

@endsection
