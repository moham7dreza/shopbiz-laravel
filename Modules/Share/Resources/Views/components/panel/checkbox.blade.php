<label
    @if(isset($uniqueId))
        for="{{ $uniqueId }}-{{ $model->id }}"
    @else
        for="{{ $model->id }}"
    @endif
>
    <input
        @if(isset($uniqueId))
            id="{{ $uniqueId }}-{{ $model->id }}"
        @else
            id="{{ $model->id }}"
        @endif
        onchange="{{ $method }}('@if(isset($uniqueId)){{ $uniqueId }}-{{ $model->id }}@else{{ $model->id }}@endif', '{{ $name }}')"
        data-url="{{ route($route, $model->id) }}"
        type="checkbox" class="{{ $class }}" {{ $attributes }}
        @if ($model->$property === 1)
            checked
        @endif>
</label>
