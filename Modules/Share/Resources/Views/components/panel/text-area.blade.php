<section class="col-12 col-md-{{ $col }}">
    <div class="form-group">
        <label for="{{ $name }}">{{ $label }}</label>
        <textarea name="{{ $name }}" id="{{ $name }}"
                  class="form-control form-control-sm @error($name) is-invalid @enderror {{ $class }}"
                  rows="{{ $rows }}" {{ $attributes }}>
            @if($method == 'create')
                {{ old($name) }}
            @else
                {{ old($name, $old ?? $model->$name) }}
            @endif
        </textarea>
    </div>
    @error($name)
    <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
    </span>
    @enderror
</section>
