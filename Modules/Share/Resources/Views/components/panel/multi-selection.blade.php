<section class="col-12 col-md-{{ $col }}">
    <div class="form-group">
        <label for="{{ $name }}">{{ $label }}</label>
        <select multiple class="form-control form-control-sm {{ $class }} @error($name) is-invalid @enderror" id="{{ $name }}"
                name="{{ $name }}[]" {{ $attributes }}>

            @foreach ($items as $item)
                <option value="{{ $item->id }}"
                        @foreach ($related->$name as $related_item)
                            @if($related_item->id === $item->id)
                                selected
                    @endif
                    @endforeach>
                    {{ $item->name }}
                </option>
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
