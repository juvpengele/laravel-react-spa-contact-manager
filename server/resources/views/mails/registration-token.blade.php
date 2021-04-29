@component('mail::message')
# Registration,

Mr / Ms {{ $user->name }}, you receive this email because you registered to our platform.

To complete your registration, please enter this registration code:

<p style="text-align: center; font-weight: bold; color: black">
    {{ $user->remember_token }}
</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
