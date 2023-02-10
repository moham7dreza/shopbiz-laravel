<a href="{{ $route }}"
   class="btn btn-{{ $color }} btn-sm mx-1 {{ $class }}" title="{{ $title }}"
   data-bs-toggle="tooltip"
   data-bs-placement="top" {{ $attributes }}>
    @if(!is_null($icon))
        <i class="fa fa-{{ $icon }}"></i>
    @endif
    {{ $text }}
</a>
