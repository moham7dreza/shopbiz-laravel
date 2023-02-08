<section class="col-12 col-md-{{ $col }}">
    <div class="form-group">
        <label for="{{ $name }}">{{ $label }}</label>
        <select name="{{ $name }}" class="form-control form-control-sm @error($name) is-invalid @enderror"
                id="{{ $name }}">
            <option value="0"
                    @if($method == 'create')
                        @if(old($name) == 0)
                            selected
                    @endif
                    @else
                        @if(old($name, $model->$name) == $model->statusActive())
                            selected
                @endif
                @endif
            >غیرفعال
            </option>
            <option value="1"
                    @if($method == 'create')
                        @if(old($name) == 1)
                            selected
                    @endif
                    @else
                        @if(old($name, $model->$name) == $model->statusInActive())
                            selected
                @endif
                @endif
            >فعال</option>
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
