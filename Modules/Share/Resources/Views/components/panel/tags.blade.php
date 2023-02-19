@if(empty($model->$related()->get()->toArray()))
    <span class="text-danger">برای این {{ $name }} هیچ {{ $title }}ی تعریف نشده است</span>
@else
    @foreach($model->$related as $object)
        <span class="d-inline-block mx-1 alert alert-secondary p-2 rounded-05rem">
            <a href="{{ isset($route) ? route($route, $object->id) : $href }}" class="text-decoration-none" title="{{ $toolTip }}" data-bs-toggle="tooltip"
               data-bs-placement="top">{{ $object->$property }}</a>
        </span>
    @endforeach
@endif
