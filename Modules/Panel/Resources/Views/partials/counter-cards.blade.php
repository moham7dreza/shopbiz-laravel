<!-- Counters cards --->
<section class="row">
    <x-panel-card class="bg-custom-yellow" route="{{ route('customerUser.index') }}" title="تعداد مشتریان سیستم"
                  :counter="$panelRepo->customersCount()" icon="users"/>
    <x-panel-card class="bg-custom-green" route="{{ route('post.index') }}" title="تعداد پست ها"
                  :counter="$panelRepo->postsCount()" group="fab" icon="instagram"/>
    <x-panel-card class="bg-custom-pink" route="{{ route('productComment.index') }}" title="تعداد نظرات"
                  :counter="$panelRepo->commentsCount()" group="fab" icon="telegram-plane"/>
    <x-panel-card class="bg-info" route="{{ route('order.index') }}" title="تعداد سفارشات"
                  :counter="$panelRepo->ordersCount()" icon="shopping-cart"/>
    <x-panel-card class="bg-custom-light-green text-dark" route="{{ route('product.index') }}" title="تعداد محصولات"
                  :counter="$panelRepo->productsCount()" icon="shopping-bag"/>
    <x-panel-card class="bg-primary" route="{{ route('amazingSale.index') }}" title="تعداد تخفیفات شگفت انگیز فعال"
                  :counter="$panelRepo->activeAmazingSalesCount()" icon="dollar-sign"/>
    <x-panel-card class="bg-warning text-dark" route="{{ route('adminUser.index') }}" title="تعداد ادمین های سیستم"
                  :counter="$panelRepo->adminUsersCount()" icon="user-secret"/>
    <x-panel-card class="bg-success" route="{{ route('ticket.newTickets') }}" title="تعداد تیکت های جدید"
                  :counter="$panelRepo->newTicketsCount()" icon="book-open"/>
    <x-panel-card class="bg-danger" route="{{ route('payment.index') }}" title="تعداد پرداخت ها"
                  :counter="$panelRepo->paymentsCount()" icon="cash-register"/>
    <x-panel-card class="bg-gray" route="{{ route('product.store.index') }}" title="انباری"
                  :counter="$panelRepo->lowCountProducts()" icon="warehouse"/>
    <x-panel-card class="bg-greenyellow text-dark" route="{{ route('brand.index') }}" title="برندها"
                  :counter="$panelRepo->brandsCount()" group="fab" icon="gitlab"/>
    <x-panel-card class="bg-secondary" route="{{ route('banner.index') }}" title="تبلیغات"
                  :counter="$panelRepo->bannersCount()" icon="ad"/>
</section>
