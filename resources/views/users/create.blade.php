@extends('layouts.app')
@section('content')

<div class="container">

    <h3>@lang('users.create_new_user')</h3>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">@lang('users.name')</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="email">@lang('users.email')</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="password">@lang('users.password')</label>
            <input type="password" name="password" class="form-control" required value="{{ old('password') }}">
        </div>

        <div class="form-group">
            <label for="password_confirmation">@lang('users.confirm_password')</label>
            <input type="password" name="password_confirmation" class="form-control" required value="{{ old('password_confirmation') }}">
        </div>

        <div class="form-group">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-control" required>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">@lang('users.create_user')</button>







    </form>


</div>



@endsection
