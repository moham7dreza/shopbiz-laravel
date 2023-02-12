<section class="col-lg-{{ $lgCol }} col-md-{{ $mdCol }} col-12">
    <a href="{{ $route }}" class="text-decoration-none d-block mb-4">
        <section class="card card-shadow text-white {{ $class }}" {{ $attributes }}>
            <section class="card-body">
                <section class="d-flex justify-content-between">
                    <section class="info-box-body">
                        <h5>{{ $counter }}</h5>
                        <p>{{ $title }}</p>
                    </section>
                    <section class="info-box-icon">
                        <i class="{{ $group }} fa-{{ $icon }}"></i>
                    </section>
                </section>
            </section>
            <section class="card-footer info-box-footer">
                <i class="fas fa-clock mx-2"></i> به روز رسانی شده در : {{ jalaliDate($updatedAt) }}
            </section>
        </section>
    </a>
</section>
