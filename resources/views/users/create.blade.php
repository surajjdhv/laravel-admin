@extends('layouts.app', ['title' => 'Create user'])

@section('content')
<div class="card mb-4">
	<div class="card-header">
        <strong>Create user</strong>
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

        <form name="createUserForm" id="createUserForm" action="{{ route('users.store') }}" method="POST">
            @csrf
            <table class="table table-borderless">
                <tr>
                    <th>Name</th>
                    <td><input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required></td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td>
                        <select class="form-control" name="type" required>
                            @foreach ($userTypes as $type)
                                <option value="{{ $type }}" @if(old('type', 'sales') == $type) selected @endif>{{ ucwords($type) }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Active</th>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_active" id="isActiveYes" value="1" @if(old('is_active', 1) == '1') checked @endif>
                            <label class="form-check-label" for="isActiveYes">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_active" id="isActiveNo" value="0" @if(old('is_active') == '0') checked @endif>
                            <label class="form-check-label" for="isActiveNo">
                                No
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="send-password" id="sendPasswordCheck" @if(old('send-password') == 1) checked @endif>
                            <label class="form-check-label" for="sendPasswordCheck">
                                Generate & send password on email
                            </label>
                        </div>
                        <div class="form-group @if(old('send-password') == 1) d-none @endif" id="passwordFormGroup">
                            <input type="password" class="form-control mt-2" id="passwordInput" name="password" value="{{ old('password') }}" placeholder="Password"  @if(old('send-password') == 1) disabled @endif>
                            <small id="passwordHelp" class="form-text text-muted">If you set the password, user will not receive the email.</small>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
	</div>
    <div class="card-footer d-flex justify-content-end">
        <button class="btn btn-primary" onclick="$('#createUserForm').submit();">Save</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#sendPasswordCheck').on('change', function () {
        if ($(this).is(':checked')) {
            $('#passwordInput').prop('disabled', true);
            $('#passwordInput').prop('required', false);
            $('#passwordFormGroup').addClass('d-none');
        } else {
            $('#passwordInput').prop('disabled', false);
            $('#passwordInput').prop('required', true);
            $('#passwordFormGroup').removeClass('d-none');
        }
    });
})
</script>
@endpush