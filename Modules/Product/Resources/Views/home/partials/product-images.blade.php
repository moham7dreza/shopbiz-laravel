<section class="col-md-4">
    <section class="content-wrapper bg-white p-3 rounded-2 mb-4">
        <section class="product-gallery">
            @php
                $imageGalley = $product->images()->get();
                $images = collect();
                $images->push($product->image);
                foreach ($imageGalley as $image) {
                    $images->push($image->image);
                }
            @endphp
            <section class="product-gallery-selected-image mb-3">
                <img src="{{ asset($images->first()['indexArray']['medium']) }}" alt="">
            </section>
            <section class="product-gallery-thumbs">
                @foreach ($images as $key => $image)
                    <img class="product-gallery-thumb"
                         src="{{ asset($image['indexArray']['medium']) }}"
                         alt="{{ asset($image['indexArray']['medium']) . '-' . ($key + 1) }}"
                         data-input="{{ asset($image['indexArray']['medium']) }}">
                @endforeach
            </section>
        </section>
    </section>
</section>
