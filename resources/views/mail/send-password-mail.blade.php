<x-mail::message>
Dear {{ $name }},

We have generated a temporary password for your account. You can use this password to log in, but please note that you will be required to change it during your first login.

<strong>Temporary Password:</strong> {{ $password }}

For security reasons, you will be redirected to change the password on your first login.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
