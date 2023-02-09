@if ($errors->any())
    <section>
        <ul class="list-style-none">
            @foreach ($errors->all() as $error)
                <li class="alert alert-danger font-weight-bold text-center my-2">{{ $error }}</li>
            @endforeach
        </ul>
    </section>
@endif
