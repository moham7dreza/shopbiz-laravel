<section class="col-12 col-md-{{ $col }}">
    <div class="form-group">
        <label for="{{ $name }}">{{ $label }}</label>
        <select name="{{ $name }}" id="{{ $name }}"
                class="form-control form-control-sm {{ $class }} @error($name) is-invalid @enderror" {{ $attributes }}>
            @if(isset($option))
                <option value="">{{ $option }}</option>
            @endif
            @if(isset($arr))
                @foreach ($arr as $key => $value)
                    <option value="{{ $key }}"
                            @if($method == 'create')
                                @if(old($name) == $key)
                                    selected
                            @endif
                            @elseif($method == 'edit')
                                @if(old($name, $model->$name) == $key)
                                    selected
                        @endif
                        @endif
                    >{{ $value }}</option>
                @endforeach
            @elseif(isset($collection))
                @foreach ($collection as $object)
                    <option value="{{ $object->id }}"
                            @if($method == 'create')
                                @if(old($name) == $object->id)
                                    selected
                            @endif
                            @elseif($method == 'edit')
                                @if(old($name, $model->$name) == $object->id)
                                    selected
                        @endif
                        @endif
                    >{{ $object->$property }}</option>
                @endforeach
            @endif

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
