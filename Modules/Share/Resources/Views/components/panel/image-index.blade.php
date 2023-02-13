<section class="row col-12">
    @php
        $number = 1;
    @endphp
    <span class="mr-3">سایز تصویر</span>
    @foreach ($model->$property['indexArray'] as $key => $value )
        <section class="col-md-{{ 6 / $number }} m-2 p-4">
            <div class="form-check">
                <input type="radio" class="form-check-input" name="currentImage"
                       value="{{ $key }}" id="{{ $number }}"
                       @if($model->$property['currentImage'] == $key) checked @endif>
                <label for="{{ $number }}" class="form-check-label mx-2">
                    <img src="{{ asset($value) }}" class="w-100 m-2 p-2" alt="" data-bs-toggle="tooltip"
                         data-bs-placement="top" title="{{ $key }}">
                </label>
            </div>
        </section>
        @php
            $number++;
        @endphp
    @endforeach

</section>
