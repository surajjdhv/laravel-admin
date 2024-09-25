@extends('layouts.app', ['title' => 'Home'])

@section('content')
<div class="tab-pane" role="tabpanel">
    <div class="card-group">
        @if ($loggedInUser->isAdmin())
            <div class="card">
                <div class="card-body">
                    <div class="text-medium-emphasis text-end mb-4">
                        <i class="icon icon-xxl cil-group"></i>
                    </div>
                    <div class="fs-4 fw-semibold">{{ $users_count }}</div>
                    <small class="text-medium-emphasis text-uppercase fw-semibold">Users</small>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection