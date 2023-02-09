@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li class="alert alert-danger list-style-none">{{ $error }}</li>
        @endforeach
    </ul>
@endif
