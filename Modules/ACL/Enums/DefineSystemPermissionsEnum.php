<?php

namespace Modules\ACL\Enums;

enum DefineSystemPermissionsEnum: string
{
    // access everywhere
    //******************************************************************************************************************
    case PERMISSION_SUPER_ADMIN = 'permission-super-admin';

    // access to each panels
    //******************************************************************************************************************
    case PERMISSION_ADMIN_PANEL = 'permission-admin-panel';

    // Market section Permissions
    //******************************************************************************************************************
    case PERMISSION_MARKET = 'permission-market';

    // A. Vitrine
    case PERMISSION_VITRINE = 'permission-vitrine';

    // 1- product category
    case PERMISSION_PRODUCT_CATEGORIES = 'permission-product-categories';
    case PERMISSION_PRODUCT_CATEGORY_CREATE = 'permission-product-category-create';
    case PERMISSION_PRODUCT_CATEGORY_EDIT = 'permission-product-category-edit';
    case PERMISSION_PRODUCT_CATEGORY_DELETE = 'permission-product-category-delete';
    case PERMISSION_PRODUCT_CATEGORY_STATUS = 'permission-product-category-status';

    // 2- PRODUCT PROPERTY
    case PERMISSION_PRODUCT_PROPERTIES = 'permission-product-properties';
    case PERMISSION_PRODUCT_PROPERTY_CREATE = 'permission-product-property-create';
    case PERMISSION_PRODUCT_PROPERTY_EDIT = 'permission-product-property-edit';
    case PERMISSION_PRODUCT_PROPERTY_DELETE = 'permission-product-property-delete';
    case PERMISSION_PRODUCT_PROPERTY_STATUS = 'permission-product-property-status';
    case PERMISSION_PRODUCT_PROPERTY_VALUES = 'permission-product-property-values';
    case PERMISSION_PRODUCT_PROPERTY_VALUE_CREATE = 'permission-product-property-value-create';
    case PERMISSION_PRODUCT_PROPERTY_VALUE_EDIT = 'permission-product-property-value-edit';
    case PERMISSION_PRODUCT_PROPERTY_VALUE_DELETE = 'permission-product-property-value-delete';
    case PERMISSION_PRODUCT_PROPERTY_VALUE_STATUS = 'permission-product-property-value-status';

    // 3- PRODUCT BRAND
    case PERMISSION_PRODUCT_BRANDS = 'permission-product-brands';
    case PERMISSION_PRODUCT_BRAND_CREATE = 'permission-product-brand-create';
    case PERMISSION_PRODUCT_BRAND_EDIT = 'permission-product-brand-edit';
    case PERMISSION_PRODUCT_BRAND_DELETE = 'permission-product-brand-delete';
    case PERMISSION_PRODUCT_BRAND_STATUS = 'permission-product-brand-status';

    // 4- PRODUCT
    case PERMISSION_PRODUCTS = 'permission-products';
    case PERMISSION_PRODUCT_CREATE = 'permission-product-create';
    case PERMISSION_PRODUCT_EDIT = 'permission-product-edit';
    case PERMISSION_PRODUCT_DELETE = 'permission-product-delete';
    case PERMISSION_PRODUCT_STATUS = 'permission-product-status';
    case PERMISSION_PRODUCT_GALLERY = 'permission-product-gallery';
    case PERMISSION_PRODUCT_GALLERY_CREATE = 'permission-product-gallery-create';
    case PERMISSION_PRODUCT_GALLERY_DELETE = 'permission-product-gallery-delete';
    case PERMISSION_PRODUCT_GUARANTEES = 'permission-product-guarantees';
    case PERMISSION_PRODUCT_GUARANTEE_CREATE = 'permission-product-guarantee-create';
    case PERMISSION_PRODUCT_GUARANTEE_DELETE = 'permission-product-guarantee-delete';
    case PERMISSION_PRODUCT_COLORS = 'permission-product-colors';
    case PERMISSION_PRODUCT_COLOR_CREATE = 'permission-product-color-create';
    case PERMISSION_PRODUCT_COLOR_DELETE = 'permission-product-color-delete';

    // 5- WAREHOUSE
    case PERMISSION_PRODUCT_WAREHOUSE = 'permission-product-warehouse';
    case PERMISSION_PRODUCT_WAREHOUSE_ADD = 'permission-product-warehouse-add';
    case PERMISSION_PRODUCT_WAREHOUSE_MODIFY = 'permission-product-warehouse-modify';

    // 6- PRODUCT COMMENT
    case PERMISSION_PRODUCT_COMMENTS = 'permission-product-comments';
    case PERMISSION_PRODUCT_COMMENT_SHOW = 'permission-product-comment-show';
    case PERMISSION_PRODUCT_COMMENT_STATUS = 'permission-product-comment-status';
    case PERMISSION_PRODUCT_COMMENT_APPROVE = 'permission-product-comment-approve';


    // B. ORDER
    case PERMISSION_ORDERS = 'permission-product-orders';
    // 1- NEW ORDER
    case PERMISSION_NEW_ORDERS = 'permission-product-new-orders';
    case PERMISSION_NEW_ORDER_SHOW = 'permission-product-new-order-show';
    case PERMISSION_NEW_ORDER_DETAIL = 'permission-product-new-order-detail';
    case PERMISSION_NEW_ORDER_PRINT = 'permission-product-new-order-print';
    case PERMISSION_NEW_ORDER_CANCEL = 'permission-product-new-order-cancel';
    case PERMISSION_NEW_ORDER_CHANGE_STATUS = 'permission-product-new-order-status';
    case PERMISSION_NEW_ORDER_CHANGE_SEND_STATUS = 'permission-product-new-order-send-status';

    // 2- SENDING ORDER
    case PERMISSION_SENDING_ORDERS = 'permission-product-sending-orders';
    case PERMISSION_SENDING_ORDER_SHOW = 'permission-product-sending-order-show';
    case PERMISSION_SENDING_ORDER_DETAIL = 'permission-product-sending-order-detail';
    case PERMISSION_SENDING_ORDER_PRINT = 'permission-product-sending-order-print';
    case PERMISSION_SENDING_ORDER_CANCEL = 'permission-product-sending-order-cancel';
    case PERMISSION_SENDING_ORDER_CHANGE_STATUS = 'permission-product-sending-order-status';
    case PERMISSION_SENDING_ORDER_CHANGE_SEND_STATUS = 'permission-product-sending-order-send-status';

    // 3- UNPAID ORDER
    case PERMISSION_UNPAID_ORDERS = 'permission-product-unpaid-orders';
    case PERMISSION_UNPAID_ORDER_SHOW = 'permission-product-unpaid-order-show';
    case PERMISSION_UNPAID_ORDER_SHOW_DETAIL = 'permission-product-unpaid-order-detail';
    case PERMISSION_UNPAID_ORDER_SHOW_PRINT = 'permission-product-unpaid-order-print';
    case PERMISSION_UNPAID_ORDER_CANCEL = 'permission-product-unpaid-order-cancel';
    case PERMISSION_UNPAID_ORDER_CHANGE_STATUS = 'permission-product-unpaid-order-status';
    case PERMISSION_UNPAID_ORDER_CHANGE_SEND_STATUS = 'permission-product-unpaid-order-send-status';

    // 4- CANCELED ORDER
    case PERMISSION_CANCELED_ORDERS = 'permission-product-canceled-orders';
    case PERMISSION_CANCELED_ORDER_SHOW = 'permission-product-canceled-order-show';
    case PERMISSION_CANCELED_ORDER_SHOW_DETAIL = 'permission-product-canceled-order-detail';
    case PERMISSION_CANCELED_ORDER_SHOW_PRINT = 'permission-product-canceled-order-print';
    case PERMISSION_CANCELED_ORDER_CANCEL = 'permission-product-canceled-order-cancel';
    case PERMISSION_CANCELED_ORDER_CHANGE_STATUS = 'permission-product-canceled-order-status';
    case PERMISSION_CANCELED_ORDER_CHANGE_SEND_STATUS = 'permission-product-canceled-order-send-status';

    // 5- RETURNED ORDER
    case PERMISSION_RETURNED_ORDERS = 'permission-product-returned-orders';
    case PERMISSION_RETURNED_ORDER_SHOW = 'permission-product-returned-order-show';
    case PERMISSION_RETURNED_ORDER_SHOW_DETAIL = 'permission-product-returned-order-detail';
    case PERMISSION_RETURNED_ORDER_SHOW_PRINT = 'permission-product-returned-order-print';
    case PERMISSION_RETURNED_ORDER_CANCEL = 'permission-product-returned-order-cancel';
    case PERMISSION_RETURNED_ORDER_CHANGE_STATUS = 'permission-product-returned-order-status';
    case PERMISSION_RETURNED_ORDER_CHANGE_SEND_STATUS = 'permission-product-returned-order-send-status';

    // 6- ALL ORDER
    case PERMISSION_ALL_ORDERS = 'permission-product-all-orders';
    case PERMISSION_ORDER_SHOW = 'permission-product-order-show';
    case PERMISSION_ORDER_SHOW_DETAIL = 'permission-product-order-detail';
    case PERMISSION_ORDER_SHOW_PRINT = 'permission-product-order-print';
    case PERMISSION_ORDER_CANCEL = 'permission-product-order-cancel';
    case PERMISSION_ORDER_CHANGE_STATUS = 'permission-product-order-status';
    case PERMISSION_ORDER_CHANGE_SEND_STATUS = 'permission-product-order-send-status';

    // C. PAYMENT
    case PERMISSION_PAYMENTS = 'permission-product-payments';

    // 1- ALL PAYMENT
    case PERMISSION_ALL_PAYMENTS = 'permission-product-all-payments';
    case PERMISSION_PAYMENT_SHOW = 'permission-product-payment-show';
    case PERMISSION_PAYMENT_CANCEL = 'permission-product-payment-cancel';
    case PERMISSION_PAYMENT_RETURN = 'permission-product-payment-return';

    // 2- ONLINE PAYMENT
    case PERMISSION_ONLINE_PAYMENTS = 'permission-product-online-payments';
    case PERMISSION_ONLINE_PAYMENT_SHOW = 'permission-product-online-payment-show';
    case PERMISSION_ONLINE_PAYMENT_CANCEL = 'permission-product-online-payment-cancel';
    case PERMISSION_ONLINE_PAYMENT_RETURN = 'permission-product-online-payment-return';

    // 3- OFFLINE PAYMENT
    case PERMISSION_OFFLINE_PAYMENTS = 'permission-product-offline-payments';
    case PERMISSION_OFFLINE_PAYMENT_SHOW = 'permission-product-offline-payment-show';
    case PERMISSION_OFFLINE_PAYMENT_CANCEL = 'permission-product-offline-payment-cancel';
    case PERMISSION_OFFLINE_PAYMENT_RETURN = 'permission-product-offline-payment-return';

    // 4- CASH PAYMENT
    case PERMISSION_CASH_PAYMENTS = 'permission-product-cash-payments';
    case PERMISSION_CASH_PAYMENT_SHOW = 'permission-product-cash-payment-show';
    case PERMISSION_CASH_PAYMENT_CANCEL = 'permission-product-cash-payment-cancel';
    case PERMISSION_CASH_PAYMENT_RETURN = 'permission-product-cash-payment-return';

    // D. DISCOUNTS
    case PERMISSION_DISCOUNTS = 'permission-product-discounts';

    // 1- COUPON
    case PERMISSION_PRODUCT_COUPON_DISCOUNTS = 'permission-product-coupon-discounts';
    case PERMISSION_PRODUCT_COUPON_DISCOUNT_CREATE = 'permission-product-coupon-discount-create';
    case PERMISSION_PRODUCT_COUPON_DISCOUNT_EDIT = 'permission-product-coupon-discount-edit';
    case PERMISSION_PRODUCT_COUPON_DISCOUNT_DELETE = 'permission-product-coupon-discount-delete';
    case PERMISSION_PRODUCT_COUPON_DISCOUNT_STATUS = 'permission-product-coupon-discount-status';

    // 2- COMMON
    case PERMISSION_PRODUCT_COMMON_DISCOUNTS = 'permission-product-common-discounts';
    case PERMISSION_PRODUCT_COMMON_DISCOUNT_CREATE = 'permission-product-common-discount-create';
    case PERMISSION_PRODUCT_COMMON_DISCOUNT_EDIT = 'permission-product-common-discount-edit';
    case PERMISSION_PRODUCT_COMMON_DISCOUNT_DELETE = 'permission-product-common-discount-delete';
    case PERMISSION_PRODUCT_COMMON_DISCOUNT_STATUS = 'permission-product-common-discount-status';

    // 3- AMAZING SALE
    case PERMISSION_PRODUCT_AMAZING_SALES = 'permission-product-amazing-sales';
    case PERMISSION_PRODUCT_AMAZING_SALE_CREATE = 'permission-product-amazing-sale-create';
    case PERMISSION_PRODUCT_AMAZING_SALE_EDIT = 'permission-product-amazing-sale-edit';
    case PERMISSION_PRODUCT_AMAZING_SALE_DELETE = 'permission-product-amazing-sale-delete';
    case PERMISSION_PRODUCT_AMAZING_SALE_STATUS = 'permission-product-amazing-sale-status';

    // E. DELIVERY
    case PERMISSION_DELIVERY_METHODS = 'permission-delivery-methods';
    case PERMISSION_DELIVERY_METHOD_CREATE = 'permission-delivery-method-create';
    case PERMISSION_DELIVERY_METHOD_EDIT = 'permission-delivery-method-edit';
    case PERMISSION_DELIVERY_METHOD_DELETE = 'permission-delivery-method-delete';
    case PERMISSION_DELIVERY_METHOD_STATUS = 'permission-delivery-method-status';

    // Content Section Permissions
    //******************************************************************************************************************
    case PERMISSION_CONTENT = 'permission-content';

    // 1- post categories
    case PERMISSION_POST_CATEGORIES = 'permission-post-categories';
    case PERMISSION_POST_CATEGORY_CREATE = 'permission-post-category-create';
    case PERMISSION_POST_CATEGORY_EDIT = 'permission-post-category-edit';
    case PERMISSION_POST_CATEGORY_DELETE = 'permission-post-category-delete';
    case PERMISSION_POST_CATEGORY_STATUS = 'permission-post-category-status';

    // 2- post
    case PERMISSION_POST = 'permission-post';
    case PERMISSION_POST_CREATE = 'permission-post-create';
    case PERMISSION_POST_EDIT = 'permission-post-edit';
    case PERMISSION_POST_DELETE = 'permission-post-delete';
    case PERMISSION_POST_STATUS = 'permission-post-status';
    case PERMISSION_POST_SET_TAGS = 'permission-post-set-tags';
    case PERMISSION_POST_UPDATE_TAGS = 'permission-post-update-tags';

    case PERMISSION_POST_AUTHORS = 'permission-authors';

    // 3- post comments
    case PERMISSION_POST_COMMENTS = 'permission-post-comments';
    case PERMISSION_POST_COMMENT_STATUS = 'permission-post-comment-status';
    case PERMISSION_POST_COMMENT_SHOW = 'permission-post-comment-show';
    case PERMISSION_POST_COMMENT_APPROVE = 'permission-post-comment-approve';
    // 4- FAQS
    case PERMISSION_FAQS = 'permission-faqs';
    case PERMISSION_FAQ_CREATE = 'permission-faq-create';
    case PERMISSION_FAQ_EDIT = 'permission-faq-edit';
    case PERMISSION_FAQ_DELETE = 'permission-faq-delete';
    case PERMISSION_FAQ_STATUS = 'permission-faq-status';

    // 5- PAGE
    case PERMISSION_PAGES = 'permission-pages';
    case PERMISSION_PAGE_CREATE = 'permission-page-create';
    case PERMISSION_PAGE_EDIT = 'permission-page-edit';
    case PERMISSION_PAGE_DELETE = 'permission-page-delete';
    case PERMISSION_PAGE_STATUS = 'permission-page-status';

    // 6- MENU
    case PERMISSION_MENUS = 'permission-menus';
    case PERMISSION_MENU_CREATE = 'permission-menu-create';
    case PERMISSION_MENU_EDIT = 'permission-menu-edit';
    case PERMISSION_MENU_DELETE = 'permission-menu-delete';
    case PERMISSION_MENU_STATUS = 'permission-menu-status';

    // 7- BANNER
    case PERMISSION_BANNERS = 'permission-banners';
    case PERMISSION_BANNER_CREATE = 'permission-banner-create';
    case PERMISSION_BANNER_EDIT = 'permission-banner-edit';
    case PERMISSION_BANNER_DELETE = 'permission-banner-delete';
    case PERMISSION_BANNER_STATUS = 'permission-banner-status';

    // 8- TAG
    case PERMISSION_TAGS = 'permission-tags';
    case PERMISSION_TAG_CREATE = 'permission-tag-create';
    case PERMISSION_TAG_EDIT = 'permission-tag-edit';
    case PERMISSION_TAG_DELETE = 'permission-tag-delete';
    case PERMISSION_TAG_STATUS = 'permission-tag-status';

    // User Section Permissions
    //******************************************************************************************************************
    case PERMISSION_USERS = 'permission-users';

    // 1- admin users
    case PERMISSION_ADMIN_USERS = 'permission-admin-users';
    case PERMISSION_ADMIN_USER_CREATE = 'permission-admin-user-create';
    case PERMISSION_ADMIN_USER_EDIT = 'permission-admin-user-edit';
    case PERMISSION_ADMIN_USER_DELETE = 'permission-admin-user-delete';
    case PERMISSION_ADMIN_USER_STATUS = 'permission-admin-user-status';
    case PERMISSION_ADMIN_USER_ROLES = 'permission-admin-user-roles';
    case PERMISSION_ADMIN_USER_ACTIVATION = 'permission-admin-user-activation';

    // 2- CUSTOMER USER
    case PERMISSION_CUSTOMER_USERS = 'permission-customer-users';
    case PERMISSION_CUSTOMER_USER_CREATE = 'permission-customer-user-create';
    case PERMISSION_CUSTOMER_USER_EDIT = 'permission-customer-user-edit';
    case PERMISSION_CUSTOMER_USER_DELETE = 'permission-customer-user-delete';
    case PERMISSION_CUSTOMER_USER_STATUS = 'permission-customer-user-status';
    case PERMISSION_CUSTOMER_USER_ACTIVATION = 'permission-customer-user-activation';
    case PERMISSION_CUSTOMER_USER_ROLES = 'permission-customer-user-roles';

    // 3- USER ROLES
    case PERMISSION_USER_ROLES = 'permission-user-roles';
    case PERMISSION_USER_ROLE_CREATE = 'permission-user-role-create';
    case PERMISSION_USER_ROLE_EDIT = 'permission-user-role-edit';
    case PERMISSION_USER_ROLE_DELETE = 'permission-user-role-delete';
    case PERMISSION_USER_ROLE_STATUS = 'permission-user-role-status';
    case PERMISSION_USER_ROLE_PERMISSIONS = 'permission-user-role-permissions';
    case PERMISSION_USER_PERMISSIONS_IMPORT = 'permission-user-permissions-import';
    case PERMISSION_USER_PERMISSIONS_EXPORT = 'permission-user-permissions-export';

    // TICKET Section Permissions
    //******************************************************************************************************************
    case PERMISSION_TICKETS = 'permission-tickets';

    // 1- TICKET CATEGORY
    case PERMISSION_TICKET_CATEGORIES = 'permission-ticket-categories';
    case PERMISSION_TICKET_CATEGORY_CREATE = 'permission-ticket-category-create';
    case PERMISSION_TICKET_CATEGORY_EDIT = 'permission-ticket-category-edit';
    case PERMISSION_TICKET_CATEGORY_DELETE = 'permission-ticket-category-delete';
    case PERMISSION_TICKET_CATEGORY_STATUS = 'permission-ticket-category-status';

    // 2- TICKET PRIORITY
    case PERMISSION_TICKET_PRIORITIES = 'permission-ticket-priorities';
    case PERMISSION_TICKET_PRIORITY_CREATE = 'permission-ticket-priority-create';
    case PERMISSION_TICKET_PRIORITY_EDIT = 'permission-ticket-priority-edit';
    case PERMISSION_TICKET_PRIORITY_DELETE = 'permission-ticket-priority-delete';
    case PERMISSION_TICKET_PRIORITY_STATUS = 'permission-ticket-priority-status';

    // 3- ADMIN TICKET
    case PERMISSION_ADMIN_TICKETS = 'permission-admin-tickets';
    case PERMISSION_ADMIN_TICKET_ADD = 'permission-admin-ticket-add';

    // 4- NEW TICKET
    case PERMISSION_NEW_TICKETS = 'permission-new-tickets';
    case PERMISSION_NEW_TICKET_SHOW = 'permission-new-ticket-show';
    case PERMISSION_NEW_TICKET_CHANGE = 'permission-new-ticket-change';

    // 5- OPEN TICKET
    case PERMISSION_OPEN_TICKETS = 'permission-open-tickets';
    case PERMISSION_OPEN_TICKET_SHOW = 'permission-open-ticket-show';
    case PERMISSION_OPEN_TICKET_CHANGE = 'permission-open-ticket-change';


    // 6- CLOSE TICKETS
    case PERMISSION_CLOSE_TICKETS = 'permission-close-tickets';
    case PERMISSION_CLOSE_TICKET_SHOW = 'permission-close-ticket-show';
    case PERMISSION_CLOSE_TICKET_CHANGE = 'permission-close-ticket-change';

    // 7- ALL TICKET
    case PERMISSION_ALL_TICKETS = 'permission-all-tickets';
    case PERMISSION_TICKET_SHOW = 'permission-ticket-show';
    case PERMISSION_TICKET_CHANGE = 'permission-ticket-change';


    // NOTIFY Section Permissions
    //******************************************************************************************************************
    case PERMISSION_NOTIFY = 'permission-notify';

    // 1- EMAIL NOTIFY
    case PERMISSION_EMAIL_NOTIFY = 'permission-email-notify';
    case PERMISSION_EMAIL_NOTIFY_CREATE = 'permission-email-notify-create';
    case PERMISSION_EMAIL_NOTIFY_EDIT = 'permission-email-notify-edit';
    case PERMISSION_EMAIL_NOTIFY_DELETE = 'permission-email-notify-delete';
    case PERMISSION_EMAIL_NOTIFY_STATUS = 'permission-email-notify-status';
    case PERMISSION_EMAIL_NOTIFY_FILES = 'permission-email-notify-files';
    case PERMISSION_EMAIL_NOTIFY_FILES_CREATE = 'permission-email-notify-file-create';
    case PERMISSION_EMAIL_NOTIFY_FILES_EDIT = 'permission-email-notify-file-edit';
    case PERMISSION_EMAIL_NOTIFY_FILES_DELETE = 'permission-email-notify-file-delete';
    case PERMISSION_EMAIL_NOTIFY_FILES_STATUS = 'permission-email-notify-file-status';

    // 2- SMS NOTIFY
    case PERMISSION_SMS_NOTIFY = 'permission-sms-notify';
    case PERMISSION_SMS_NOTIFY_CREATE = 'permission-sms-notify-create';
    case PERMISSION_SMS_NOTIFY_EDIT = 'permission-sms-notify-edit';
    case PERMISSION_SMS_NOTIFY_DELETE = 'permission-sms-notify-delete';
    case PERMISSION_SMS_NOTIFY_STATUS = 'permission-sms-notify-status';

    // SETTING Section Permissions
    //******************************************************************************************************************
    case PERMISSION_SETTING = 'permission-setting';
    case PERMISSION_SETTING_EDIT = 'permission-setting-edit';

    // NOTIFY Section Permissions
    //******************************************************************************************************************
    case PERMISSION_OFFICE = 'permission-office';

    // 1- SERVICE categories
    case PERMISSION_SERVICE_CATEGORIES = 'permission-service-categories';
    case PERMISSION_SERVICE_CATEGORY_CREATE = 'permission-service-category-create';
    case PERMISSION_SERVICE_CATEGORY_EDIT = 'permission-service-category-edit';
    case PERMISSION_SERVICE_CATEGORY_DELETE = 'permission-service-category-delete';
    case PERMISSION_SERVICE_CATEGORY_STATUS = 'permission-service-category-status';

    // 2- SERVICES
    case PERMISSION_SERVICES = 'permission-service';
    case PERMISSION_SERVICE_CREATE = 'permission-service-create';
    case PERMISSION_SERVICE_EDIT = 'permission-service-edit';
    case PERMISSION_SERVICE_DELETE = 'permission-service-delete';
    case PERMISSION_SERVICE_STATUS = 'permission-service-status';

    // 3- SERVICE COMMENTS
    case PERMISSION_SERVICE_COMMENTS = 'permission-service-comments';
    case PERMISSION_SERVICE_COMMENT_STATUS = 'permission-service-comment-status';
    case PERMISSION_SERVICE_COMMENT_SHOW = 'permission-service-comment-show';
    case PERMISSION_SERVICE_COMMENT_APPROVE = 'permission-service-comment-approve';
    //******************************************************************************************************************

}
