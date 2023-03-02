@component('mail::message', ['class' => 'dir-rtl'])
<section>
    <h1 style="text-align: center;">{{ $model->subject }}</h1>
    <p style="text-align: justify;direction: rtl;color: black;">{{ strip_tags($model->body) }}</p>
</section>
<section style="display: flex;align-items: center;justify-content: space-between;">
    <h4 style="direction: rtl">با تشکر، مجموعه شاپ بیز</h4>
    <a style="text-decoration: none;font-weight: bolder;color: red;border: 1px solid wheat;padding: 1rem;border-radius: 1rem;" href="{{ route('customer.home') }}">فروشگاه</a>
</section>

@endcomponent
