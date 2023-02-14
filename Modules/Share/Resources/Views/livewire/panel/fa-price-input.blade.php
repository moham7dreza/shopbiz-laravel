<section class="col-12 col-md-{{ $col }}">
    <div class="form-group">
        <label for="{{ $name }}">{{ $label }}</label>
        <input type="{{ $type }}" wire:model="{{ $name }}"
               class="form-control form-control-sm {{ $class }} @error($name) is-invalid @enderror"
               name="{{ $name }}"
               id="{{ $name }}"
               @if($type != 'file')
                   @if($method == 'create')
                       value="{{ old($name) }}"
               @elseif($method == 'edit')
                   value="{{ old($name, $obj->$name) }}"
            @endif
            @endif
        >
    </div>
    @if(isset($price) || isset($discount_ceiling) || isset($minimal_order_amount) || isset($amount) || isset($price_increase))
        @php $num = $price ?? $discount_ceiling ?? $minimal_order_amount ?? $amount ?? $price_increase; @endphp
        <span class="alert alert-light d-block font-weight-bold font-size-18" role="alert">
                                <strong>
                                    {{ priceFormat((int)$num) . ' تومان ' }}
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
