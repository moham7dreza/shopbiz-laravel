<section class="d-flex align-items-center justify-content-center m-3">
    <section class="star-rate" title="{{ 'محبوبیت : ' . convertEnglishToPersian($product->rating) }}"
             data-bs-toggle="tooltip"
             data-bs-placement="top">
        @php
            $rate = $product->rating;
        @endphp
        @if($rate == 0)
            <i class="fa fa-star text-gray" id="rate_very_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_normal_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_low_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_very_low_{{ $product->id }}"></i>
        @elseif($rate <= 0.5 && $rate > 0)
            <i class="fa fa-star text-gray" id="rate_very_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_normal_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_low_{{ $product->id }}"></i>
            <i class="fa fa-star-half-alt text-greenyellow" id="rate_very_low_{{ $product->id }}"></i>
        @elseif($rate <= 1 && $rate > 0.5)
            <i class="fa fa-star text-gray" id="rate_very_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_normal_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_low_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_very_low_{{ $product->id }}"></i>
        @elseif($rate <= 1.5 && $rate > 1)
            <i class="fa fa-star text-gray" id="rate_very_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_normal_{{ $product->id }}"></i>
            <i class="fa fa-star-half-alt text-greenyellow" id="rate_low_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_very_low_{{ $product->id }}"></i>
        @elseif($rate <= 2 && $rate > 1.5)
            <i class="fa fa-star text-gray" id="rate_very_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_normal_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_low_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_very_low_{{ $product->id }}"></i>
        @elseif($rate <= 2.5 && $rate > 2)
            <i class="fa fa-star text-gray" id="rate_very_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_good_{{ $product->id }}"></i>
            <i class="fa fa-star-half-alt text-greenyellow" id="rate_normal_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_low_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_very_low_{{ $product->id }}"></i>
        @elseif($rate <= 3 && $rate > 2.5)
            <i class="fa fa-star text-gray" id="rate_very_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-gray" id="rate_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_normal_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_low_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_very_low_{{ $product->id }}"></i>
        @elseif($rate <= 3.5 && $rate > 3)
            <i class="fa fa-star text-gray" id="rate_very_good_{{ $product->id }}"></i>
            <i class="fa fa-star-half-alt text-greenyellow" id="rate_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_normal_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_low_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_very_low_{{ $product->id }}"></i>
        @elseif($rate <= 4 && $rate > 3.5)
            <i class="fa fa-star text-gray" id="rate_very_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_normal_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_low_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_very_low_{{ $product->id }}"></i>
        @elseif($rate <= 4.5 && $rate > 4)
            <i class="fa fa-star-half-alt text-greenyellow" id="rate_very_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_normal_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_low_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_very_low_{{ $product->id }}"></i>
        @elseif($rate <= 5 && $rate > 4.5)
            <i class="fa fa-star text-greenyellow" id="rate_very_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_good_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_normal_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_low_{{ $product->id }}"></i>
            <i class="fa fa-star text-greenyellow" id="rate_very_low_{{ $product->id }}"></i>
        @endif
    </section>
</section>
