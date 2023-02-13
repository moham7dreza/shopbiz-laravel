<div class="dropdown d-inline-block">
    <a href="#" class="btn btn-{{ $color }} btn-sm dorpdown-toggle {{ $class }}"
       role="button" id="dropdownMenuLink" data-toggle="dropdown"
       aria-expanded="false">
        <i class="{{ $group }} fa-{{ $icon }}"></i><span class="mx-1">{{ $text }}</span>
    </a>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        {{ $slot }}
    </div>
</div>
