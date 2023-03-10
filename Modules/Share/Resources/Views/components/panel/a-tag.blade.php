<a href="{{ $route }}"
   class="btn btn-{{ $color }} btn-sm mx-1 {{ $class }}" title="{{ $title }}"
   @if($panel) data-toggle="tooltip" @else data-bs-toggle="tooltip" @endif
   @if($panel) data-placement="top" @else data-bs-placement="top" @endif {{ $attributes }}>
    @if(!is_null($icon))
        <i class="{{ $group }} fa-{{ $icon }}"></i>
    @endif
    {{ $text }}
</a>
