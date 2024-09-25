@extends('layouts.app', ['title' => 'Profile'])

@section('content')
<form id="changePasswordForm" action="{{ route('profile.password') }}" method="POST">
    @csrf
    <div class="card mb-4">
        <div class="card-header">
            <strong>Change Password</strong>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-bottom: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row mb-2">
                <div class="col-sm">
                    <label class="mb-2">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" />
                </div>
                <div class="col-sm">
                    <label class="mb-2">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" />
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button class="btn btn-primary">Save</button>
        </div>
    </div>
</form>
@endsection
