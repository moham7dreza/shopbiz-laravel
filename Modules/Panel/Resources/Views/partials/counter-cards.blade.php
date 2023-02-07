<!-- Counters cards --->
<section class="row">
    <section class="col-lg-2 col-md-6 col-12">
        <a href="{{ route('customerUser.index') }}" class="text-decoration-none d-block mb-4">
            <section class="card bg-custom-yellow text-white">
                <section class="card-body">
                    <section class="d-flex justify-content-between">
                        <section class="info-box-body">
                            <h5>{{ $panelRepo->customersCount() }}</h5>
                            <p>تعداد مشتریان سیستم</p>
                        </section>
                        <section class="info-box-icon">
                            <i class="fas fa-users"></i>
                        </section>
                    </section>
                </section>
                <section class="card-footer info-box-footer">
                    <i class="fas fa-clock mx-2"></i> به روز رسانی شده در : {{ jalaliDate(now()) }}
                </section>
            </section>
        </a>
    </section>
    <section class="col-lg-2 col-md-6 col-12">
        <a href="{{ route('post.index') }}" class="text-decoration-none d-block mb-4">
            <section class="card bg-custom-green text-white">
                <section class="card-body">
                    <section class="d-flex justify-content-between">
                        <section class="info-box-body">
                            <h5>{{ $panelRepo->postsCount() }}</h5>
                            <p>تعداد پست ها</p>
                        </section>
                        <section class="info-box-icon">
                            <i class="fas fa-blog"></i>
                        </section>
                    </section>
                </section>
                <section class="card-footer info-box-footer">
                    <i class="fas fa-clock mx-2"></i> به روز رسانی شده در : {{ jalaliDate(now()) }}
                </section>
            </section>
        </a>
    </section>
    <section class="col-lg-2 col-md-6 col-12">
        <a href="{{ route('productComment.index') }}" class="text-decoration-none d-block mb-4">
            <section class="card bg-custom-pink text-white">
                <section class="card-body">
                    <section class="d-flex justify-content-between">
                        <section class="info-box-body">
                            <h5>{{ $panelRepo->commentsCount() }}</h5>
                            <p>تعداد نظرات</p>
                        </section>
                        <section class="info-box-icon">
                            <i class="fas fa-comment-alt"></i>
                        </section>
                    </section>
                </section>
                <section class="card-footer info-box-footer">
                    <i class="fas fa-clock mx-2"></i> به روز رسانی شده در : {{ jalaliDate(now()) }}
                </section>
            </section>
        </a>
    </section>
    <section class="col-lg-2 col-md-6 col-12">
        <a href="{{ route('order.index') }}" class="text-decoration-none d-block mb-4">
            <section class="card bg-custom-yellow text-white">
                <section class="card-body">
                    <section class="d-flex justify-content-between">
                        <section class="info-box-body">
                            <h5>{{ $panelRepo->ordersCount() }}</h5>
                            <p>تعداد سفارشات</p>
                        </section>
                        <section class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </section>
                    </section>
                </section>
                <section class="card-footer info-box-footer">
                    <i class="fas fa-clock mx-2"></i> به روز رسانی شده در : {{ jalaliDate(now()) }}
                </section>
            </section>
        </a>
    </section>
    <section class="col-lg-2 col-md-6 col-12">
        <a href="{{ route('product.index') }}" class="text-decoration-none d-block mb-4">
            <section class="card bg-danger text-white">
                <section class="card-body">
                    <section class="d-flex justify-content-between">
                        <section class="info-box-body">
                            <h5>{{ $panelRepo->productsCount() }}</h5>
                            <p>تعداد محصولات</p>
                        </section>
                        <section class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </section>
                    </section>
                </section>
                <section class="card-footer info-box-footer">
                    <i class="fas fa-clock mx-2"></i> به روز رسانی شده در : {{ jalaliDate(now()) }}
                </section>
            </section>
        </a>
    </section>
    <section class="col-lg-2 col-md-6 col-12">
        <a href="{{ route('amazingSale.index') }}" class="text-decoration-none d-block mb-4">
            <section class="card bg-success text-white">
                <section class="card-body">
                    <section class="d-flex justify-content-between">
                        <section class="info-box-body">
                            <h5>{{ $panelRepo->activeAmazingSalesCount() }}</h5>
                            <p>تعداد تخفیفات شگفت انگیز فعال</p>
                        </section>
                        <section class="info-box-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </section>
                    </section>
                </section>
                <section class="card-footer info-box-footer">
                    <i class="fas fa-clock mx-2"></i> به روز رسانی شده در : {{ jalaliDate(now()) }}
                </section>
            </section>
        </a>
    </section>
    <section class="col-lg-2 col-md-6 col-12">
        <a href="{{ route('adminUser.index') }}" class="text-decoration-none d-block mb-4">
            <section class="card bg-warning text-white">
                <section class="card-body">
                    <section class="d-flex justify-content-between">
                        <section class="info-box-body">
                            <h5>{{ $panelRepo->adminUsersCount() }}</h5>
                            <p>تعداد ادمین های سیستم</p>
                        </section>
                        <section class="info-box-icon">
                            <i class="fas fa-user-secret"></i>
                        </section>
                    </section>
                </section>
                <section class="card-footer info-box-footer">
                    <i class="fas fa-clock mx-2"></i> به روز رسانی شده در : {{ jalaliDate(now()) }}
                </section>
            </section>
        </a>
    </section>
    <section class="col-lg-2 col-md-6 col-12">
        <a href="{{ route('ticket.newTickets') }}" class="text-decoration-none d-block mb-4">
            <section class="card bg-primary text-white">
                <section class="card-body">
                    <section class="d-flex justify-content-between">
                        <section class="info-box-body">
                            <h5>{{ $panelRepo->newTicketsCount() }}</h5>
                            <p>تعداد تیکت های جدید</p>
                        </section>
                        <section class="info-box-icon">
                            <i class="fas fa-book-open"></i>
                        </section>
                    </section>
                </section>
                <section class="card-footer info-box-footer">
                    <i class="fas fa-clock mx-2"></i> به روز رسانی شده در : {{ jalaliDate(now()) }}
                </section>
            </section>
        </a>
    </section>
{{--    <section class="col-lg-2 col-md-6 col-12">--}}
{{--        <a href="#" class="text-decoration-none d-block mb-4">--}}
{{--            <section class="card bg-primary text-white">--}}
{{--                <section class="card-body">--}}
{{--                    <section class="d-flex justify-content-between">--}}
{{--                        <section class="info-box-body">--}}
{{--                            <h5>{{ $panelRepo->customerHomeViewCount() }}</h5>--}}
{{--                            <p>تعداد بازدید از فروشگاه</p>--}}
{{--                        </section>--}}
{{--                        <section class="info-box-icon">--}}
{{--                            <i class="fas fa-chart-line"></i>--}}
{{--                        </section>--}}
{{--                    </section>--}}
{{--                </section>--}}
{{--                <section class="card-footer info-box-footer">--}}
{{--                    <i class="fas fa-clock mx-2"></i> به روز رسانی شده در : {{ jalaliDate(now()) }}--}}
{{--                </section>--}}
{{--            </section>--}}
{{--        </a>--}}
{{--    </section>--}}
</section>
