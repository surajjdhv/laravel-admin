@extends('layouts.app', ['title' => 'Activity Logs'])

@section('content')
@php
    $rangeValue = request('range') ?: (request('from') && request('to') ? request('from').' - '.request('to') : '');
@endphp
<div class="card mb-4">
    <div class="card-header">
        <strong>Activity Logs</strong>
    </div>
    <div class="card-body">
        <form class="row g-2 mb-3 align-items-end" method="GET" action="{{ route('activity-logs.index') }}" id="activityFilters">
            <div class="col-12 col-sm-6 col-md-3">
                <label class="form-label">Date Range</label>
                <input id="activityRange" type="text" class="form-control w-100" name="range" value="{{ $rangeValue }}" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                <input type="hidden" name="from" value="{{ request('from') }}">
                <input type="hidden" name="to" value="{{ request('to') }}">
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <label class="form-label">Event</label>
                <select class="form-control w-100" name="event">
                    <option value="">All</option>
                    @foreach ($events as $event)
                        <option value="{{ $event }}" @if(request('event') === $event) selected @endif>{{ $event }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <label class="form-label">Causer ID</label>
                <input type="number" class="form-control w-100" name="causer_id" value="{{ request('causer_id') }}" min="1">
            </div>
            <div class="col-12 col-sm-6 col-md-3 d-grid d-md-flex gap-2">
                <button class="btn btn-primary w-100" type="button" id="activityFilterApply">Filter</button>
                <button class="btn btn-outline-secondary w-100" type="button" id="activityFilterReset">Reset</button>
            </div>
        </form>
        <div class="table-responsive">
            <table id="activity-logs" class="table table-striped table-borderless align-middle">
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
                    <tr>
                        <td colspan="6" class="text-center text-muted">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rangeInput = document.getElementById('activityRange');
    const fromInput = document.querySelector('input[name="from"]');
    const toInput = document.querySelector('input[name="to"]');
    const filtersForm = document.getElementById('activityFilters');
    const applyButton = document.getElementById('activityFilterApply');
    const resetButton = document.getElementById('activityFilterReset');

    if (!rangeInput) {
        return;
    }

    $(rangeInput).daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel: 'Clear',
        },
    });

    $(rangeInput).on('apply.daterangepicker', function (ev, picker) {
        const formatted = picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD');
        rangeInput.value = formatted;
        fromInput.value = picker.startDate.format('YYYY-MM-DD');
        toInput.value = picker.endDate.format('YYYY-MM-DD');
    });

    $(rangeInput).on('cancel.daterangepicker', function () {
        rangeInput.value = '';
        fromInput.value = '';
        toInput.value = '';
    });

    const table = $('#activity-logs').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('activity-logs.table') }}",
            data: function (d) {
                d.range = rangeInput.value;
                d.from = fromInput.value;
                d.to = toInput.value;
                d.event = filtersForm.querySelector('[name="event"]').value;
                d.causer_id = filtersForm.querySelector('[name="causer_id"]').value;
            },
        },
        order: [[0, 'desc']],
        columns: [
            { data: 'when', name: 'created_at' },
            { data: 'event', name: 'event' },
            { data: 'description', name: 'description' },
            { data: 'subject_label', name: 'subject_type', orderable: false, searchable: false },
            { data: 'causer_label', name: 'causer_id', orderable: false, searchable: false },
            { data: 'properties_json', name: 'properties', orderable: false, searchable: false },
        ],
    });

    applyButton.addEventListener('click', function () {
        table.ajax.reload();
    });

    resetButton.addEventListener('click', function () {
        filtersForm.reset();
        rangeInput.value = '';
        fromInput.value = '';
        toInput.value = '';
        table.ajax.reload();
    });
});
</script>
@endpush
