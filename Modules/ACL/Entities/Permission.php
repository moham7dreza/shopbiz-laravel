<?php

namespace Modules\ACL\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasFaDate;
use Modules\User\Entities\User;

class Permission extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    protected $fillable = ['name', 'description', 'status'];

    // access everywhere
    //******************************************************************************************************************
    public const PERMISSION_SUPER_ADMIN = ['name' => 'permission-super-admin', 'description' => 'مدیر ارشد سیستم - دسترسی نامحدود'];

    // access to each panels
    //******************************************************************************************************************
    public const PERMISSION_ADMIN_PANEL = ['name' => 'permission-admin-panel', 'description' => 'دسترسی به پنل مدیریت بخش آیتی سیتی'];

    // Market section Permissions
    //******************************************************************************************************************
    public const PERMISSION_MARKET = ['name' => 'permission-market', 'description' => 'دسترسی به بخش فروش'];

    // A. Vitrine
    public const PERMISSION_VITRINE = ['name' => 'permission-vitrine', 'description' => 'دسترسی به بخش ویترین'];

    // 1- product category
    public const PERMISSION_PRODUCT_CATEGORIES = ['name' => 'permission-product-categories', 'description' => 'دسترسی به بخش دسته بندی محصولات'];
    public const PERMISSION_PRODUCT_CATEGORY_CREATE = ['name' => 'permission-product-category-create', 'description' => 'دسترسی به بخش ایجاد دسته بندی محصول'];
    public const PERMISSION_PRODUCT_CATEGORY_EDIT = ['name' => 'permission-product-category-edit', 'description' => 'دسترسی به بخش ویرایش دسته بندی محصول'];
    public const PERMISSION_PRODUCT_CATEGORY_DELETE = ['name' => 'permission-product-category-delete', 'description' => 'دسترسی به بخش حذف دسته بندی محصول'];
    public const PERMISSION_PRODUCT_CATEGORY_STATUS = ['name' => 'permission-product-category-status', 'description' => 'دسترسی به بخش تغییر وضعیت دسته بندی محصول'];

    // 2- PRODUCT PROPERTY
    public const PERMISSION_PRODUCT_PROPERTIES = ['name' => 'permission-product-properties', 'description' => 'دسترسی به بخش فرم کالا'];
    public const PERMISSION_PRODUCT_PROPERTY_CREATE = ['name' => 'permission-product-property-create', 'description' => 'دسترسی به بخش ایجاد فرم کالا'];
    public const PERMISSION_PRODUCT_PROPERTY_EDIT = ['name' => 'permission-product-property-edit', 'description' => 'دسترسی به بخش ویرایش فرم کالا'];
    public const PERMISSION_PRODUCT_PROPERTY_DELETE = ['name' => 'permission-product-property-delete', 'description' => 'دسترسی به بخش حذف فرم کالا'];
    public const PERMISSION_PRODUCT_PROPERTY_STATUS = ['name' => 'permission-product-property-status', 'description' => 'دسترسی به بخش تغغیر وضعیت فرم کالا'];
    public const PERMISSION_PRODUCT_PROPERTY_ATTRIBUTES = ['name' => 'permission-product-property-attributes', 'description' => 'دسترسی به بخش ویژگی های فرم کالا'];
    public const PERMISSION_PRODUCT_PROPERTY_ATTRIBUTE_CREATE = ['name' => 'permission-product-property-attribute-create', 'description' => 'دسترسی به بخش ایجاد ویژگی برای فرم کالا'];
    public const PERMISSION_PRODUCT_PROPERTY_ATTRIBUTE_EDIT = ['name' => 'permission-product-property-attribute-edit', 'description' => 'دسترسی به بخش ویرایش ویژگی مربوط به فرم کالا'];
    public const PERMISSION_PRODUCT_PROPERTY_ATTRIBUTE_DELETE = ['name' => 'permission-product-property-attribute-delete', 'description' => 'دسترسی به بخش حذف ویژگی مربوط به فرم کالا'];
    public const PERMISSION_PRODUCT_PROPERTY_ATTRIBUTE_STATUS = ['name' => 'permission-product-property-attribute-status', 'description' => 'دسترسی به بخش تغییر وضعیت ویژگی مربوط به فرم کالا'];

    // 3- PRODUCT BRAND
    public const PERMISSION_PRODUCT_BRANDS = ['name' => 'permission-product-brands', 'description' => 'دسترسی به بخش برندهای محصولات'];
    public const PERMISSION_PRODUCT_BRAND_CREATE = ['name' => 'permission-product-brand-create', 'description' => 'دسترسی به بخش ایجاد برند محصول'];
    public const PERMISSION_PRODUCT_BRAND_EDIT = ['name' => 'permission-product-brand-edit', 'description' => 'دسترسی به بخش ویرایش برند محصول'];
    public const PERMISSION_PRODUCT_BRAND_DELETE = ['name' => 'permission-product-brand-delete', 'description' => 'دسترسی به بخش حذف برند محصول'];
    public const PERMISSION_PRODUCT_BRAND_STATUS = ['name' => 'permission-product-brand-status', 'description' => 'دسترسی به بخش تغییر وضعیت برند محصول'];

    // 4- PRODUCT
    public const PERMISSION_PRODUCTS = ['name' => 'permission-products', 'description' => 'دسترسی به بخش محصولات'];
    public const PERMISSION_PRODUCT_CREATE = ['name' => 'permission-product-create', 'description' => 'دسترسی به بخش ایجاد محصول'];
    public const PERMISSION_PRODUCT_EDIT = ['name' => 'permission-product-edit', 'description' => 'دسترسی به بخش ویرایش محصول'];
    public const PERMISSION_PRODUCT_DELETE = ['name' => 'permission-product-delete', 'description' => 'دسترسی به بخش حذف محصول'];
    public const PERMISSION_PRODUCT_STATUS = ['name' => 'permission-product-status', 'description' => 'دسترسی به بخش تغییر وضعیت محصول'];
    public const PERMISSION_PRODUCT_GALLERY = ['name' => 'permission-product-gallery', 'description' => 'دسترسی به بخش گالری محصول'];
    public const PERMISSION_PRODUCT_GALLERY_CREATE = ['name' => 'permission-product-gallery-create', 'description' => 'دسترسی به بخش ایجاد گالری محصول'];
    public const PERMISSION_PRODUCT_GALLERY_DELETE = ['name' => 'permission-product-gallery-delete', 'description' => 'دسترسی به بخش حذف محصول'];
    public const PERMISSION_PRODUCT_GUARANTEES = ['name' => 'permission-product-guarantees', 'description' => 'دسترسی به بخش گارانتی محصول'];
    public const PERMISSION_PRODUCT_GUARANTEE_CREATE = ['name' => 'permission-product-guarantee-create', 'description' => 'دسترسی به بخش ایجاد گارانتی محصول'];
    public const PERMISSION_PRODUCT_GUARANTEE_DELETE = ['name' => 'permission-product-guarantee-delete', 'description' => 'دسترسی به بخش حذف گارانتی محصول'];
    public const PERMISSION_PRODUCT_COLORS = ['name' => 'permission-product-colors', 'description' => 'دسترسی به بخش رنگ محصول'];
    public const PERMISSION_PRODUCT_COLOR_CREATE = ['name' => 'permission-product-color-create', 'description' => 'دسترسی به بخش ایجاد رنگ محصول'];
    public const PERMISSION_PRODUCT_COLOR_DELETE = ['name' => 'permission-product-color-delete', 'description' => 'دسترسی به بخش حذف رنگ محصول'];

    // 5- WAREHOUSE
    public const PERMISSION_PRODUCT_WAREHOUSE = ['name' => 'permission-product-warehouse', 'description' => 'دسترسی به بخش انبار محصول'];
    public const PERMISSION_PRODUCT_WAREHOUSE_ADD = ['name' => 'permission-product-warehouse-add', 'description' => 'دسترسی به بخش افزایش موجودی محصول'];
    public const PERMISSION_PRODUCT_WAREHOUSE_MODIFY = ['name' => 'permission-product-warehouse-modify', 'description' => 'دسترسی به بخش ویرایش موجودی محصول'];

    // 6- PRODUCT COMMENT
    public const PERMISSION_PRODUCT_COMMENTS = ['name' => 'permission-product-comments', 'description' => 'دسترسی به بخش نظرات محصول'];
    public const PERMISSION_PRODUCT_COMMENT_SHOW = ['name' => 'permission-product-comment-show', 'description' => 'دسترسی به بخش نمایش نظر محصول'];
    public const PERMISSION_PRODUCT_COMMENT_STATUS = ['name' => 'permission-product-comment-status', 'description' => 'دسترسی به بخش وضعیت نظر محصول'];
    public const PERMISSION_PRODUCT_COMMENT_APPROVE = ['name' => 'permission-product-comment-approve', 'description' => 'دسترسی به بخش تایید نظر محصول'];


    // B. ORDER
    public const PERMISSION_ORDERS = ['name' => 'permission-product-orders', 'description' => 'دسترسی به سفارشات محصول'];
    // 1- NEW ORDER
    public const PERMISSION_NEW_ORDERS = ['name' => 'permission-product-new-orders', 'description' => 'دسترسی به بخش سفارشات جدید'];
    public const PERMISSION_NEW_ORDER_SHOW = ['name' => 'permission-product-new-order-show', 'description' => 'دسترسی به بخش نمایش سفارش جدید'];
    public const PERMISSION_NEW_ORDER_DETAIL = ['name' => 'permission-product-new-order-detail', 'description' => 'دسترسی به بخش جزئیات سفارش جدید'];
    public const PERMISSION_NEW_ORDER_PRINT = ['name' => 'permission-product-new-order-print', 'description' => 'دسترسی به بخش پرینت سفارش جدید'];
    public const PERMISSION_NEW_ORDER_CANCEL = ['name' => 'permission-product-new-order-cancel', 'description' => 'دسترسی به بخش باطل کردن سفارش جدید'];
    public const PERMISSION_NEW_ORDER_CHANGE_STATUS = ['name' => 'permission-product-new-order-status', 'description' => 'دسترسی به بخش تغییر وضعیت سفارش جدید'];
    public const PERMISSION_NEW_ORDER_CHANGE_SEND_STATUS = ['name' => 'permission-product-new-order-send-status', 'description' => 'دسترسی به بخش تغییر وضعیت ارسال سفارش جدید'];

    // 2- SENDING ORDER
    public const PERMISSION_SENDING_ORDERS = ['name' => 'permission-product-sending-orders', 'description' => 'دسترسی به بخش سفارشات در حال ارسال'];
    public const PERMISSION_SENDING_ORDER_SHOW = ['name' => 'permission-product-sending-order-show', 'description' => 'دسترسی به بخش نمایش سفارش در حال ارسال'];
    public const PERMISSION_SENDING_ORDER_DETAIL = ['name' => 'permission-product-sending-order-detail', 'description' => 'دسترسی به بخش جزئیات سفارش در حال ارسال'];
    public const PERMISSION_SENDING_ORDER_PRINT = ['name' => 'permission-product-sending-order-print', 'description' => 'دسترسی به بخش پرینت سفارش در حال ارسال'];
    public const PERMISSION_SENDING_ORDER_CANCEL = ['name' => 'permission-product-sending-order-cancel', 'description' => 'دسترسی به بخش باطل کردن سفارش در حال ارسال'];
    public const PERMISSION_SENDING_ORDER_CHANGE_STATUS = ['name' => 'permission-product-sending-order-status', 'description' => 'دسترسی به بخش تغییر وضعیت سفارش در حال ارسال'];
    public const PERMISSION_SENDING_ORDER_CHANGE_SEND_STATUS = ['name' => 'permission-product-sending-order-send-status', 'description' => 'دسترسی به بخش تغییر وضعیت ارسال سفارش در حال ارسال'];

    // 3- UNPAID ORDER
    public const PERMISSION_UNPAID_ORDERS = ['name' => 'permission-product-unpaid-orders', 'description' => 'دسترسی به بخش سفارشات پرداخت نشده'];
    public const PERMISSION_UNPAID_ORDER_SHOW = ['name' => 'permission-product-unpaid-order-show', 'description' => 'دسترسی به بخش نمایش سفارش پرداخت نشده'];
    public const PERMISSION_UNPAID_ORDER_SHOW_DETAIL = ['name' => 'permission-product-unpaid-order-detail', 'description' => 'دسترسی به بخش جزئیات سفارش پرداخت نشده'];
    public const PERMISSION_UNPAID_ORDER_SHOW_PRINT = ['name' => 'permission-product-unpaid-order-print', 'description' => 'دسترسی به بخش پرینت سفارش پرداخت نشده'];
    public const PERMISSION_UNPAID_ORDER_CANCEL = ['name' => 'permission-product-unpaid-order-cancel', 'description' => 'دسترسی به بخش باطل کردن سفارش پرداخت نشده'];
    public const PERMISSION_UNPAID_ORDER_CHANGE_STATUS = ['name' => 'permission-product-unpaid-order-status', 'description' => 'دسترسی به بخش تغییر وضعیت سفارش پرداخت نشده'];
    public const PERMISSION_UNPAID_ORDER_CHANGE_SEND_STATUS = ['name' => 'permission-product-unpaid-order-send-status', 'description' => 'دسترسی به بخش تغییر وضعیت ارسال سفارش پرداخت نشده'];

    // 4- CANCELED ORDER
    public const PERMISSION_CANCELED_ORDERS = ['name' => 'permission-product-canceled-orders', 'description' => 'دسترسی به بخش سفارشات باطل شده'];
    public const PERMISSION_CANCELED_ORDER_SHOW = ['name' => 'permission-product-canceled-order-show', 'description' => 'دسترسی به بخش نمایش سفارش باطل شده'];
    public const PERMISSION_CANCELED_ORDER_SHOW_DETAIL = ['name' => 'permission-product-canceled-order-detail', 'description' => 'دسترسی به بخش جزئیات سفارش باطل شده'];
    public const PERMISSION_CANCELED_ORDER_SHOW_PRINT = ['name' => 'permission-product-canceled-order-print', 'description' => 'دسترسی به بخش پرینت سفارش باطل شده'];
    public const PERMISSION_CANCELED_ORDER_CANCEL = ['name' => 'permission-product-canceled-order-cancel', 'description' => 'دسترسی به بخش باطل کردن سفارش باطل شده'];
    public const PERMISSION_CANCELED_ORDER_CHANGE_STATUS = ['name' => 'permission-product-canceled-order-status', 'description' => 'دسترسی به بخش تغییر وضعیت سفارش باطل شده'];
    public const PERMISSION_CANCELED_ORDER_CHANGE_SEND_STATUS = ['name' => 'permission-product-canceled-order-send-status', 'description' => 'دسترسی به بخش تغییر وضعیت ارسال سفارش باطل شده'];

    // 5- RETURNED ORDER
    public const PERMISSION_RETURNED_ORDERS = ['name' => 'permission-product-returned-orders', 'description' => 'دسترسی به بخش سفارشات مرجوعی'];
    public const PERMISSION_RETURNED_ORDER_SHOW = ['name' => 'permission-product-returned-order-show', 'description' => 'دسترسی به بخش نمایش سفارش مرجوعی'];
    public const PERMISSION_RETURNED_ORDER_SHOW_DETAIL = ['name' => 'permission-product-returned-order-detail', 'description' => 'دسترسی به بخش جزئیات سفارش مرجوعی'];
    public const PERMISSION_RETURNED_ORDER_SHOW_PRINT = ['name' => 'permission-product-returned-order-print', 'description' => 'دسترسی به بخش پرینت سفارش مرجوعی'];
    public const PERMISSION_RETURNED_ORDER_CANCEL = ['name' => 'permission-product-returned-order-cancel', 'description' => 'دسترسی به بخش باطل کردن سفارش مرجوعی'];
    public const PERMISSION_RETURNED_ORDER_CHANGE_STATUS = ['name' => 'permission-product-returned-order-status', 'description' => 'دسترسی به بخش تغییر وضعیت سفارش مرجوعی'];
    public const PERMISSION_RETURNED_ORDER_CHANGE_SEND_STATUS = ['name' => 'permission-product-returned-order-send-status', 'description' => 'دسترسی به بخش تغییر وضعیت ارسال سفارش مرجوعی'];

    // 6- ALL ORDER
    public const PERMISSION_ALL_ORDERS = ['name' => 'permission-product-all-orders', 'description' => 'دسترسی به بخش همه سفارشات'];
    public const PERMISSION_ORDER_SHOW = ['name' => 'permission-product-order-show', 'description' => 'دسترسی به بخش نمایش سفارش'];
    public const PERMISSION_ORDER_SHOW_DETAIL = ['name' => 'permission-product-order-detail', 'description' => 'دسترسی به بخش جزئیات سفارش'];
    public const PERMISSION_ORDER_SHOW_PRINT = ['name' => 'permission-product-order-print', 'description' => 'دسترسی به بخش پرینت سفارش'];
    public const PERMISSION_ORDER_CANCEL = ['name' => 'permission-product-order-cancel', 'description' => 'دسترسی به بخش باطل کردن سفارش'];
    public const PERMISSION_ORDER_CHANGE_STATUS = ['name' => 'permission-product-order-status', 'description' => 'دسترسی به بخش تغییر وضعیت سفارش'];
    public const PERMISSION_ORDER_CHANGE_SEND_STATUS = ['name' => 'permission-product-order-send-status', 'description' => 'دسترسی به بخش تغییر وضعیت ارسال سفارش'];

    // C. PAYMENT
    public const PERMISSION_PAYMENTS = ['name' => 'permission-product-payments', 'description' => 'دسترسی به بخش پرداخت ها'];

    // 1- ALL PAYMENT
    public const PERMISSION_ALL_PAYMENTS = ['name' => 'permission-product-all-payments', 'description' => 'دسترسی به بخش همه پرداخت ها'];
    public const PERMISSION_PAYMENT_SHOW = ['name' => 'permission-product-payment-show', 'description' => 'دسترسی به بخش نمایش پرداخت'];
    public const PERMISSION_PAYMENT_CANCEL = ['name' => 'permission-product-payment-cancel', 'description' => 'دسترسی به بخش باطل کردن پرداخت'];
    public const PERMISSION_PAYMENT_RETURN = ['name' => 'permission-product-payment-return', 'description' => 'دسترسی به بخش برگرداندن پرداخت'];

    // 2- ONLINE PAYMENT
    public const PERMISSION_ONLINE_PAYMENTS = ['name' => 'permission-product-online-payments', 'description' => 'دسترسی به بخش پرداخت های آنلاین'];
    public const PERMISSION_ONLINE_PAYMENT_SHOW = ['name' => 'permission-product-online-payment-show', 'description' => 'دسترسی به بخش نمایش پرداخت آنلاین'];
    public const PERMISSION_ONLINE_PAYMENT_CANCEL = ['name' => 'permission-product-online-payment-cancel', 'description' => 'دسترسی به بخش باطل کردن پرداخت آنلاین'];
    public const PERMISSION_ONLINE_PAYMENT_RETURN = ['name' => 'permission-product-online-payment-return', 'description' => 'دسترسی به بخش برگرداندن پرداخت آنلاین'];

    // 3- OFFLINE PAYMENT
    public const PERMISSION_OFFLINE_PAYMENTS = ['name' => 'permission-product-offline-payments', 'description' => 'دسترسی به بخش پرداخت های آفلاین'];
    public const PERMISSION_OFFLINE_PAYMENT_SHOW = ['name' => 'permission-product-offline-payment-show', 'description' => 'دسترسی به بخش نمایش پرداخت آفلاین'];
    public const PERMISSION_OFFLINE_PAYMENT_CANCEL = ['name' => 'permission-product-offline-payment-cancel', 'description' => 'دسترسی به بخش باطل کردن پرداخت آفلاین'];
    public const PERMISSION_OFFLINE_PAYMENT_RETURN = ['name' => 'permission-product-offline-payment-return', 'description' => 'دسترسی به بخش برگرداندن پرداخت آفلاین'];

    // 4- CASH PAYMENT
    public const PERMISSION_CASH_PAYMENTS = ['name' => 'permission-product-cash-payments', 'description' => 'دسترسی به بخش پرداخت های در محل'];
    public const PERMISSION_CASH_PAYMENT_SHOW = ['name' => 'permission-product-cash-payment-show', 'description' => 'دسترسی به بخش نمایش پرداخت در محل'];
    public const PERMISSION_CASH_PAYMENT_CANCEL = ['name' => 'permission-product-cash-payment-cancel', 'description' => 'دسترسی به بخش باطل کردن پرداخت در محل'];
    public const PERMISSION_CASH_PAYMENT_RETURN = ['name' => 'permission-product-cash-payment-return', 'description' => 'دسترسی به بخش برگرداندن پرداخت در محل'];

    // D. DISCOUNTS
    public const PERMISSION_DISCOUNTS = ['name' => 'permission-product-discounts', 'description' => 'دسترسی به بخش تخفبف ها'];

    // 1- COUPON
    public const PERMISSION_PRODUCT_COUPON_DISCOUNTS = ['name' => 'permission-product-coupon-discounts', 'description' => 'دسترسی به بخش کوپن های تخفبف'];
    public const PERMISSION_PRODUCT_COUPON_DISCOUNT_CREATE = ['name' => 'permission-product-coupon-discount-create', 'description' => 'دسترسی به بخش ایجاد کوپن تخفبف'];
    public const PERMISSION_PRODUCT_COUPON_DISCOUNT_EDIT = ['name' => 'permission-product-coupon-discount-edit', 'description' => 'دسترسی به بخش ویرایش کوپن تخفبف'];
    public const PERMISSION_PRODUCT_COUPON_DISCOUNT_DELETE = ['name' => 'permission-product-coupon-discount-delete', 'description' => 'دسترسی به بخش حذف کوپن تخفبف'];
    public const PERMISSION_PRODUCT_COUPON_DISCOUNT_STATUS = ['name' => 'permission-product-coupon-discount-status', 'description' => 'دسترسی به بخش تغییر وضعیت کوپن تخفبف'];

    // 2- COMMON
    public const PERMISSION_PRODUCT_COMMON_DISCOUNTS = ['name' => 'permission-product-common-discounts', 'description' => 'دسترسی به بخش تخفبفات عمومی'];
    public const PERMISSION_PRODUCT_COMMON_DISCOUNT_CREATE = ['name' => 'permission-product-common-discount-create', 'description' => 'دسترسی به بخش ایجاد تخفبف عمومی'];
    public const PERMISSION_PRODUCT_COMMON_DISCOUNT_EDIT = ['name' => 'permission-product-common-discount-edit', 'description' => 'دسترسی به بخش ویرایش تخفبف عمومی'];
    public const PERMISSION_PRODUCT_COMMON_DISCOUNT_DELETE = ['name' => 'permission-product-common-discount-delete', 'description' => 'دسترسی به بخش حذف تخفبف عمومی'];
    public const PERMISSION_PRODUCT_COMMON_DISCOUNT_STATUS = ['name' => 'permission-product-common-discount-status', 'description' => 'دسترسی به بخش تغییر وضعیت تخفبف عمومی'];

    // 3- AMAZING SALE
    public const PERMISSION_PRODUCT_AMAZING_SALES = ['name' => 'permission-product-amazing-sales', 'description' => 'دسترسی به بخش فروش شگفت انگیز محصولات'];
    public const PERMISSION_PRODUCT_AMAZING_SALE_CREATE = ['name' => 'permission-product-amazing-sale-create', 'description' => 'دسترسی به بخش ایجاد فروش شگفت انگیز برای محصول'];
    public const PERMISSION_PRODUCT_AMAZING_SALE_EDIT = ['name' => 'permission-product-amazing-sale-edit', 'description' => 'دسترسی به بخش ویرایش فروش شگفت انگیز برای محصول'];
    public const PERMISSION_PRODUCT_AMAZING_SALE_DELETE = ['name' => 'permission-product-amazing-sale-delete', 'description' => 'دسترسی به بخش حذف فروش شگفت انگیز برای محصول'];
    public const PERMISSION_PRODUCT_AMAZING_SALE_STATUS = ['name' => 'permission-product-amazing-sale-status', 'description' => 'دسترسی به بخش تغییر وضعیت فروش شگفت انگیز برای محصول'];

    // E. DELIVERY
    public const PERMISSION_DELIVERY_METHODS = ['name' => 'permission-delivery-methods', 'description' => 'دسترسی به بخش روش های ارسال کالا'];
    public const PERMISSION_DELIVERY_METHOD_CREATE = ['name' => 'permission-delivery-method-create', 'description' => 'دسترسی به بخش ایجاد روش ارسال کالا'];
    public const PERMISSION_DELIVERY_METHOD_EDIT = ['name' => 'permission-delivery-method-edit', 'description' => 'دسترسی به بخش ویرایش روش ارسال کالا'];
    public const PERMISSION_DELIVERY_METHOD_DELETE = ['name' => 'permission-delivery-method-delete', 'description' => 'دسترسی به بخش حذف روش ارسال کالا'];
    public const PERMISSION_DELIVERY_METHOD_STATUS = ['name' => 'permission-delivery-method-status', 'description' => 'دسترسی به بخش تغییر وضعیت روش ارسال کالا'];

    // Content Section Permissions
    //******************************************************************************************************************
    public const PERMISSION_CONTENT = ['name' => 'permission-content', 'description' => 'دسترسی به بخش محتوا'];

    // 1- post categories
    public const PERMISSION_POST_CATEGORIES = ['name' => 'permission-post-categories', 'description' => 'دسترسی به بخش دسته بندی پست ها'];
    public const PERMISSION_POST_CATEGORY_CREATE = ['name' => 'permission-post-category-create', 'description' => 'دسترسی به بخش ایجاد دسته بندی پست'];
    public const PERMISSION_POST_CATEGORY_EDIT = ['name' => 'permission-post-category-edit', 'description' => 'دسترسی به بخش ویرایش دسته بندی پست'];
    public const PERMISSION_POST_CATEGORY_DELETE = ['name' => 'permission-post-category-delete', 'description' => 'دسترسی به بخش حذف دسته بندی پست'];
    public const PERMISSION_POST_CATEGORY_STATUS = ['name' => 'permission-post-category-status', 'description' => 'دسترسی به بخش تغییر وضعیت دسته بندی پست'];

    // 2- post
    public const PERMISSION_POST = ['name' => 'permission-post', 'description' => 'دسترسی به بخش پست ها'];
    public const PERMISSION_POST_CREATE = ['name' => 'permission-post-create', 'description' => 'دسترسی به بخش ایجاد پست'];
    public const PERMISSION_POST_EDIT = ['name' => 'permission-post-edit', 'description' => 'دسترسی به بخش ویرایش پست'];
    public const PERMISSION_POST_DELETE = ['name' => 'permission-post-delete', 'description' => 'دسترسی به بخش حذف پست'];
    public const PERMISSION_POST_STATUS = ['name' => 'permission-post-status', 'description' => 'دسترسی به بخش تغییر وضعیت پست'];
    public const PERMISSION_POST_SET_TAGS = ['name' => 'permission-post-set-tags', 'description' => 'دسترسی به بخش افزودن تگ های پست'];
    public const PERMISSION_POST_UPDATE_TAGS = ['name' => 'permission-post-update-tags', 'description' => 'دسترسی به بخش ویرایش تگ های پست'];

    public const PERMISSION_POST_AUTHORS = ['name' => 'permission-authors', 'description' => 'دسترسی به بخش نویسندگان پست ها'];

    // 3- post comments
    public const PERMISSION_POST_COMMENTS = ['name' => 'permission-post-comments', 'description' => 'دسترسی به بخش نظرات پست'];
    public const PERMISSION_POST_COMMENT_STATUS = ['name' => 'permission-post-comment-status', 'description' => 'دسترسی به بخش ایجاد نظر برای پست'];
    public const PERMISSION_POST_COMMENT_SHOW = ['name' => 'permission-post-comment-show', 'description' => 'دسترسی به بخش نمایش نظر مربوط به پست'];
    public const PERMISSION_POST_COMMENT_APPROVE = ['name' => 'permission-post-comment-approve', 'description' => 'دسترسی به بخش تایید نظر مربوط به پست'];

    // 4- FAQS
    public const PERMISSION_FAQS = ['name' => 'permission-faqs', 'description' => 'دسترسی به بخش سوالات متداول'];
    public const PERMISSION_FAQ_CREATE = ['name' => 'permission-faq-create', 'description' => 'دسترسی به بخش ایجاد سوال متداول'];
    public const PERMISSION_FAQ_EDIT = ['name' => 'permission-faq-edit', 'description' => 'دسترسی به بخش ویرایش سوال متداول'];
    public const PERMISSION_FAQ_DELETE = ['name' => 'permission-faq-delete', 'description' => 'دسترسی به بخش ایجاد حذف متداول'];
    public const PERMISSION_FAQ_STATUS = ['name' => 'permission-faq-status', 'description' => 'دسترسی به بخش تغییر وضعیت سوال متداول'];

    // 5- PAGE
    public const PERMISSION_PAGES = ['name' => 'permission-pages', 'description' => 'دسترسی به بخش پیج ساز'];
    public const PERMISSION_PAGE_CREATE = ['name' => 'permission-page-create', 'description' => 'دسترسی به بخش ایجاد پیج'];
    public const PERMISSION_PAGE_EDIT = ['name' => 'permission-page-edit', 'description' => 'دسترسی به بخش ویرایش پیج'];
    public const PERMISSION_PAGE_DELETE = ['name' => 'permission-page-delete', 'description' => 'دسترسی به بخش حذف پیج'];
    public const PERMISSION_PAGE_STATUS = ['name' => 'permission-page-status', 'description' => 'دسترسی به بخش تغییر وضعیت پیج'];

    // 6- MENU
    public const PERMISSION_MENUS = ['name' => 'permission-menus', 'description' => 'دسترسی به بخش منوها'];
    public const PERMISSION_MENU_CREATE = ['name' => 'permission-menu-create', 'description' => 'دسترسی به بخش ایجاد منو'];
    public const PERMISSION_MENU_EDIT = ['name' => 'permission-menu-edit', 'description' => 'دسترسی به بخش ویرایش منو'];
    public const PERMISSION_MENU_DELETE = ['name' => 'permission-menu-delete', 'description' => 'دسترسی به بخش حذف منو'];
    public const PERMISSION_MENU_STATUS = ['name' => 'permission-menu-status', 'description' => 'دسترسی به بخش تغییر وضعیت منو'];

    // 7- BANNER
    public const PERMISSION_BANNERS = ['name' => 'permission-banners', 'description' => 'دسترسی به بخش بنرهای تبلیغی'];
    public const PERMISSION_BANNER_CREATE = ['name' => 'permission-banner-create', 'description' => 'دسترسی به بخش ایجاد بنر تبلیغی'];
    public const PERMISSION_BANNER_EDIT = ['name' => 'permission-banner-edit', 'description' => 'دسترسی به بخش ویرایش بنر تبلیغی'];
    public const PERMISSION_BANNER_DELETE = ['name' => 'permission-banner-delete', 'description' => 'دسترسی به بخش حذف بنر تبلیغی'];
    public const PERMISSION_BANNER_STATUS = ['name' => 'permission-banner-status', 'description' => 'دسترسی به بخش تغییر وضعیت بنر تبلیغی'];

    // 8- TAG
    public const PERMISSION_TAGS = ['name' => 'permission-tags', 'description' => 'دسترسی به بخش تگ ها'];
    public const PERMISSION_TAG_CREATE = ['name' => 'permission-tag-create', 'description' => 'دسترسی به بخش ایجاد تگ'];
    public const PERMISSION_TAG_EDIT = ['name' => 'permission-tag-edit', 'description' => 'دسترسی به بخش ویرایش تگ'];
    public const PERMISSION_TAG_DELETE = ['name' => 'permission-tag-delete', 'description' => 'دسترسی به بخش حذف تگ'];
    public const PERMISSION_TAG_STATUS = ['name' => 'permission-tag-status', 'description' => 'دسترسی به بخش تغییر وضعیت تگ'];

    // User Section Permissions
    //******************************************************************************************************************
    public const PERMISSION_USERS = ['name' => 'permission-users', 'description' => 'دسترسی به بخش کاربران'];

    // 1- admin users
    public const PERMISSION_ADMIN_USERS = ['name' => 'permission-admin-users', 'description' => 'دسترسی به بخش کاربران ادمین'];
    public const PERMISSION_ADMIN_USER_CREATE = ['name' => 'permission-admin-user-create', 'description' => 'دسترسی به بخش ایجاد کاربر ادمین'];
    public const PERMISSION_ADMIN_USER_EDIT = ['name' => 'permission-admin-user-edit', 'description' => 'دسترسی به بخش ویرایش کاربر ادمین'];
    public const PERMISSION_ADMIN_USER_DELETE = ['name' => 'permission-admin-user-delete', 'description' => 'دسترسی به بخش حذف کاربر ادمین'];
    public const PERMISSION_ADMIN_USER_STATUS = ['name' => 'permission-admin-user-status', 'description' => 'دسترسی به بخش تغییر وضعیت کاربر ادمین'];
    public const PERMISSION_ADMIN_USER_ROLES = ['name' => 'permission-admin-user-roles', 'description' => 'دسترسی به بخش نقش های کاربر ادمین'];
    public const PERMISSION_ADMIN_USER_ACTIVATION = ['name' => 'permission-admin-user-activation', 'description' => 'دسترسی به بخش فعال سازی کاربر ادمین'];

    // 2- CUSTOMER USER
    public const PERMISSION_CUSTOMER_USERS = ['name' => 'permission-customer-users', 'description' => 'دسترسی به بخش مشتریان'];
    public const PERMISSION_CUSTOMER_USER_CREATE = ['name' => 'permission-customer-user-create', 'description' => 'دسترسی به بخش ایجاد مشتری'];
    public const PERMISSION_CUSTOMER_USER_EDIT = ['name' => 'permission-customer-user-edit', 'description' => 'دسترسی به بخش ویرایش مشتری'];
    public const PERMISSION_CUSTOMER_USER_DELETE = ['name' => 'permission-customer-user-delete', 'description' => 'دسترسی به بخش حذف مشتری'];
    public const PERMISSION_CUSTOMER_USER_STATUS = ['name' => 'permission-customer-user-status', 'description' => 'دسترسی به بخش تغییر وضعیت مشتری'];
    public const PERMISSION_CUSTOMER_USER_ACTIVATION = ['name' => 'permission-customer-user-activation', 'description' => 'دسترسی به بخش نقش های مشتری'];
    public const PERMISSION_CUSTOMER_USER_ROLES = ['name' => 'permission-customer-user-roles', 'description' => 'دسترسی به بخش فعال سازی مشتری'];

    // 3- USER ROLES
    public const PERMISSION_USER_ROLES = ['name' => 'permission-user-roles', 'description' => 'دسترسی به بخش نقش ها'];
    public const PERMISSION_USER_ROLE_CREATE = ['name' => 'permission-user-role-create', 'description' => 'دسترسی به بخش ایجاد نقش'];
    public const PERMISSION_USER_ROLE_EDIT = ['name' => 'permission-user-role-edit', 'description' => 'دسترسی به بخش ویرایش نقش'];
    public const PERMISSION_USER_ROLE_DELETE = ['name' => 'permission-user-role-delete', 'description' => 'دسترسی به بخش حذف نقش'];
    public const PERMISSION_USER_ROLE_STATUS = ['name' => 'permission-user-role-status', 'description' => 'دسترسی به بخش تغییر وضعیت نقش'];
    public const PERMISSION_USER_ROLE_PERMISSIONS = ['name' => 'permission-user-role-permissions', 'description' => 'دسترسی به بخش افزودن سطوح دسترسی به نقش'];
    public const PERMISSION_USER_PERMISSIONS_IMPORT = ['name' => 'permission-user-permissions-import', 'description' => 'دسترسی به بخش بارگذاری سطوح دسترسی'];
    public const PERMISSION_USER_PERMISSIONS_EXPORT = ['name' => 'permission-user-permissions-export', 'description' => 'دسترسی به بخش خروجی فایل اکسل از سطوح دسترسی'];

    // TICKET Section Permissions
    //******************************************************************************************************************
    public const PERMISSION_TICKETS = ['name' => 'permission-tickets', 'description' => 'دسترسی به بخش تیکت ها'];

    // 1- TICKET CATEGORY
    public const PERMISSION_TICKET_CATEGORIES = ['name' => 'permission-ticket-categories', 'description' => 'دسترسی به بخش دسته بندی تیکت ها'];
    public const PERMISSION_TICKET_CATEGORY_CREATE = ['name' => 'permission-ticket-category-create', 'description' => 'دسترسی به بخش ایجاد دسته بندی تیکت'];
    public const PERMISSION_TICKET_CATEGORY_EDIT = ['name' => 'permission-ticket-category-edit', 'description' => 'دسترسی به بخش ویرایش دسته بندی تیکت'];
    public const PERMISSION_TICKET_CATEGORY_DELETE = ['name' => 'permission-ticket-category-delete', 'description' => 'دسترسی به بخش حذف دسته بندی تیکت'];
    public const PERMISSION_TICKET_CATEGORY_STATUS = ['name' => 'permission-ticket-category-status', 'description' => 'دسترسی به بخش تغییر وضعیت دسته بندی تیکت'];

    // 2- TICKET PRIORITY
    public const PERMISSION_TICKET_PRIORITIES = ['name' => 'permission-ticket-priorities', 'description' => 'دسترسی به بخش اولویت تیکت ها'];
    public const PERMISSION_TICKET_PRIORITY_CREATE = ['name' => 'permission-ticket-priority-create', 'description' => 'دسترسی به بخش ایجاد اولویت تیکت'];
    public const PERMISSION_TICKET_PRIORITY_EDIT = ['name' => 'permission-ticket-priority-edit', 'description' => 'دسترسی به بخش ویرایش اولویت تیکت'];
    public const PERMISSION_TICKET_PRIORITY_DELETE = ['name' => 'permission-ticket-priority-delete', 'description' => 'دسترسی به بخش حذف اولویت تیکت'];
    public const PERMISSION_TICKET_PRIORITY_STATUS = ['name' => 'permission-ticket-priority-status', 'description' => 'دسترسی به بخش تغییر وضعیت اولویت تیکت'];

    // 3- ADMIN TICKET
    public const PERMISSION_ADMIN_TICKETS = ['name' => 'permission-admin-tickets', 'description' => 'دسترسی به بخش ادمین های تیکت'];
    public const PERMISSION_ADMIN_TICKET_ADD = ['name' => 'permission-admin-ticket-add', 'description' => 'دسترسی به بخش افزودن ادمین به عنوان ادمین تیکت'];

    // 4- NEW TICKET
    public const PERMISSION_NEW_TICKETS = ['name' => 'permission-new-tickets', 'description' => 'دسترسی به بخش تیکت های جدید'];
    public const PERMISSION_NEW_TICKET_SHOW = ['name' => 'permission-new-ticket-show', 'description' => 'دسترسی به بخش مشاهده تیکت جدید'];
    public const PERMISSION_NEW_TICKET_CHANGE = ['name' => 'permission-new-ticket-change', 'description' => 'دسترسی به بخش تغییر وضعیت تیکت جدید'];

    // 5- OPEN TICKET
    public const PERMISSION_OPEN_TICKETS = ['name' => 'permission-open-tickets', 'description' => 'دسترسی به بخش تیکت های باز'];
    public const PERMISSION_OPEN_TICKET_SHOW = ['name' => 'permission-open-ticket-show', 'description' => 'دسترسی به بخش مشاهده تیکت باز'];
    public const PERMISSION_OPEN_TICKET_CHANGE = ['name' => 'permission-open-ticket-change', 'description' => 'دسترسی به بخش تغییر وضعیت تیکت باز'];


    // 6- CLOSE TICKETS
    public const PERMISSION_CLOSE_TICKETS = ['name' => 'permission-close-tickets', 'description' => 'دسترسی به بخش تیکت های بسته'];
    public const PERMISSION_CLOSE_TICKET_SHOW = ['name' => 'permission-close-ticket-show', 'description' => 'دسترسی به بخش مشاهده تیکت بسته'];
    public const PERMISSION_CLOSE_TICKET_CHANGE = ['name' => 'permission-close-ticket-change', 'description' => 'دسترسی به بخش تغییر وضعیت تیکت بسته'];

    // 7- ALL TICKET
    public const PERMISSION_ALL_TICKETS = ['name' => 'permission-all-tickets', 'description' => 'دسترسی به بخش همه تیکت ها'];
    public const PERMISSION_TICKET_SHOW = ['name' => 'permission-ticket-show', 'description' => 'دسترسی به بخش مشاهده تیکت'];
    public const PERMISSION_TICKET_CHANGE = ['name' => 'permission-ticket-change', 'description' => 'دسترسی به بخش تغییر وضعیت تیکت'];


    // NOTIFY Section Permissions
    //******************************************************************************************************************
    public const PERMISSION_NOTIFY = ['name' => 'permission-notify', 'description' => 'دسترسی به بخش اطلاع رسانی'];

    // 1- EMAIL NOTIFY
    public const PERMISSION_EMAIL_NOTIFY = ['name' => 'permission-email-notify', 'description' => 'دسترسی به بخش همه اطلاع رسانی های ایمیلی'];
    public const PERMISSION_EMAIL_NOTIFY_CREATE = ['name' => 'permission-email-notify-create', 'description' => 'دسترسی به بخش ایجاد اطلاع رسانی ایمیلی'];
    public const PERMISSION_EMAIL_NOTIFY_EDIT = ['name' => 'permission-email-notify-edit', 'description' => 'دسترسی به بخش ویرایش اطلاع رسانی ایمیلی'];
    public const PERMISSION_EMAIL_NOTIFY_DELETE = ['name' => 'permission-email-notify-delete', 'description' => 'دسترسی به بخش حذف اطلاع رسانی ایمیلی'];
    public const PERMISSION_EMAIL_NOTIFY_STATUS = ['name' => 'permission-email-notify-status', 'description' => 'دسترسی به بخش تغییر وضعیت اطلاع رسانی ایمیلی'];
    public const PERMISSION_EMAIL_NOTIFY_FILES = ['name' => 'permission-email-notify-files', 'description' => 'دسترسی به بخش فایل های ضمیمه شده اطلاع رسانی ایمیلی'];
    public const PERMISSION_EMAIL_NOTIFY_FILES_CREATE = ['name' => 'permission-email-notify-file-create', 'description' => 'دسترسی به بخش ایجاد فایل اطلاع رسانی ایمیلی'];
    public const PERMISSION_EMAIL_NOTIFY_FILES_EDIT = ['name' => 'permission-email-notify-file-edit', 'description' => 'دسترسی به بخش ویرایش فایل اطلاع رسانی ایمیلی'];
    public const PERMISSION_EMAIL_NOTIFY_FILES_DELETE = ['name' => 'permission-email-notify-file-delete', 'description' => 'دسترسی به بخش حذف فایل اطلاع رسانی ایمیلی'];
    public const PERMISSION_EMAIL_NOTIFY_FILES_STATUS = ['name' => 'permission-email-notify-file-status', 'description' => 'دسترسی به بخش تغییر وضعیت فایل اطلاع رسانی ایمیلی'];

    // 2- SMS NOTIFY
    public const PERMISSION_SMS_NOTIFY = ['name' => 'permission-sms-notify', 'description' => 'دسترسی به بخش همه اطلاع رسانی های پیامکی'];
    public const PERMISSION_SMS_NOTIFY_CREATE = ['name' => 'permission-sms-notify-create', 'description' => 'دسترسی به بخش ایجاد اطلاع رسانی پیامکی'];
    public const PERMISSION_SMS_NOTIFY_EDIT = ['name' => 'permission-sms-notify-edit', 'description' => 'دسترسی به بخش ویرایش اطلاع رسانی پیامکی'];
    public const PERMISSION_SMS_NOTIFY_DELETE = ['name' => 'permission-sms-notify-delete', 'description' => 'دسترسی به بخش حذف اطلاع رسانی پیامکی'];
    public const PERMISSION_SMS_NOTIFY_STATUS = ['name' => 'permission-sms-notify-status', 'description' => 'دسترسی به بخش تغییر وضعیت اطلاع رسانی پیامکی'];

    // SETTING Section Permissions
    //******************************************************************************************************************
    public const PERMISSION_SETTING = ['name' => 'permission-setting', 'description' => 'دسترسی به بخش تنطیمات سایت'];
    public const PERMISSION_SETTING_EDIT = ['name' => 'permission-setting-edit', 'description' => 'دسترسی به بخش ویرایش تنطیمات سایت'];

    // NOTIFY Section Permissions
    //******************************************************************************************************************
    public const PERMISSION_OFFICE = ['name' => 'permission-office', 'description' => 'دسترسی به بخش خدمات'];

    // 1- SERVICE categories
    public const PERMISSION_SERVICE_CATEGORIES = ['name' => 'permission-service-categories', 'description' => 'دسترسی به بخش دسته بندی سرویس ها'];
    public const PERMISSION_SERVICE_CATEGORY_CREATE = ['name' => 'permission-service-category-create', 'description' => 'دسترسی به بخش ایجاد دسته بندی سرویس'];
    public const PERMISSION_SERVICE_CATEGORY_EDIT = ['name' => 'permission-service-category-edit', 'description' => 'دسترسی به بخش ویرایش دسته بندی سرویس'];
    public const PERMISSION_SERVICE_CATEGORY_DELETE = ['name' => 'permission-service-category-delete', 'description' => 'دسترسی به بخش حذف دسته بندی سرویس'];
    public const PERMISSION_SERVICE_CATEGORY_STATUS = ['name' => 'permission-service-category-status', 'description' => 'دسترسی به بخش تغییر وضعیت دسته بندی سرویس'];

    // 2- SERVICES
    public const PERMISSION_SERVICES = ['name' => 'permission-service', 'description' => 'دسترسی به بخش سرویس ها'];
    public const PERMISSION_SERVICE_CREATE = ['name' => 'permission-service-create', 'description' => 'دسترسی به بخش ایجاد سرویس'];
    public const PERMISSION_SERVICE_EDIT = ['name' => 'permission-service-edit', 'description' => 'دسترسی به بخش ویرایش سرویس'];
    public const PERMISSION_SERVICE_DELETE = ['name' => 'permission-service-delete', 'description' => 'دسترسی به بخش حذف سرویس'];
    public const PERMISSION_SERVICE_STATUS = ['name' => 'permission-service-status', 'description' => 'دسترسی به بخش تغییر وضعیت سرویس'];

    // 3- SERVICE COMMENTS
    public const PERMISSION_SERVICE_COMMENTS = ['name' => 'permission-service-comments', 'description' => 'دسترسی به بخش نظرات سرویس'];
    public const PERMISSION_SERVICE_COMMENT_STATUS = ['name' => 'permission-service-comment-status', 'description' => 'دسترسی به بخش تغییر وضعیت نظر سرویس'];
    public const PERMISSION_SERVICE_COMMENT_SHOW = ['name' => 'permission-service-comment-show', 'description' => 'دسترسی به بخش نمایش نظر سرویس'];
    public const PERMISSION_SERVICE_COMMENT_APPROVE = ['name' => 'permission-service-comment-approve', 'description' => 'دسترسی به بخش تایید نظر سرویس'];
    //******************************************************************************************************************

    public static array $permissions = [
        self::PERMISSION_SUPER_ADMIN
        , self::PERMISSION_ADMIN_PANEL
        , self::PERMISSION_MARKET
        , self::PERMISSION_VITRINE
        , self::PERMISSION_PRODUCT_CATEGORIES
        , self::PERMISSION_PRODUCT_CATEGORY_CREATE
        , self::PERMISSION_PRODUCT_CATEGORY_EDIT
        , self::PERMISSION_PRODUCT_CATEGORY_DELETE
        , self::PERMISSION_PRODUCT_CATEGORY_STATUS
        , self::PERMISSION_PRODUCT_PROPERTIES
        , self::PERMISSION_PRODUCT_PROPERTY_CREATE
        , self::PERMISSION_PRODUCT_PROPERTY_EDIT
        , self::PERMISSION_PRODUCT_PROPERTY_DELETE
        , self::PERMISSION_PRODUCT_PROPERTY_STATUS
        , self::PERMISSION_PRODUCT_PROPERTY_ATTRIBUTES
        , self::PERMISSION_PRODUCT_PROPERTY_ATTRIBUTE_CREATE
        , self::PERMISSION_PRODUCT_PROPERTY_ATTRIBUTE_EDIT
        , self::PERMISSION_PRODUCT_PROPERTY_ATTRIBUTE_DELETE
        , self::PERMISSION_PRODUCT_PROPERTY_ATTRIBUTE_STATUS
        , self::PERMISSION_PRODUCT_BRANDS
        , self::PERMISSION_PRODUCT_BRAND_CREATE
        , self::PERMISSION_PRODUCT_BRAND_EDIT
        , self::PERMISSION_PRODUCT_BRAND_DELETE
        , self::PERMISSION_PRODUCT_BRAND_STATUS
        , self::PERMISSION_PRODUCTS
        , self::PERMISSION_PRODUCT_CREATE
        , self::PERMISSION_PRODUCT_EDIT
        , self::PERMISSION_PRODUCT_DELETE
        , self::PERMISSION_PRODUCT_STATUS
        , self::PERMISSION_PRODUCT_GALLERY
        , self::PERMISSION_PRODUCT_GALLERY_CREATE
        , self::PERMISSION_PRODUCT_GALLERY_DELETE
        , self::PERMISSION_PRODUCT_GUARANTEES
        , self::PERMISSION_PRODUCT_GUARANTEE_CREATE
        , self::PERMISSION_PRODUCT_GUARANTEE_DELETE
        , self::PERMISSION_PRODUCT_COLORS
        , self::PERMISSION_PRODUCT_COLOR_CREATE
        , self::PERMISSION_PRODUCT_COLOR_DELETE
        , self::PERMISSION_PRODUCT_WAREHOUSE
        , self::PERMISSION_PRODUCT_WAREHOUSE_ADD
        , self::PERMISSION_PRODUCT_WAREHOUSE_MODIFY
        , self::PERMISSION_PRODUCT_COMMENTS
        , self::PERMISSION_PRODUCT_COMMENT_SHOW
        , self::PERMISSION_PRODUCT_COMMENT_STATUS
        , self::PERMISSION_PRODUCT_COMMENT_APPROVE
        , self::PERMISSION_ORDERS
        , self::PERMISSION_NEW_ORDERS
        , self::PERMISSION_NEW_ORDER_SHOW
        , self::PERMISSION_NEW_ORDER_DETAIL
        , self::PERMISSION_NEW_ORDER_PRINT
        , self::PERMISSION_NEW_ORDER_CANCEL
        , self::PERMISSION_NEW_ORDER_CHANGE_STATUS
        , self::PERMISSION_NEW_ORDER_CHANGE_SEND_STATUS
        , self::PERMISSION_SENDING_ORDERS
        , self::PERMISSION_SENDING_ORDER_SHOW
        , self::PERMISSION_SENDING_ORDER_DETAIL
        , self::PERMISSION_SENDING_ORDER_PRINT
        , self::PERMISSION_SENDING_ORDER_CANCEL
        , self::PERMISSION_SENDING_ORDER_CHANGE_STATUS
        , self::PERMISSION_SENDING_ORDER_CHANGE_SEND_STATUS
        , self::PERMISSION_UNPAID_ORDERS
        , self::PERMISSION_UNPAID_ORDER_SHOW
        , self::PERMISSION_UNPAID_ORDER_SHOW_DETAIL
        , self::PERMISSION_UNPAID_ORDER_SHOW_PRINT
        , self::PERMISSION_UNPAID_ORDER_CANCEL
        , self::PERMISSION_UNPAID_ORDER_CHANGE_STATUS
        , self::PERMISSION_UNPAID_ORDER_CHANGE_SEND_STATUS
        , self::PERMISSION_CANCELED_ORDERS
        , self::PERMISSION_CANCELED_ORDER_SHOW
        , self::PERMISSION_CANCELED_ORDER_SHOW_DETAIL
        , self::PERMISSION_CANCELED_ORDER_SHOW_PRINT
        , self::PERMISSION_CANCELED_ORDER_CANCEL
        , self::PERMISSION_CANCELED_ORDER_CHANGE_STATUS
        , self::PERMISSION_CANCELED_ORDER_CHANGE_SEND_STATUS
        , self::PERMISSION_RETURNED_ORDERS
        , self::PERMISSION_RETURNED_ORDER_SHOW
        , self::PERMISSION_RETURNED_ORDER_SHOW_DETAIL
        , self::PERMISSION_RETURNED_ORDER_SHOW_PRINT
        , self::PERMISSION_RETURNED_ORDER_CANCEL
        , self::PERMISSION_RETURNED_ORDER_CHANGE_STATUS
        , self::PERMISSION_RETURNED_ORDER_CHANGE_SEND_STATUS
        , self::PERMISSION_ALL_ORDERS
        , self::PERMISSION_ORDER_SHOW
        , self::PERMISSION_ORDER_SHOW_DETAIL
        , self::PERMISSION_ORDER_SHOW_PRINT
        , self::PERMISSION_ORDER_CANCEL
        , self::PERMISSION_ORDER_CHANGE_STATUS
        , self::PERMISSION_ORDER_CHANGE_SEND_STATUS
        , self::PERMISSION_PAYMENTS
        , self::PERMISSION_ALL_PAYMENTS
        , self::PERMISSION_PAYMENT_SHOW
        , self::PERMISSION_PAYMENT_CANCEL
        , self::PERMISSION_PAYMENT_RETURN
        , self::PERMISSION_ONLINE_PAYMENTS
        , self::PERMISSION_ONLINE_PAYMENT_SHOW
        , self::PERMISSION_ONLINE_PAYMENT_CANCEL
        , self::PERMISSION_ONLINE_PAYMENT_RETURN
        , self::PERMISSION_OFFLINE_PAYMENTS
        , self::PERMISSION_OFFLINE_PAYMENT_SHOW
        , self::PERMISSION_OFFLINE_PAYMENT_CANCEL
        , self::PERMISSION_OFFLINE_PAYMENT_RETURN
        , self::PERMISSION_CASH_PAYMENTS
        , self::PERMISSION_CASH_PAYMENT_SHOW
        , self::PERMISSION_CASH_PAYMENT_CANCEL
        , self::PERMISSION_CASH_PAYMENT_RETURN
        , self::PERMISSION_DISCOUNTS
        , self::PERMISSION_PRODUCT_COUPON_DISCOUNTS
        , self::PERMISSION_PRODUCT_COUPON_DISCOUNT_CREATE
        , self::PERMISSION_PRODUCT_COUPON_DISCOUNT_EDIT
        , self::PERMISSION_PRODUCT_COUPON_DISCOUNT_DELETE
        , self::PERMISSION_PRODUCT_COUPON_DISCOUNT_STATUS
        , self::PERMISSION_PRODUCT_COMMON_DISCOUNTS
        , self::PERMISSION_PRODUCT_COMMON_DISCOUNT_CREATE
        , self::PERMISSION_PRODUCT_COMMON_DISCOUNT_EDIT
        , self::PERMISSION_PRODUCT_COMMON_DISCOUNT_DELETE
        , self::PERMISSION_PRODUCT_COMMON_DISCOUNT_STATUS
        , self::PERMISSION_PRODUCT_AMAZING_SALES
        , self::PERMISSION_PRODUCT_AMAZING_SALE_CREATE
        , self::PERMISSION_PRODUCT_AMAZING_SALE_EDIT
        , self::PERMISSION_PRODUCT_AMAZING_SALE_DELETE
        , self::PERMISSION_PRODUCT_AMAZING_SALE_STATUS
        , self::PERMISSION_DELIVERY_METHODS
        , self::PERMISSION_DELIVERY_METHOD_CREATE
        , self::PERMISSION_DELIVERY_METHOD_EDIT
        , self::PERMISSION_DELIVERY_METHOD_DELETE
        , self::PERMISSION_DELIVERY_METHOD_STATUS
        , self::PERMISSION_CONTENT
        , self::PERMISSION_POST_CATEGORIES
        , self::PERMISSION_POST_CATEGORY_CREATE
        , self::PERMISSION_POST_CATEGORY_EDIT
        , self::PERMISSION_POST_CATEGORY_DELETE
        , self::PERMISSION_POST_CATEGORY_STATUS
        , self::PERMISSION_POST
        , self::PERMISSION_POST_CREATE
        , self::PERMISSION_POST_EDIT
        , self::PERMISSION_POST_DELETE
        , self::PERMISSION_POST_STATUS
        , self::PERMISSION_POST_AUTHORS
        , self::PERMISSION_POST_COMMENTS
        , self::PERMISSION_POST_COMMENT_STATUS
        , self::PERMISSION_POST_COMMENT_SHOW
        , self::PERMISSION_POST_COMMENT_APPROVE
        , self::PERMISSION_FAQS
        , self::PERMISSION_FAQ_CREATE
        , self::PERMISSION_FAQ_EDIT
        , self::PERMISSION_FAQ_DELETE
        , self::PERMISSION_FAQ_STATUS
        , self::PERMISSION_PAGES
        , self::PERMISSION_PAGE_CREATE
        , self::PERMISSION_PAGE_EDIT
        , self::PERMISSION_PAGE_DELETE
        , self::PERMISSION_PAGE_STATUS
        , self::PERMISSION_MENUS
        , self::PERMISSION_MENU_CREATE
        , self::PERMISSION_MENU_EDIT
        , self::PERMISSION_MENU_DELETE
        , self::PERMISSION_MENU_STATUS
        , self::PERMISSION_BANNERS
        , self::PERMISSION_BANNER_CREATE
        , self::PERMISSION_BANNER_EDIT
        , self::PERMISSION_BANNER_DELETE
        , self::PERMISSION_BANNER_STATUS
        , self::PERMISSION_POST_SET_TAGS
        , self::PERMISSION_POST_UPDATE_TAGS
        , self::PERMISSION_TAGS
        , self::PERMISSION_TAG_CREATE
        , self::PERMISSION_TAG_EDIT
        , self::PERMISSION_TAG_DELETE
        , self::PERMISSION_TAG_STATUS
        , self::PERMISSION_USERS
        , self::PERMISSION_ADMIN_USERS
        , self::PERMISSION_ADMIN_USER_CREATE
        , self::PERMISSION_ADMIN_USER_EDIT
        , self::PERMISSION_ADMIN_USER_DELETE
        , self::PERMISSION_ADMIN_USER_STATUS
        , self::PERMISSION_ADMIN_USER_ROLES
        , self::PERMISSION_ADMIN_USER_ACTIVATION
        , self::PERMISSION_CUSTOMER_USERS
        , self::PERMISSION_CUSTOMER_USER_CREATE
        , self::PERMISSION_CUSTOMER_USER_EDIT
        , self::PERMISSION_CUSTOMER_USER_DELETE
        , self::PERMISSION_CUSTOMER_USER_STATUS
        , self::PERMISSION_CUSTOMER_USER_ACTIVATION
        , self::PERMISSION_CUSTOMER_USER_ROLES
        , self::PERMISSION_USER_ROLES
        , self::PERMISSION_USER_ROLE_CREATE
        , self::PERMISSION_USER_ROLE_EDIT
        , self::PERMISSION_USER_ROLE_DELETE
        , self::PERMISSION_USER_ROLE_STATUS
        , self::PERMISSION_USER_ROLE_PERMISSIONS
        , self::PERMISSION_USER_PERMISSIONS_IMPORT
        , self::PERMISSION_USER_PERMISSIONS_EXPORT
        , self::PERMISSION_TICKETS
        , self::PERMISSION_TICKET_CATEGORIES
        , self::PERMISSION_TICKET_CATEGORY_CREATE
        , self::PERMISSION_TICKET_CATEGORY_EDIT
        , self::PERMISSION_TICKET_CATEGORY_DELETE
        , self::PERMISSION_TICKET_CATEGORY_STATUS
        , self::PERMISSION_TICKET_PRIORITIES
        , self::PERMISSION_TICKET_PRIORITY_CREATE
        , self::PERMISSION_TICKET_PRIORITY_EDIT
        , self::PERMISSION_TICKET_PRIORITY_DELETE
        , self::PERMISSION_TICKET_PRIORITY_STATUS
        , self::PERMISSION_ADMIN_TICKETS
        , self::PERMISSION_ADMIN_TICKET_ADD
        , self::PERMISSION_NEW_TICKETS
        , self::PERMISSION_NEW_TICKET_SHOW
        , self::PERMISSION_NEW_TICKET_CHANGE
        , self::PERMISSION_OPEN_TICKETS
        , self::PERMISSION_OPEN_TICKET_SHOW
        , self::PERMISSION_OPEN_TICKET_CHANGE
        , self::PERMISSION_CLOSE_TICKETS
        , self::PERMISSION_CLOSE_TICKET_SHOW
        , self::PERMISSION_CLOSE_TICKET_CHANGE
        , self::PERMISSION_ALL_TICKETS
        , self::PERMISSION_TICKET_SHOW
        , self::PERMISSION_TICKET_CHANGE
        , self::PERMISSION_NOTIFY
        , self::PERMISSION_EMAIL_NOTIFY
        , self::PERMISSION_EMAIL_NOTIFY_CREATE
        , self::PERMISSION_EMAIL_NOTIFY_EDIT
        , self::PERMISSION_EMAIL_NOTIFY_DELETE
        , self::PERMISSION_EMAIL_NOTIFY_STATUS
        , self::PERMISSION_EMAIL_NOTIFY_FILES
        , self::PERMISSION_EMAIL_NOTIFY_FILES_CREATE
        , self::PERMISSION_EMAIL_NOTIFY_FILES_EDIT
        , self::PERMISSION_EMAIL_NOTIFY_FILES_DELETE
        , self::PERMISSION_EMAIL_NOTIFY_FILES_STATUS
        , self::PERMISSION_SMS_NOTIFY
        , self::PERMISSION_SMS_NOTIFY_CREATE
        , self::PERMISSION_SMS_NOTIFY_EDIT
        , self::PERMISSION_SMS_NOTIFY_DELETE
        , self::PERMISSION_SMS_NOTIFY_STATUS
        , self::PERMISSION_SETTING
        , self::PERMISSION_SETTING_EDIT
        , self::PERMISSION_OFFICE
        , self::PERMISSION_SERVICE_CATEGORIES
        , self::PERMISSION_SERVICE_CATEGORY_CREATE
        , self::PERMISSION_SERVICE_CATEGORY_EDIT
        , self::PERMISSION_SERVICE_CATEGORY_DELETE
        , self::PERMISSION_SERVICE_CATEGORY_STATUS
        , self::PERMISSION_SERVICES
        , self::PERMISSION_SERVICE_CREATE
        , self::PERMISSION_SERVICE_EDIT
        , self::PERMISSION_SERVICE_DELETE
        , self::PERMISSION_SERVICE_STATUS
        , self::PERMISSION_SERVICE_COMMENTS
        , self::PERMISSION_SERVICE_COMMENT_STATUS
        , self::PERMISSION_SERVICE_COMMENT_SHOW
        , self::PERMISSION_SERVICE_COMMENT_APPROVE
    ];

    //relations
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    // methods

    public function rolesCount(): int
    {
        return $this->roles->count() ?? 0;
    }

    public function usersCount(): int
    {
        return $this->users->count() ?? 0;
    }

    public function textName()
    {
        foreach (self::$permissions as $permission) {
            if ($this->name == $permission['name']) {
                return $permission['description'];
            }
        }
        return 'سطح دسترسی یافت نشد.';
    }
}
