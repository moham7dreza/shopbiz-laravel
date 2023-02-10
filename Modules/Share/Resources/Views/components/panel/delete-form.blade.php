<form class="d-inline mx-1"
      action="{{ $route }}"
      method="post">
    @csrf
    @method('delete')
    <button class="btn btn-{{ $color }} btn-sm delete {{ $class }}" type="submit" title="{{ $title }}"
            data-bs-toggle="tooltip"
            data-bs-placement="top" {{ $attributes }}>
        @if(!is_null($icon))
            <i class="fa fa-{{ $icon }}"></i>
        @endif
        {{ $text }}
    </button>
</form>
