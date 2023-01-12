<aside id="sidebar" class="sidebar">
    <section class="sidebar-container">
        <section class="sidebar-wrapper">

            <a href="{{ route('panel.home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>خانه</span>
            </a>

            <section class="sidebar-part-title">بخش فروش</section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>ویترین</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{ route('productCategory.index') }}">دسته بندی</a>
                    <a href="{{ route('categoryAttribute.index') }}">فرم کالا</a>
                    <a href="{{ route('brand.index') }}">برندها</a>
                    <a href="{{ route('product.index') }}">کالاها</a>
                    <a href="{{ route('product.store.index') }}">انبار</a>
                    <a href="{{ route('productComment.index') }}">نظرات</a>
                </section>
            </section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>سفارشات</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{ route('order.newOrders') }}"> جدید</a>
                    <a href="{{ route('order.sending') }}">در حال ارسال</a>
                    <a href="{{ route('order.unpaid') }}">پرداخت نشده</a>
                    <a href="{{ route('order.canceled') }}">باطل شده</a>
                    <a href="{{ route('order.returned') }}">مرجوعی</a>
                    <a href="{{ route('order.all') }}">تمام سفارشات</a>
                </section>
            </section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>پرداخت ها</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{ route('payment.index') }}">تمام پرداخت ها</a>
                    <a href="{{ route('payment.online') }}">پرداخت های آنلاین</a>
                    <a href="{{ route('payment.offline') }}">پرداخت های آفلاین</a>
                    <a href="{{ route('payment.cash') }}">پرداخت در محل</a>
                </section>
            </section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>تخفیف ها</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{ route('discount.copan') }}">کپن تخفیف</a>
                    <a href="{{ route('discount.commonDiscount') }}">تخفیف عمومی</a>
                    <a href="{{ route('discount.amazingSale') }}">فروش شگفت انگیز</a>
                </section>
            </section>

            <a href="{{ route('delivery.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>روش های ارسال</span>
            </a>



            <section class="sidebar-part-title">بخش محتوی</section>
{{--            @role('operator')--}}
            <a href="{{ route('postCategory.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>دسته بندی</span>
            </a>
{{--            @endrole--}}

            <a href="{{ route('post.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>پست ها</span>
            </a>
            <a href="{{ route('postComment.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>نظرات</span>
            </a>
            <a href="{{ route('menu.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>منو</span>
            </a>
            <a href="{{ route('faq.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>سوالات متداول</span>
            </a>
            <a href="{{ route('page.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>پیج ساز</span>
            </a>
            <a href="{{ route('banner.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>بنر ها</span>
            </a>



            <section class="sidebar-part-title">بخش کاربران</section>
            <a href="{{ route('adminUser.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>کاربران ادمین</span>
            </a>
            <a href="{{ route('customerUser.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>مشتریان</span>
            </a>
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



            <section class="sidebar-part-title">تیکت ها</section>
            <a href="{{ route('ticketCategory.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span> دسته بندی تیکت ها </span>
            </a>
            <a href="{{ route('ticketPriority.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span> اولویت تیکت ها </span>
            </a>
            <a href="{{ route('ticket-admin.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span> ادمین تیکت ها </span>
            </a>
            <a href="{{ route('ticket.newTickets') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>تیکت های جدید</span>
            </a>
            <a href="{{ route('ticket.openTickets') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>تیکت های باز</span>
            </a>
            <a href="{{ route('ticket.closeTickets') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>تیکت های بسته</span>
            </a>

            <a href="{{ route('ticket.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>همه ی تیکت ها</span>
            </a>



            <section class="sidebar-part-title">اطلاع رسانی</section>
            <a href="{{ route('email.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>اعلامیه ایمیلی</span>
            </a>
            <a href="{{ route('sms.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>اعلامیه پیامکی</span>
            </a>



            <section class="sidebar-part-title">تنظیمات</section>
            <a href="{{ route('setting.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>تنظیمات</span>
            </a>

        </section>
    </section>
</aside>
