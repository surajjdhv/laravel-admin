@extends('layouts.app', ['title' => 'Activity Logs'])

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <strong>Activity Logs</strong>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>When</th>
                        <th>Event</th>
                        <th>Description</th>
                        <th>Subject</th>
                        <th>Causer</th>
                        <th>Properties</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activities as $activity)
                        @php
                            $subjectLabel = $activity->subject
                                ? ($activity->subject->name ?? class_basename($activity->subject_type).' #'.$activity->subject_id)
                                : '-';
                        @endphp
                        <tr>
                            <td>{{ $activity->created_at->toDateTimeString() }}</td>
                            <td>{{ $activity->event ?? '-' }}</td>
                            <td>{{ $activity->description }}</td>
                            <td>{{ $subjectLabel }}</td>
                            <td>{{ $activity->causer?->name ?? '-' }}</td>
                            <td>
                                <code>{{ json_encode($activity->properties->toArray()) }}</code>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No activity logged yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
