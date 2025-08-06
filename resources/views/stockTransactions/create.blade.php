@extends('layouts.app')
@section('content')

<div class="container">
    <h3>@lang('stockTransactions.create_transactions')</h3>

    <form action="{{ route('stockTransactions.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="product_id">@lang('stockTransactions.product')</label>
            <select name="product_id" id="product_id" class="form-control" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>


        <div class="form-group">
            <label for="quantity">@lang('stockTransactions.quantity')</label>
            <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}"
            required placeholder="@lang('stockTransactions.quantity_placeholder')">
        </div>


        <div class="form-group">
            <label for="type">@lang('stockTransactions.type')</label>
            <select name="type" id="type" class="form-control" required>
                <option value="in">@lang('stockTransactions.incoming')</option>
                <option value="out">@lang('stockTransactions.outgoing')</option>
            </select>
        </div>


        <div class="form-group">
            <label for="notes">@lang('stockTransactions.notes')</label>
            <textarea name="notes" class="form-control" placeholder="@lang('stockTransactions.notes_placeholder')">{{ old('notes') }}</textarea>
        </div>

        <button type="submit" class="mt-2 btn btn-primary">@lang('stockTransactions.create_transactions')</button>



    </form>







@endsection
