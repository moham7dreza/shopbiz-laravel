<section class="sort-arrows {{ $class }}" {{ $attributes }}>
    <a href="{{ route($route, [$params, 'sort='. $property, 'dir=asc']) }}" class="btn btn-sm btn-light p-0"
       title="مرتب سازی به صورت صعودی" data-bs-toggle="tooltip"
       data-bs-placement="top">
        <i class="fa fa-arrow-down"></i>
    </a>
    <a href="{{ route($route, [$params, 'sort='. $property, 'dir=desc']) }}" class="btn btn-sm btn-light p-0"
       title="مرتب سازی به صورت نزولی" data-bs-toggle="tooltip"
       data-bs-placement="top">
        <i class="fa fa-arrow-up"></i>
    </a>
    <span class="mx-1">{{ $title }}</span>
</section>
