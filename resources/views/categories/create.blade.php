@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>@lang('categories.add-new')</h4>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>@lang('categories.name')</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>@lang('categories.description')</label></label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button class="mt-2 btn btn-primary">@lang('categories.add')</button>
    </form>
</div>
@endsection
