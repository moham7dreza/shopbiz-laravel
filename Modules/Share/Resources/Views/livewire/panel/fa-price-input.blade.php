<section class="col-12 col-md-{{ $col }}">
    <div class="form-group">
        <label for="{{ $name }}">{{ $label }}</label>
        <input type="{{ $type }}" wire:model="price" class="form-control form-control-sm {{ $class }} @error($name) is-invalid @enderror"
               name="{{ $name }}"
               id="{{ $name }}"
               @if($type != 'file')
                   @if($method == 'create')
                       value="{{ old($name) }}"
               @else
                   value="{{ old($name, $old ?? $obj->$name) }}"
            @endif
            @endif
        >
    </div>
    @if(isset($price))
        <span class="alert alert-light -p-1 mb-3 d-block font-weight-bold font-size-18" role="alert">
                                <strong>
                                    {{ priceFormat((int)$price) . ' تومان ' }}
                                </strong>
                            </span>
    @endif

    @error($name)
    <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
    @enderror
</section>
