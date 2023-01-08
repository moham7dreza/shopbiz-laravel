<aside id="sidebar" class="sidebar">
    <section class="sidebar-container">
        <section class="sidebar-wrapper">
            <a href="{{ route('panel.home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>خانه</span>
            </a>
            <a href="{{ route('customer.home') }}" class="sidebar-link">
                <i class="fas fa-gift"></i>
                <span>فروشگاه</span>
            </a>
            @can('permission-super-admin','permission-market')
                <section class="sidebar-part-title">بخش فروش</section>
                @can('permission-super-admin','permission-vitrine')
                    <section class="sidebar-group-link">
                        <section class="sidebar-dropdown-toggle">
                            <i class="fas fa-chart-bar icon"></i>
                            <span>ویترین</span>
                            <i class="fas fa-angle-left angle"></i>
                        </section>
                        <section class="sidebar-dropdown">
                            @can('permission-super-admin','permission-product-categories')
                                <a href="{{ route('product-category.index') }}">دسته بندی</a>
                            @endcan
                            @can('permission-super-admin','permission-product-properties')
                                <a href="{{ route('category-property.index') }}">فرم کالا</a>
                            @endcan
                            @can('permission-super-admin','permission-product-brands')
                                <a href="{{ route('brand.index') }}">برندها</a>
                            @endcan
                            @can('permission-super-admin','permission-products')
                                <a href="{{ route('product.index') }}">کالاها</a>
                            @endcan
                            @can('permission-super-admin','permission-product-warehouse')
                                <a href="{{ route('product.store.index') }}">انبار</a>
                            @endcan
                            @can('permission-super-admin','permission-product-comments')
                                <a href="{{ route('product-comment.index') }}">نظرات</a>
                            @endcan
                        </section>
                    </section>
                @endcan
                @can('permission-super-admin','permission-product-orders')
                    <section class="sidebar-group-link">
                        <section class="sidebar-dropdown-toggle">
                            <i class="fas fa-chart-bar icon"></i>
                            <span>سفارشات</span>
                            <i class="fas fa-angle-left angle"></i>
                        </section>
                        <section class="sidebar-dropdown">
                            @can('permission-super-admin','permission-product-new-orders')
                                <a href="{{ route('order.newOrders') }}"> جدید</a>
                            @endcan
                            @can('permission-super-admin','permission-product-sending-orders')
                                <a href="{{ route('order.sending') }}">در حال ارسال</a>
                            @endcan
                            @can('permission-super-admin','permission-product-unpaid-orders')
                                <a href="{{ route('order.unpaid') }}">پرداخت نشده</a>
                            @endcan
                            @can('permission-super-admin','permission-product-canceled-orders')
                                <a href="{{ route('order.canceled') }}">باطل شده</a>
                            @endcan
                            @can('permission-super-admin','permission-product-returned-orders')
                                <a href="{{ route('order.returned') }}">مرجوعی</a>
                            @endcan
                            @can('permission-super-admin','permission-product-all-orders')
                                <a href="{{ route('order.all') }}">تمام سفارشات</a>
                            @endcan
                        </section>
                    </section>
                @endcan
                @can('permission-super-admin','permission-product-payments')
                    <section class="sidebar-group-link">
                        <section class="sidebar-dropdown-toggle">
                            <i class="fas fa-chart-bar icon"></i>
                            <span>پرداخت ها</span>
                            <i class="fas fa-angle-left angle"></i>
                        </section>
                        <section class="sidebar-dropdown">
                            @can('permission-super-admin','permission-product-all-payments')
                                <a href="{{ route('payment.index') }}">تمام پرداخت ها</a>
                            @endcan
                            @can('permission-super-admin','permission-product-online-payments')
                                <a href="{{ route('payment.online') }}">پرداخت های آنلاین</a>
                            @endcan
                            @can('permission-super-admin','permission-product-offline-payments')
                                <a href="{{ route('payment.offline') }}">پرداخت های آفلاین</a>
                            @endcan
                            @can('permission-super-admin','permission-product-cash-payments')
                                <a href="{{ route('payment.cash') }}">پرداخت در محل</a>
                            @endcan
                        </section>
                    </section>
                @endcan
                @can('permission-super-admin','permission-product-discounts')
                    <section class="sidebar-group-link">
                        <section class="sidebar-dropdown-toggle">
                            <i class="fas fa-chart-bar icon"></i>
                            <span>تخفیف ها</span>
                            <i class="fas fa-angle-left angle"></i>
                        </section>
                        <section class="sidebar-dropdown">
                            @can('permission-super-admin','permission-product-coupon-discounts')
                                <a href="{{ route('discount.copan') }}">کپن تخفیف</a>
                            @endcan
                            @can('permission-super-admin','permission-product-common-discounts')
                                <a href="{{ route('discount.commonDiscount') }}">تخفیف عمومی</a>
                            @endcan
                            @can('permission-super-admin','permission-product-amazing-sales')
                                <a href="{{ route('discount.amazingSale') }}">فروش شگفت انگیز</a>
                            @endcan
                        </section>
                    </section>
                @endcan
                @can('permission-super-admin','permission-delivery-methods')
                    <a href="{{ route('delivery.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>روش های ارسال</span>
                    </a>
                @endcan
            @endcan
            @can('permission-super-admin','permission-content')
                <section class="sidebar-part-title">بخش محتوی</section>
                @can('permission-super-admin','permission-post-categories')
                    <a href="{{ route('post-category.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>دسته بندی</span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-posts')
                    <a href="{{ route('post.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>پست ها</span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-post-comments')
                    <a href="{{ route('post-comment.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>نظرات</span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-menus')
                    <a href="{{ route('menu.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>منو</span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-faqs')
                    <a href="{{ route('faq.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>سوالات متداول</span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-pages')
                    <a href="{{ route('page.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>پیج ساز</span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-banners')
                    <a href="{{ route('banner.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>بنر ها</span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-tags')
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>تگ</span>
                    </a>
                @endcan
            @endcan
            @canany(['permission-super-admin','permission-users'])
                <section class="sidebar-part-title">بخش کاربران</section>
                @can('permission-super-admin','permission-admin-users')
                    <a href="{{ route('admin-user.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>کاربران ادمین</span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-customer-users')
                    <a href="{{ route('customer-user.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>مشتریان</span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-user-roles')
                    <section class="sidebar-group-link">
                        <section class="sidebar-dropdown-toggle">
                            <i class="fas fa-chart-bar icon"></i>
                            <span>سطوح دسترسی</span>
                            <i class="fas fa-angle-left angle"></i>
                        </section>
                        <section class="sidebar-dropdown">
                            <a href="{{ route('role.index') }}">مدیریت نقش ها</a>
                            <a href="{{ route('permission.index') }}">مدیریت دسترسی ها</a>
                        </section>
                    </section>
                @endcan
            @endcanany
            @can('permission-super-admin','permission-tickets')
                <section class="sidebar-part-title">تیکت ها</section>
                @can('permission-super-admin','permission-ticket-categories')
                    <a href="{{ route('ticket-category.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span> دسته بندی تیکت ها </span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-ticket-priorities')
                    <a href="{{ route('ticket-priority.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span> اولویت تیکت ها </span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-admin-tickets')
                    <a href="{{ route('ticket-admin.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span> ادمین تیکت ها </span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-new-tickets')
                    <a href="{{ route('ticket.newTickets') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>تیکت های جدید</span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-open-tickets')
                    <a href="{{ route('ticket.openTickets') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>تیکت های باز</span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-close-tickets')
                    <a href="{{ route('ticket.closeTickets') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>تیکت های بسته</span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-all-tickets')
                    <a href="{{ route('ticket.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>همه ی تیکت ها</span>
                    </a>
                @endcan
            @endcan
            @can('permission-super-admin','permission-notify')
                <section class="sidebar-part-title">اطلاع رسانی</section>
                @can('permission-super-admin','permission-email-notify')
                    <a href="{{ route('email-notify.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>اعلامیه ایمیلی</span>
                    </a>
                @endcan
                @can('permission-super-admin','permission-sms-notify')
                    <a href="{{ route('sms-notify.index') }}" class="sidebar-link">
                        <i class="fas fa-bars"></i>
                        <span>اعلامیه پیامکی</span>
                    </a>

                @endcan
            @endcan
            @can('permission-super-admin','permission-setting')
                <section class="sidebar-part-title">تنظیمات</section>
                <a href="{{ route('setting.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>تنظیمات</span>
                </a>
            @endcan
        </section>
    </section>
</aside>
