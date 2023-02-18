<aside id="sidebar" class="sidebar">
    <section class="sidebar-container">
        @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
        @can($PERMISSION::PERMISSION_ADMIN_PANEL)
            <section class="sidebar-wrapper">
                <a href="{{ route('panel.home') }}" class="sidebar-link">
                    <i class="fas fa-home"></i>
                    <span>خانه</span>
                </a>
                <a href="{{ route('customer.home') }}" class="sidebar-link" target="_blank">
                    <i class="fas fa-store"></i>
                    <span>فروشگاه</span>
                </a>
                @can($PERMISSION::PERMISSION_SETTING)
                    <section class="sidebar-part-title">تنظیمات</section>
                    <a href="{{ route('setting.index') }}" class="sidebar-link">
                        <i class="fas fa-tools"></i>
                        <span>تنظیمات</span>
                    </a>
                @endcan
                @can($PERMISSION::PERMISSION_COMMON)
                    <section class="sidebar-part-title">بخش مشترک</section>
                    @can($PERMISSION::PERMISSION_TAGS)
                        <a href="{{ route('tag.index') }}" class="sidebar-link">
                            <i class="fas fa-tags"></i>
                            <span>تگ ها</span>
                        </a>
                    @endcan
                @endcan
                @can($PERMISSION::PERMISSION_USERS)
                    <section class="sidebar-part-title">بخش کاربران</section>
                    @can($PERMISSION::PERMISSION_ADMIN_USERS)
                        <a href="{{ route('adminUser.index') }}" class="sidebar-link">
                            <i class="fas fa-user-secret"></i>
                            <span>کاربران ادمین</span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_CUSTOMER_USERS)
                        <a href="{{ route('customerUser.index') }}" class="sidebar-link">
                            <i class="fas fa-users"></i>
                            <span>مشتریان</span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_ROLES)
                        <a href="{{ route('role.index') }}" class="sidebar-link">
                            <i class="fas fa-shield-alt"></i>
                            <span>نقش ها</span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSIONS)
                        <a href="{{ route('permission.index') }}" class="sidebar-link">
                            <i class="fas fa-user-secret"></i>
                            <span>سطوح دسترسی</span>
                        </a>
                    @endcan
                @endcanany
                @can($PERMISSION::PERMISSION_MARKET)
                    <section class="sidebar-part-title">بخش فروش</section>
                    @can($PERMISSION::PERMISSION_VITRINE)
                        <section class="sidebar-group-link">
                            <section class="sidebar-dropdown-toggle">
                                <i class="fas fa-shopping-bag icon"></i>
                                <span>ویترین</span>
                                <i class="fas fa-angle-left angle"></i>
                            </section>
                            <section class="sidebar-dropdown">
                                @can($PERMISSION::PERMISSION_PRODUCT_CATEGORIES)
                                    <a href="{{ route('productCategory.index') }}">دسته بندی</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_ATTRIBUTES)
                                    <a href="{{ route('attribute.index') }}">فرم کالا</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_BRANDS)
                                    <a href="{{ route('brand.index') }}">برندها</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_PRODUCTS)
                                    <a href="{{ route('product.index') }}">کالاها</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_WAREHOUSE)
                                    <a href="{{ route('product.store.index') }}">انبار</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_PRODUCT_COMMENTS)
                                    <a href="{{ route('productComment.index') }}">نظرات</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_COLORS)
                                    <a href="{{ route('color.index') }}">رنگ ها</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_GUARANTEES)
                                    <a href="{{ route('guarantee.index') }}">گارانتی</a>
                                @endcan
                            </section>
                        </section>
                    @endcan
                    @can($PERMISSION::PERMISSION_ORDERS)
                        <section class="sidebar-group-link">
                            <section class="sidebar-dropdown-toggle">
                                <i class="fas fa-shopping-cart icon"></i>
                                <span>سفارشات</span>
                                <i class="fas fa-angle-left angle"></i>
                            </section>
                            <section class="sidebar-dropdown">
                                @can($PERMISSION::PERMISSION_NEW_ORDERS)
                                    <a href="{{ route('order.newOrders') }}"> جدید</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_SENDING_ORDERS)
                                    <a href="{{ route('order.sending') }}">در حال ارسال</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_UNPAID_ORDERS)
                                    <a href="{{ route('order.unpaid') }}">پرداخت نشده</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_CANCELED_ORDERS)
                                    <a href="{{ route('order.canceled') }}">باطل شده</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_RETURNED_ORDERS)
                                    <a href="{{ route('order.returned') }}">مرجوعی</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_ALL_ORDERS)
                                    <a href="{{ route('order.index') }}">تمام سفارشات</a>
                                @endcan
                            </section>
                        </section>
                    @endcan
                    @can($PERMISSION::PERMISSION_PAYMENTS)
                        <section class="sidebar-group-link">
                            <section class="sidebar-dropdown-toggle">
                                <i class="fas fa-cash-register icon"></i>
                                <span>پرداخت ها</span>
                                <i class="fas fa-angle-left angle"></i>
                            </section>
                            <section class="sidebar-dropdown">
                                @can($PERMISSION::PERMISSION_ALL_PAYMENTS)
                                    <a href="{{ route('payment.index') }}">تمام پرداخت ها</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_ONLINE_PAYMENTS)
                                    <a href="{{ route('payment.online') }}">پرداخت های آنلاین</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_OFFLINE_PAYMENTS)
                                    <a href="{{ route('payment.offline') }}">پرداخت های آفلاین</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_CASH_PAYMENTS)
                                    <a href="{{ route('payment.cash') }}">پرداخت در محل</a>
                                @endcan
                            </section>
                        </section>
                    @endcan
                    @can($PERMISSION::PERMISSION_DISCOUNTS)
                        <section class="sidebar-group-link">
                            <section class="sidebar-dropdown-toggle">
                                <i class="fas fa-dollar-sign icon"></i>
                                <span>تخفیف ها</span>
                                <i class="fas fa-angle-left angle"></i>
                            </section>
                            <section class="sidebar-dropdown">
                                @can($PERMISSION::PERMISSION_COUPON_DISCOUNTS)
                                    <a href="{{ route('copanDiscount.index') }}">کپن تخفیف</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_COMMON_DISCOUNTS)
                                    <a href="{{ route('commonDiscount.index') }}">تخفیف عمومی</a>
                                @endcan
                                @can($PERMISSION::PERMISSION_AMAZING_SALES)
                                    <a href="{{ route('amazingSale.index') }}">فروش شگفت انگیز</a>
                                @endcan
                            </section>
                        </section>
                    @endcan
                    @can($PERMISSION::PERMISSION_DELIVERY_METHODS)
                        <a href="{{ route('delivery.index') }}" class="sidebar-link">
                            <i class="fas fa-truck-loading"></i>
                            <span>روش های ارسال</span>
                        </a>
                    @endcan
                @endcan
                @can($PERMISSION::PERMISSION_CONTENT)
                    <section class="sidebar-part-title">بخش محتوی</section>
                    @can($PERMISSION::PERMISSION_POST_CATEGORIES)
                        <a href="{{ route('postCategory.index') }}" class="sidebar-link">
                            <i class="fas fa-list-ul"></i>
                            <span>دسته بندی</span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_POSTS)
                        <a href="{{ route('post.index') }}" class="sidebar-link">
                            <i class="fas fa-blog"></i>
                            <span>پست ها</span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_POST_COMMENTS)
                        <a href="{{ route('postComment.index') }}" class="sidebar-link">
                            <i class="fas fa-comment"></i>
                            <span>نظرات</span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_MENUS)
                        <a href="{{ route('menu.index') }}" class="sidebar-link">
                            <i class="fas fa-link"></i>
                            <span>منو</span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_FAQS)
                        <a href="{{ route('faq.index') }}" class="sidebar-link">
                            <i class="fas fa-question"></i>
                            <span>سوالات متداول</span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_PAGES)
                        <a href="{{ route('page.index') }}" class="sidebar-link">
                            <i class="fas fa-pager"></i>
                            <span>پیج ساز</span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_BANNERS)
                        <a href="{{ route('banner.index') }}" class="sidebar-link">
                            <i class="fas fa-ad"></i>
                            <span>بنر ها</span>
                        </a>
                    @endcan
                @endcan

                @can($PERMISSION::PERMISSION_TICKETS)
                    <section class="sidebar-part-title">تیکت ها</section>
                    @can($PERMISSION::PERMISSION_TICKET_CATEGORIES)
                        <a href="{{ route('ticketCategory.index') }}" class="sidebar-link">
                            <i class="fas fa-list-ol"></i>
                            <span> دسته بندی تیکت ها </span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_TICKET_PRIORITIES)
                        <a href="{{ route('ticketPriority.index') }}" class="sidebar-link">
                            <i class="fas fa-toolbox"></i>
                            <span> اولویت تیکت ها </span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_ADMIN_TICKETS)
                        <a href="{{ route('ticket-admin.index') }}" class="sidebar-link">
                            <i class="fas fa-user-lock"></i>
                            <span> ادمین تیکت ها </span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_NEW_TICKETS)
                        <a href="{{ route('ticket.newTickets') }}" class="sidebar-link">
                            <i class="fas fa-book-open"></i>
                            <span>تیکت های جدید</span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_OPEN_TICKETS)
                        <a href="{{ route('ticket.openTickets') }}" class="sidebar-link">
                            <i class="fas fa-box-open"></i>
                            <span>تیکت های باز</span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_CLOSE_TICKETS)
                        <a href="{{ route('ticket.closeTickets') }}" class="sidebar-link">
                            <i class="fas fa-box-tissue"></i>
                            <span>تیکت های بسته</span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_ALL_TICKETS)
                        <a href="{{ route('ticket.index') }}" class="sidebar-link">
                            <i class="fas fa-ticket-alt"></i>
                            <span>همه ی تیکت ها</span>
                        </a>
                    @endcan
                @endcan
                @can($PERMISSION::PERMISSION_NOTIFY)
                    <section class="sidebar-part-title">اطلاع رسانی</section>
                    @can($PERMISSION::PERMISSION_EMAIL_NOTIFYS)
                        <a href="{{ route('email.index') }}" class="sidebar-link">
                            <i class="fas fa-mail-bulk"></i>
                            <span>اعلامیه ایمیلی</span>
                        </a>
                    @endcan
                    @can($PERMISSION::PERMISSION_SMS_NOTIFYS)
                        <a href="{{ route('sms.index') }}" class="sidebar-link">
                            <i class="fas fa-sms"></i>
                            <span>اعلامیه پیامکی</span>
                        </a>
                    @endcan
                @endcan
            </section>
        @endcan
    </section>
</aside>
