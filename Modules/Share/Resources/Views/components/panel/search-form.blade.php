<form action="{{ $route }}" class="d-flex align-items-center">
    <input type="text" name="{{ $name }}" id="{{ $name }}" class="form-control form-control-sm form-text {{ $class }} @error($name) is-invalid @enderror"
           placeholder="{{ $placeholder }}" {{ $attributes }}>
    <button type="submit" class="btn btn-light btn-sm"><i class="fa fa-check"></i></button>
</form>
