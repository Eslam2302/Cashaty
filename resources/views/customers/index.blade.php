@extends('layouts.app')
@section('content')
<div class="container my-4">

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h2 class="mb-4">@lang('customers.customers')</h2>

        @can('add customer')
            <a href="{{ route('customers.create') }}" class="btn btn-primary">@lang('customers.add_customer')</a>
        @endcan
    </div>

    {{-- Searh Form of products or category select --}}

    <form method="GET" action="{{ route('customers.index') }}" class="mb-4 row g-2">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="@lang('customers.search_customer')">
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">@lang('customers.search')</button>
        </div>
    </form>

    {{-- END search --}}

    <table class="table text-center table-bordered">
        <thead>
            <tr>
                <th>@lang('customers.name')</th>
                <th>@lang('customers.phone')</th>
                <th>@lang('customers.email')</th>
                <th>@lang('customers.address')</th>
                <th>@lang('customers.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>
                        @can('edit customer')
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">@lang('customers.edit')</a>
                        @endcan
                        @can('delete customer')
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('@lang('customers.confirm_delete')')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">@lang('customers.delete')</button>
                            </form>
                        @endcan


                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $customers->links() }}

</div>
@endsection

