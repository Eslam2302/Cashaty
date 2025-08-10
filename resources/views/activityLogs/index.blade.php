@extends('layouts.app')
@section('content')

<div class="container">
    <div class="table-responsive">
        <table class="table text-center table-bordered table-striped">
            <thead>
                <tr>
                    <th>@lang('activityLogs.log_name')</th>
                    <th>@lang('activityLogs.log_description')</th>
                    <th>@lang('activityLogs.user_name')</th>
                    <th>@lang('activityLogs.log_subject')</th>
                    <th>@lang('activityLogs.log_time')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                    <tr>
                        <td>{{ $activity->log_name }}</td>
                        <td>{{ $activity->description }}</td>
                        <td>{{ optional($activity->causer)->name ?? 'System' }}</td>
                        <td>
                            @if($activity->subject)
                                {{ class_basename($activity->subject_type) }} -
                                @if(isset($activity->subject->name))
                                    {{ $activity->subject->name }}
                                @elseif(isset($activity->subject->id))
                                    #{{ $activity->subject->id }}
                                @endif
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $activity->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $activities->links() }}
        </div>
    </div>
</div>

@endsection
