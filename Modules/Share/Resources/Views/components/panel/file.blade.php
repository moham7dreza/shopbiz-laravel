<section class="col-12 col-md-{{ $col }}">
    <div class="form-group">
        <label for="{{ $name }}">{{ $label }}</label>
        <input type="file" class="form-control form-control-sm @error($name) is-invalid @enderror" name="{{$name}}" id="{{$name}}">
    </div>
    @error($name)
    <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
    @enderror
</section>
