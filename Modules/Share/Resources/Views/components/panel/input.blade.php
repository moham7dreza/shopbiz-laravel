<section class="col-12 col-md-{{ $col }}">
    <div class="form-group">
        <label for="{{ $name }}">{{ $label }}</label>
        <input type="{{ $type }}" class="form-control form-control-sm {{ $class }} @error($name) is-invalid @enderror"
               name="{{ $name }}"
               id="{{ $name }}"
               @if($type != 'file')
                   @if($method == 'create')
                       value="{{ old($name) }}"
               @else
                   value="{{ old($name, $old ?? $model->$name) }}"
            @endif
            @endif
            {{ $attributes }}
        >
        @if($date)
            <label for="{{ $name }}_view"></label>
            <input type="text" id="{{ $name }}_view" class="form-control form-control-sm">
        @elseif($showImage)
            <img src="{{ asset($model->$name) }}" alt="" width="100" height="50" class="mt-3">
        @elseif($select2)
            <select class="select2 form-control form-control-sm" id="select_tags" multiple></select>
        @endif
    </div>
    @error($name)
    <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
    @enderror
</section>
