@extends('layouts.app')
@section('content')


<div class="container">

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h2 class="mb-4">
            @lang('users.users')
        </h2>

        @can(abilities: 'add user')
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                @lang('users.create_user')
            </a>
        @endcan

    </div>

    <div class="mb-4 table-responsive">
        <table class="table text-center table-bordered">
            <thead>
                <tr>
                    <th>@lang('users.name')</th>
                    <th>@lang('users.email')</th>
                    <th>@lang('users.role')</th>
                    <th>@lang('users.actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->first()->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">@lang('users.edit')</a>

                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('@lang('users.confirm_delete')')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">@lang('users.delete')</button>
                            </form>

                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>

</div>


@endsection
