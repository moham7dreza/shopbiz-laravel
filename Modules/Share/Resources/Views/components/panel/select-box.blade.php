<section class="col-12 col-md-{{ $col }}">
    <div class="form-group">
        <label for="{{ $name }}">{{ $label }}</label>
        <select name="{{ $name }}" id="{{ $name }}" class="form-control form-control-sm {{ $class }} @error($name) is-invalid @enderror" {{ $attributes }}>
            @foreach ($arr as $key => $value)
                <option value="{{ $key }}"
                        @if($method == 'create')
                            @if(old($name) == $key)
                                selected
                        @endif
                        @else
                            @if(old($name, $model->$name) == $key)
                                selected
                    @endif
                    @endif
                >{{ $value }}</option>
            @endforeach
        </select>
    </div>
    @error($name)
    <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
    @enderror
</section>
