<section class="col-12 col-md-{{ $col }} border-top mt-4 d-flex justify-content-{{ $align }} {{ $dadClass }}">
    <button type="{{ $type }}"
            class="btn btn-{{ $color }} btn-sm mt-md-4 {{ $class }} d-flex align-items-center rounded-3 p-2" {{ $attributes }}>
        <i class="{{ $group }} fa-{{ $icon }} {{ $loc == 'home' ? 'me-5 ms-1 fs-5' : 'ml-5 mr-1' }} "></i>
        <span class="{{ $loc == 'home' ? 'me-1' : 'ml-1' }} fw-bold">{{ $title }}</span>
    </button>
</section>
