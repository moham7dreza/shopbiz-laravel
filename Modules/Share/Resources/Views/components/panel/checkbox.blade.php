<label for="{{ $model->id }}">
    <input id="{{ $model->id }}" onchange="{{ $method }}({{ $model->id }}, '{{ $name }}')"
           data-url="{{ route($route, $model->id) }}"
           type="checkbox" class="{{ $class }}" {{ $attributes }}
           @if ($model->$property === 1)
               checked
        @endif>
</label>
