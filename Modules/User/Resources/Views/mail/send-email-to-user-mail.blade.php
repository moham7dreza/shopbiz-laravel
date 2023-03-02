@component('mail::message')
# {{ config('app.name') }}

You have an email from shopbiz.

@component('mail::button', ['url' => route('customer.home')])
Home page
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
