<!-- Counters cards --->
<section class="row">
    <x-panel-card class="bg-custom-yellow" route="{{ route('customerUser.index') }}" title="تعداد مشتریانی که ایمیل یا موبایل خود را تایید نکرده اند."
                  :counter="$panelRepo->notVerifiedCustomerUsersCount()" icon="users"/>
    <x-panel-card class="bg-custom-green" route="{{ route('post.index') }}" title="تعداد پست هایی که در صف انتشار هستند."
                  :counter="$panelRepo->notPublishedPostsCount()" group="fab" icon="instagram"/>
    <x-panel-card class="bg-custom-pink" route="{{ route('productComment.index') }}" title="تعداد نظرات دیده نشده که برای کالاها ارسال شده اند."
                  :counter="$panelRepo->unseenProductCommentsCount()" group="fab" icon="telegram-plane"/>
    <x-panel-card class="bg-info" route="{{ route('order.newOrders') }}" title="تعداد سفارشات جدید"
                  :counter="$panelRepo->newOrdersCount()" icon="shopping-cart"/>
    <x-panel-card class="bg-custom-light-green text-dark" route="{{ route('product.index') }}" title="تعداد محصولاتی که بازدید کمی دارند."
                  :counter="$panelRepo->lowViewProductsCount()" icon="shopping-bag"/>
    <x-panel-card class="bg-primary" route="{{ route('amazingSale.index') }}" title="تعداد تخفیفات شگفت انگیز فعال"
                  :counter="$panelRepo->activeAmazingSalesCount()" icon="dollar-sign"/>
    <x-panel-card class="bg-warning text-dark" route="{{ route('adminUser.index') }}" title="تعداد ادمین هایی که وضعیت آنها غیر فعال است."
                  :counter="$panelRepo->notActiveAdminUsersCount()" icon="user-secret"/>
    <x-panel-card class="bg-success" route="{{ route('ticket.newTickets') }}" title="تعداد تیکت های جدید"
                  :counter="$panelRepo->newTicketsCount()" icon="ticket-alt"/>
    <x-panel-card class="bg-danger" route="{{ route('payment.index') }}" title="تعداد پرداخت های دریافت نشده"
                  :counter="$panelRepo->notPaidPaymentsCount()" icon="cash-register"/>
    <x-panel-card class="bg-gray" route="{{ route('product.store.index') }}" title="انباری، تعداد محصولاتی که موجودی آنها رو به اتمام است."
                  :counter="$panelRepo->lowCountProducts()" icon="warehouse"/>
    <x-panel-card class="bg-greenyellow text-dark" route="{{ route('permission.index') }}" title="تعداد سطوح دسترسی فعال در پنل ادمین"
                  :counter="$panelRepo->permissionsCount()" group="fab" icon="gitlab"/>
    <x-panel-card class="bg-secondary" route="{{ route('banner.index') }}" title="اسلایدشو و بنر های تبلیغاتی"
                  :counter="$panelRepo->bannersCount()" icon="ad"/>
</section>
