@extends('layouts.app')

@section('content')
<div class="container">
    <h2>@lang('customers.edit_customer')</h2>

    <form action="{{ route('customers.update' , $customer->id)  }}" method="POST" enctype="multipart/form-data">

        @method('PUT')
        @csrf

        <div class="form-group">
            <label for="name">@lang('customers.customer_name')</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name' , $customer->name)  }}">
        </div>

        <div class="form-group">
            <label for="phone">@lang('customers.customer_phone')</label>
            <input type="number" name="phone" class="form-control" required value="{{ old('phone', $customer->phone) }}">
        </div>

        <div class="form-group">
            <label for="email">@lang('customers.customer_email')</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}">
        </div>

        <div class="form-group">
            <label for="address">@lang('customers.customer_address')</label>
            <textarea name="address" class="form-control">{{ old('address', $customer->address) }}</textarea>
        </div>

        <button type="submit" class="mt-2 btn btn-primary">@lang('customers.update_customer')</button>
    </form>
</div>



@endsection
