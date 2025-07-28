@extends('layouts.app')

@section('content')
<div class="container">
    <h2>@lang('categories.categories')</h2>

    <a href="{{ route('categories.create') }}" class="mb-3 btn btn-primary">@lang('categories.add-new')</a>

    <table class="table text-center table-bordered">
        <thead>
            <tr>
                <th>@lang('categories.name')</th>
                <th>@lang('categories.description')</th>
                <th>@lang('categories.created')</th>
                <th>@lang('categories.action')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>
                    <a href="{{ route('categories.products', $category->id) }}">
    {{ $category->name }}
</a>
                </td>
                <td>{{ $category->description }}</td>
                <td>{{ $category->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">@lang('categories.edit_btn')</a>

                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('{{ __('categories.confirm_delete') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">@lang('categories.delete_btn')</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
