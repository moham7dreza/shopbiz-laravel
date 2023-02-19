<?php

namespace Modules\ACL\Traits;

trait SystemPermissionsTrait
{
// access everywhere
    //******************************************************************************************************************
    public const PERMISSION_SUPER_ADMIN = 'permission super admin';

    // access to each panels
    //******************************************************************************************************************
    public const PERMISSION_ADMIN_PANEL = 'permission admin panel';

    // Market section Permissions
    //******************************************************************************************************************

    public const PERMISSION_COMMON = 'permission common';
    // 1.  TAG
    public const PERMISSION_TAGS = 'permission tags';
    public const PERMISSION_TAG_CREATE = 'permission tag create';
    public const PERMISSION_TAG_EDIT = 'permission tag edit';
    public const PERMISSION_TAG_DELETE = 'permission tag delete';
    public const PERMISSION_TAG_STATUS = 'permission tag status';

    // Market section Permissions
    //******************************************************************************************************************
    public const PERMISSION_MARKET = 'permission market';

    // A. Vitrine
    public const PERMISSION_VITRINE = 'permission vitrine';

    // 1  product category
    public const PERMISSION_PRODUCT_CATEGORIES = 'permission product categories';
    public const PERMISSION_PRODUCT_CATEGORY_CREATE = 'permission product category create';
    public const PERMISSION_PRODUCT_CATEGORY_EDIT = 'permission product category edit';
    public const PERMISSION_PRODUCT_CATEGORY_DELETE = 'permission product category delete';
    public const PERMISSION_PRODUCT_CATEGORY_STATUS = 'permission product category status';
    public const PERMISSION_PRODUCT_CATEGORY_SHOW_IN_MENU = 'permission product category show in menu';
    public const PERMISSION_PRODUCT_CATEGORY_TAGS = 'permission product category tags';

    // 2  PRODUCT PROPERTY
    public const PERMISSION_ATTRIBUTES = 'permission attributes';
    public const PERMISSION_ATTRIBUTE_CREATE = 'permission attribute create';
    public const PERMISSION_ATTRIBUTE_EDIT = 'permission attribute edit';
    public const PERMISSION_ATTRIBUTE_DELETE = 'permission attribute delete';
    public const PERMISSION_ATTRIBUTE_STATUS = 'permission attribute status';
    public const PERMISSION_ATTRIBUTE_CATEGORIES = 'permission attribute categories';
    public const PERMISSION_ATTRIBUTE_VALUES = 'permission attribute values';
    public const PERMISSION_ATTRIBUTE_VALUE_CREATE = 'permission attribute value create';
    public const PERMISSION_ATTRIBUTE_VALUE_EDIT = 'permission attribute value edit';
    public const PERMISSION_ATTRIBUTE_VALUE_DELETE = 'permission attribute value delete';
//    public const PERMISSION_ATTRIBUTE_VALUE_STATUS = 'permission attribute value status';

    // 3  PRODUCT BRAND
    public const PERMISSION_BRANDS = 'permission brands';
    public const PERMISSION_BRAND_CREATE = 'permission brand create';
    public const PERMISSION_BRAND_EDIT = 'permission brand edit';
    public const PERMISSION_BRAND_DELETE = 'permission brand delete';
    public const PERMISSION_BRAND_STATUS = 'permission brand status';
    public const PERMISSION_BRAND_TAGS = 'permission brand tags';

    // 4  PRODUCT
    public const PERMISSION_PRODUCTS = 'permission products';
    public const PERMISSION_PRODUCT_CREATE = 'permission product create';
    public const PERMISSION_PRODUCT_EDIT = 'permission product edit';
    public const PERMISSION_PRODUCT_DELETE = 'permission product delete';
    public const PERMISSION_PRODUCT_STATUS = 'permission product status';
    public const PERMISSION_PRODUCT_MARKETABLE = 'permission product marketable';
    public const PERMISSION_PRODUCT_SELECTED = 'permission product selected';
    public const PERMISSION_PRODUCT_TAGS = 'permission product tags';
    public const PERMISSION_PRODUCT_VALUES = 'permission product values';
    public const PERMISSION_PRODUCT_VALUE_SELECT = 'permission product value select';
    public const PERMISSION_PRODUCT_GALLERY = 'permission product gallery';
    public const PERMISSION_PRODUCT_GALLERY_CREATE = 'permission product gallery create';
    public const PERMISSION_PRODUCT_GALLERY_DELETE = 'permission product gallery delete';
    public const PERMISSION_PRODUCT_GUARANTEES = 'permission product guarantees';
    public const PERMISSION_PRODUCT_GUARANTEE_CREATE = 'permission product guarantee create';
    public const PERMISSION_PRODUCT_GUARANTEE_EDIT = 'permission product guarantee edit';
    public const PERMISSION_PRODUCT_GUARANTEE_DELETE = 'permission product guarantee delete';
    public const PERMISSION_PRODUCT_GUARANTEE_STATUS = 'permission product guarantee status';
    public const PERMISSION_PRODUCT_COLORS = 'permission product colors';
    public const PERMISSION_PRODUCT_COLOR_CREATE = 'permission product color create';
    public const PERMISSION_PRODUCT_COLOR_EDIT = 'permission product color edit';
    public const PERMISSION_PRODUCT_COLOR_DELETE = 'permission product color delete';
    public const PERMISSION_PRODUCT_COLOR_STATUS = 'permission product color status';

    // 5  WAREHOUSE
    public const PERMISSION_WAREHOUSE = 'permission warehouse';
    public const PERMISSION_WAREHOUSE_ADD = 'permission warehouse add';
    public const PERMISSION_WAREHOUSE_MODIFY = 'permission warehouse modify';

    // 6  PRODUCT COMMENT
    public const PERMISSION_PRODUCT_COMMENTS = 'permission product comments';
    public const PERMISSION_PRODUCT_COMMENT_SHOW = 'permission product comment show';
    public const PERMISSION_PRODUCT_COMMENT_STATUS = 'permission product comment status';
    public const PERMISSION_PRODUCT_COMMENT_APPROVE = 'permission product comment approve';

    // 7  colors
    public const PERMISSION_COLORS = 'permission colors';
    public const PERMISSION_COLOR_CREATE = 'permission color create';
    public const PERMISSION_COLOR_EDIT = 'permission color edit';
    public const PERMISSION_COLOR_DELETE = 'permission color delete';
    public const PERMISSION_COLOR_STATUS = 'permission color status';

    // 7  guarantees
    public const PERMISSION_GUARANTEES = 'permission guarantees';
    public const PERMISSION_GUARANTEE_CREATE = 'permission guarantee create';
    public const PERMISSION_GUARANTEE_EDIT = 'permission guarantee edit';
    public const PERMISSION_GUARANTEE_DELETE = 'permission guarantee delete';
    public const PERMISSION_GUARANTEE_STATUS = 'permission guarantee status';

    // B. ORDER
    public const PERMISSION_ORDERS = 'permission orders';
    // 1  NEW ORDER
    public const PERMISSION_NEW_ORDERS = 'permission new orders';
//    public const PERMISSION_NEW_ORDER_SHOW = 'permission new order show';
//    public const PERMISSION_NEW_ORDER_DETAIL = 'permission new order detail';
//    public const PERMISSION_NEW_ORDER_PRINT = 'permission new order print';
//    public const PERMISSION_NEW_ORDER_CANCEL = 'permission new order cancel';
//    public const PERMISSION_NEW_ORDER_CHANGE_STATUS = 'permission new order status';
//    public const PERMISSION_NEW_ORDER_CHANGE_SEND_STATUS = 'permission new order send status';

    // 2  SENDING ORDER
    public const PERMISSION_SENDING_ORDERS = 'permission sending orders';
//    public const PERMISSION_SENDING_ORDER_SHOW = 'permission sending order show';
//    public const PERMISSION_SENDING_ORDER_DETAIL = 'permission sending order detail';
//    public const PERMISSION_SENDING_ORDER_PRINT = 'permission sending order print';
//    public const PERMISSION_SENDING_ORDER_CANCEL = 'permission sending order cancel';
//    public const PERMISSION_SENDING_ORDER_CHANGE_STATUS = 'permission sending order status';
//    public const PERMISSION_SENDING_ORDER_CHANGE_SEND_STATUS = 'permission sending order send status';

    // 3  UNPAID ORDER
    public const PERMISSION_UNPAID_ORDERS = 'permission unpaid orders';
//    public const PERMISSION_UNPAID_ORDER_SHOW = 'permission unpaid order show';
//    public const PERMISSION_UNPAID_ORDER_SHOW_DETAIL = 'permission unpaid order detail';
//    public const PERMISSION_UNPAID_ORDER_SHOW_PRINT = 'permission unpaid order print';
//    public const PERMISSION_UNPAID_ORDER_CANCEL = 'permission unpaid order cancel';
//    public const PERMISSION_UNPAID_ORDER_CHANGE_STATUS = 'permission unpaid order status';
//    public const PERMISSION_UNPAID_ORDER_CHANGE_SEND_STATUS = 'permission unpaid order send status';

    // 4  CANCELED ORDER
    public const PERMISSION_CANCELED_ORDERS = 'permission canceled orders';
//    public const PERMISSION_CANCELED_ORDER_SHOW = 'permission canceled order show';
//    public const PERMISSION_CANCELED_ORDER_SHOW_DETAIL = 'permission canceled order detail';
//    public const PERMISSION_CANCELED_ORDER_SHOW_PRINT = 'permission canceled order print';
//    public const PERMISSION_CANCELED_ORDER_CANCEL = 'permission canceled order cancel';
//    public const PERMISSION_CANCELED_ORDER_CHANGE_STATUS = 'permission canceled order status';
//    public const PERMISSION_CANCELED_ORDER_CHANGE_SEND_STATUS = 'permission canceled order send status';

    // 5  RETURNED ORDER
    public const PERMISSION_RETURNED_ORDERS = 'permission returned orders';
//    public const PERMISSION_RETURNED_ORDER_SHOW = 'permission returned order show';
//    public const PERMISSION_RETURNED_ORDER_SHOW_DETAIL = 'permission returned order detail';
//    public const PERMISSION_RETURNED_ORDER_SHOW_PRINT = 'permission returned order print';
//    public const PERMISSION_RETURNED_ORDER_CANCEL = 'permission returned order cancel';
//    public const PERMISSION_RETURNED_ORDER_CHANGE_STATUS = 'permission returned order status';
//    public const PERMISSION_RETURNED_ORDER_CHANGE_SEND_STATUS = 'permission returned order send status';

    // 6  ALL ORDER
    public const PERMISSION_ALL_ORDERS = 'permission all orders';
    public const PERMISSION_ORDER_SHOW = 'permission order show';
    public const PERMISSION_ORDER_SHOW_DETAIL = 'permission order detail';
    public const PERMISSION_ORDER_PRINT = 'permission order print';
    public const PERMISSION_ORDER_CANCEL = 'permission order cancel';
    public const PERMISSION_ORDER_CHANGE_STATUS = 'permission order change status';
    public const PERMISSION_ORDER_CHANGE_SEND_STATUS = 'permission order change send status';

    // C. PAYMENT
    public const PERMISSION_PAYMENTS = 'permission payments';

    // 1  ALL PAYMENT
    public const PERMISSION_ALL_PAYMENTS = 'permission all payments';
    public const PERMISSION_PAYMENT_SHOW = 'permission payment show';
    public const PERMISSION_PAYMENT_CANCEL = 'permission payment cancel';
    public const PERMISSION_PAYMENT_RETURN = 'permission payment return';

    // 2  ONLINE PAYMENT
    public const PERMISSION_ONLINE_PAYMENTS = 'permission online payments';
//    public const PERMISSION_ONLINE_PAYMENT_SHOW = 'permission online payment show';
//    public const PERMISSION_ONLINE_PAYMENT_CANCEL = 'permission online payment cancel';
//    public const PERMISSION_ONLINE_PAYMENT_RETURN = 'permission online payment return';

    // 3  OFFLINE PAYMENT
    public const PERMISSION_OFFLINE_PAYMENTS = 'permission offline payments';
//    public const PERMISSION_OFFLINE_PAYMENT_SHOW = 'permission offline payment show';
//    public const PERMISSION_OFFLINE_PAYMENT_CANCEL = 'permission offline payment cancel';
//    public const PERMISSION_OFFLINE_PAYMENT_RETURN = 'permission offline payment return';

    // 4  CASH PAYMENT
    public const PERMISSION_CASH_PAYMENTS = 'permission cash payments';
//    public const PERMISSION_CASH_PAYMENT_SHOW = 'permission cash payment show';
//    public const PERMISSION_CASH_PAYMENT_CANCEL = 'permission cash payment cancel';
//    public const PERMISSION_CASH_PAYMENT_RETURN = 'permission cash payment return';

    // D. DISCOUNTS
    public const PERMISSION_DISCOUNTS = 'permission discounts';

    // 1  COUPON
    public const PERMISSION_COUPON_DISCOUNTS = 'permission coupon discounts';
    public const PERMISSION_COUPON_DISCOUNT_CREATE = 'permission coupon discount create';
    public const PERMISSION_COUPON_DISCOUNT_EDIT = 'permission coupon discount edit';
    public const PERMISSION_COUPON_DISCOUNT_DELETE = 'permission coupon discount delete';
    public const PERMISSION_COUPON_DISCOUNT_STATUS = 'permission coupon discount status';

    // 2  COMMON
    public const PERMISSION_COMMON_DISCOUNTS = 'permission common discounts';
    public const PERMISSION_COMMON_DISCOUNT_CREATE = 'permission common discount create';
    public const PERMISSION_COMMON_DISCOUNT_EDIT = 'permission common discount edit';
    public const PERMISSION_COMMON_DISCOUNT_DELETE = 'permission common discount delete';
    public const PERMISSION_COMMON_DISCOUNT_STATUS = 'permission common discount status';

    // 3  AMAZING SALE
    public const PERMISSION_AMAZING_SALES = 'permission amazing sales';
    public const PERMISSION_AMAZING_SALE_CREATE = 'permission amazing sale create';
    public const PERMISSION_AMAZING_SALE_EDIT = 'permission amazing sale edit';
    public const PERMISSION_AMAZING_SALE_DELETE = 'permission amazing sale delete';
    public const PERMISSION_AMAZING_SALE_STATUS = 'permission amazing sale status';

    // E. DELIVERY
    public const PERMISSION_DELIVERY_METHODS = 'permission delivery methods';
    public const PERMISSION_DELIVERY_METHOD_CREATE = 'permission delivery method create';
    public const PERMISSION_DELIVERY_METHOD_EDIT = 'permission delivery method edit';
    public const PERMISSION_DELIVERY_METHOD_DELETE = 'permission delivery method delete';
    public const PERMISSION_DELIVERY_METHOD_STATUS = 'permission delivery method status';

    // Content Section Permissions
    //******************************************************************************************************************
    public const PERMISSION_CONTENT = 'permission content';

    // 1  post categories
    public const PERMISSION_POST_CATEGORIES = 'permission post categories';
    public const PERMISSION_POST_CATEGORY_CREATE = 'permission post category create';
    public const PERMISSION_POST_CATEGORY_EDIT = 'permission post category edit';
    public const PERMISSION_POST_CATEGORY_DELETE = 'permission post category delete';
    public const PERMISSION_POST_CATEGORY_STATUS = 'permission post category status';
    public const PERMISSION_POST_CATEGORY_TAGS = 'permission post category tags';

    // 2  post
    public const PERMISSION_POSTS = 'permission posts';
    public const PERMISSION_POST_CREATE = 'permission post create';
    public const PERMISSION_POST_EDIT = 'permission post edit';
    public const PERMISSION_POST_DELETE = 'permission post delete';
    public const PERMISSION_POST_STATUS = 'permission post status';
    public const PERMISSION_POST_COMMENTABLE = 'permission post commentable';
    public const PERMISSION_POST_TAGS = 'permission post set tags';

    public const PERMISSION_POST_AUTHORS = 'permission post authors';

    // 3  post comments
    public const PERMISSION_POST_COMMENTS = 'permission post comments';
    public const PERMISSION_POST_COMMENT_STATUS = 'permission post comment status';
    public const PERMISSION_POST_COMMENT_SHOW = 'permission post comment show';
    public const PERMISSION_POST_COMMENT_APPROVE = 'permission post comment approve';
    // 4  FAQS
    public const PERMISSION_FAQS = 'permission faqs';
    public const PERMISSION_FAQ_CREATE = 'permission faq create';
    public const PERMISSION_FAQ_EDIT = 'permission faq edit';
    public const PERMISSION_FAQ_DELETE = 'permission faq delete';
    public const PERMISSION_FAQ_STATUS = 'permission faq status';
    public const PERMISSION_FAQ_TAGS = 'permission faq tags';

    // 5  PAGE
    public const PERMISSION_PAGES = 'permission pages';
    public const PERMISSION_PAGE_CREATE = 'permission page create';
    public const PERMISSION_PAGE_EDIT = 'permission page edit';
    public const PERMISSION_PAGE_DELETE = 'permission page delete';
    public const PERMISSION_PAGE_STATUS = 'permission page status';
    public const PERMISSION_PAGE_TAGS = 'permission page tags';

    // 6  MENU
    public const PERMISSION_MENUS = 'permission menus';
    public const PERMISSION_MENU_CREATE = 'permission menu create';
    public const PERMISSION_MENU_EDIT = 'permission menu edit';
    public const PERMISSION_MENU_DELETE = 'permission menu delete';
    public const PERMISSION_MENU_STATUS = 'permission menu status';

    // 7  BANNER
    public const PERMISSION_BANNERS = 'permission banners';
    public const PERMISSION_BANNER_CREATE = 'permission banner create';
    public const PERMISSION_BANNER_EDIT = 'permission banner edit';
    public const PERMISSION_BANNER_DELETE = 'permission banner delete';
    public const PERMISSION_BANNER_STATUS = 'permission banner status';
    public const PERMISSION_BANNER_LOCATION_SHOW = 'permission banner location show';

    // User Section Permissions
    //******************************************************************************************************************
    public const PERMISSION_USERS = 'permission users';

    // 1  admin users
    public const PERMISSION_ADMIN_USERS = 'permission admin users';
    public const PERMISSION_ADMIN_USER_CREATE = 'permission admin user create';
    public const PERMISSION_ADMIN_USER_EDIT = 'permission admin user edit';
    public const PERMISSION_ADMIN_USER_DELETE = 'permission admin user delete';
    public const PERMISSION_ADMIN_USER_STATUS = 'permission admin user status';
    public const PERMISSION_ADMIN_USER_ROLES = 'permission admin user roles';
    public const PERMISSION_ADMIN_USER_PERMISSIONS = 'permission admin user permissions';
    public const PERMISSION_ADMIN_USER_ACTIVATION = 'permission admin user activation';

    // 2  CUSTOMER USER
    public const PERMISSION_CUSTOMER_USERS = 'permission customer users';
    public const PERMISSION_CUSTOMER_USER_CREATE = 'permission customer user create';
    public const PERMISSION_CUSTOMER_USER_EDIT = 'permission customer user edit';
    public const PERMISSION_CUSTOMER_USER_DELETE = 'permission customer user delete';
    public const PERMISSION_CUSTOMER_USER_STATUS = 'permission customer user status';
    public const PERMISSION_CUSTOMER_USER_ACTIVATION = 'permission customer user activation';

    // 3  USER ROLES
    public const PERMISSION_ROLES = 'permission roles';
    public const PERMISSION_ROLE_CREATE = 'permission role create';
    public const PERMISSION_ROLE_EDIT = 'permission role edit';
    public const PERMISSION_ROLE_DELETE = 'permission role delete';
    public const PERMISSION_ROLE_STATUS = 'permission role status';
    public const PERMISSION_ROLE_PERMISSIONS = 'permission role permissions';
//    public const PERMISSION_PERMISSIONS_IMPORT = 'permission permissions import';
//    public const PERMISSION_PERMISSIONS_EXPORT = 'permission permissions export';

    // 4  Permissions
    public const PERMISSIONS = 'permissions';
    public const PERMISSION_CREATE = 'permission create';
    public const PERMISSION_EDIT = 'permission edit';
    public const PERMISSION_DELETE = 'permission delete';
    public const PERMISSION_STATUS = 'permission status';
    public const PERMISSION_ROLES_SHOW = 'permission roles show';

    // TICKET Section Permissions
    //******************************************************************************************************************
    public const PERMISSION_TICKETS = 'permission tickets';

    // 1  TICKET CATEGORY
    public const PERMISSION_TICKET_CATEGORIES = 'permission ticket categories';
    public const PERMISSION_TICKET_CATEGORY_CREATE = 'permission ticket category create';
    public const PERMISSION_TICKET_CATEGORY_EDIT = 'permission ticket category edit';
    public const PERMISSION_TICKET_CATEGORY_DELETE = 'permission ticket category delete';
    public const PERMISSION_TICKET_CATEGORY_STATUS = 'permission ticket category status';

    // 2  TICKET PRIORITY
    public const PERMISSION_TICKET_PRIORITIES = 'permission ticket priorities';
    public const PERMISSION_TICKET_PRIORITY_CREATE = 'permission ticket priority create';
    public const PERMISSION_TICKET_PRIORITY_EDIT = 'permission ticket priority edit';
    public const PERMISSION_TICKET_PRIORITY_DELETE = 'permission ticket priority delete';
    public const PERMISSION_TICKET_PRIORITY_STATUS = 'permission ticket priority status';

    // 3  ADMIN TICKET
    public const PERMISSION_ADMIN_TICKETS = 'permission admin tickets';
    public const PERMISSION_ADMIN_TICKET_ADD = 'permission admin ticket add';

    // 4  NEW TICKET
    public const PERMISSION_NEW_TICKETS = 'permission new tickets';
    public const PERMISSION_NEW_TICKET_SHOW = 'permission new ticket show';
    public const PERMISSION_NEW_TICKET_CHANGE = 'permission new ticket change';

    // 5  OPEN TICKET
    public const PERMISSION_OPEN_TICKETS = 'permission open tickets';
    public const PERMISSION_OPEN_TICKET_SHOW = 'permission open ticket show';
    public const PERMISSION_OPEN_TICKET_CHANGE = 'permission open ticket change';


    // 6  CLOSE TICKETS
    public const PERMISSION_CLOSE_TICKETS = 'permission close tickets';
    public const PERMISSION_CLOSE_TICKET_SHOW = 'permission close ticket show';
    public const PERMISSION_CLOSE_TICKET_CHANGE = 'permission close ticket change';

    // 7  ALL TICKET
    public const PERMISSION_ALL_TICKETS = 'permission all tickets';
    public const PERMISSION_TICKET_SHOW = 'permission ticket show';
    public const PERMISSION_TICKET_CHANGE = 'permission ticket change';


    // NOTIFY Section Permissions
    //******************************************************************************************************************
    public const PERMISSION_NOTIFY = 'permission notify';

    // 1  EMAIL NOTIFY
    public const PERMISSION_EMAIL_NOTIFYS = 'permission email notifys';
    public const PERMISSION_EMAIL_NOTIFY_CREATE = 'permission email notify create';
    public const PERMISSION_EMAIL_NOTIFY_EDIT = 'permission email notify edit';
    public const PERMISSION_EMAIL_NOTIFY_DELETE = 'permission email notify delete';
    public const PERMISSION_EMAIL_NOTIFY_STATUS = 'permission email notify status';
    public const PERMISSION_EMAIL_NOTIFY_FILES = 'permission email notify files';
    public const PERMISSION_EMAIL_NOTIFY_FILE_CREATE = 'permission email notify file create';
    public const PERMISSION_EMAIL_NOTIFY_FILE_EDIT = 'permission email notify file edit';
    public const PERMISSION_EMAIL_NOTIFY_FILE_DELETE = 'permission email notify file delete';
    public const PERMISSION_EMAIL_NOTIFY_FILE_STATUS = 'permission email notify file status';

    // 2  SMS NOTIFY
    public const PERMISSION_SMS_NOTIFYS = 'permission sms notifys';
    public const PERMISSION_SMS_NOTIFY_CREATE = 'permission sms notify create';
    public const PERMISSION_SMS_NOTIFY_EDIT = 'permission sms notify edit';
    public const PERMISSION_SMS_NOTIFY_DELETE = 'permission sms notify delete';
    public const PERMISSION_SMS_NOTIFY_STATUS = 'permission sms notify status';

    // SETTING Section Permissions
    //******************************************************************************************************************
    public const PERMISSION_SETTING = 'permission setting';
    public const PERMISSION_SETTING_EDIT = 'permission setting edit';

    // SETTING Section Permissions
    //******************************************************************************************************************
    public const PERMISSION_PANEL_COUNTER_CARDS = 'permission panel counter cards';
    public const PERMISSION_PANEL_ALERTS = 'permission panel alerts';
    public const PERMISSION_PANEL_SALES_CHARTS = 'permission panel sales charts';
    public const PERMISSION_PANEL_ACTIVITY_LOG = 'permission panel activity log';
    public const PERMISSION_PANEL_USERS_LOG = 'permission panel users log';
    public const PERMISSION_PANEL_LATEST_COMMENTS = 'permission panel latest comments';

    // NOTIFY Section Permissions
    //******************************************************************************************************************
    public const PERMISSION_OFFICE = 'permission office';

    // 1  SERVICE categories
    public const PERMISSION_SERVICE_CATEGORIES = 'permission service categories';
    public const PERMISSION_SERVICE_CATEGORY_CREATE = 'permission service category create';
    public const PERMISSION_SERVICE_CATEGORY_EDIT = 'permission service category edit';
    public const PERMISSION_SERVICE_CATEGORY_DELETE = 'permission service category delete';
    public const PERMISSION_SERVICE_CATEGORY_STATUS = 'permission service category status';

    // 2  SERVICES
    public const PERMISSION_SERVICES = 'permission service';
    public const PERMISSION_SERVICE_CREATE = 'permission service create';
    public const PERMISSION_SERVICE_EDIT = 'permission service edit';
    public const PERMISSION_SERVICE_DELETE = 'permission service delete';
    public const PERMISSION_SERVICE_STATUS = 'permission service status';

    // 3  SERVICE COMMENTS
    public const PERMISSION_SERVICE_COMMENTS = 'permission service comments';
    public const PERMISSION_SERVICE_COMMENT_STATUS = 'permission service comment status';
    public const PERMISSION_SERVICE_COMMENT_SHOW = 'permission service comment show';
    public const PERMISSION_SERVICE_COMMENT_APPROVE = 'permission service comment approve';
    //******************************************************************************************************************


    /**
     * @var array|array[]
     */
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
        , self::PERMISSION_PRODUCT_CATEGORY_SHOW_IN_MENU
        , self::PERMISSION_PRODUCT_CATEGORY_TAGS
        , self::PERMISSION_ATTRIBUTES
        , self::PERMISSION_ATTRIBUTE_CREATE
        , self::PERMISSION_ATTRIBUTE_EDIT
        , self::PERMISSION_ATTRIBUTE_DELETE
        , self::PERMISSION_ATTRIBUTE_STATUS
        , self::PERMISSION_ATTRIBUTE_CATEGORIES
        , self::PERMISSION_ATTRIBUTE_VALUES
        , self::PERMISSION_ATTRIBUTE_VALUE_CREATE
        , self::PERMISSION_ATTRIBUTE_VALUE_EDIT
        , self::PERMISSION_ATTRIBUTE_VALUE_DELETE
//        , self::PERMISSION_ATTRIBUTE_VALUE_STATUS
        , self::PERMISSION_BRANDS
        , self::PERMISSION_BRAND_CREATE
        , self::PERMISSION_BRAND_EDIT
        , self::PERMISSION_BRAND_DELETE
        , self::PERMISSION_BRAND_STATUS
        , self::PERMISSION_BRAND_TAGS
        , self::PERMISSION_PRODUCTS
        , self::PERMISSION_PRODUCT_CREATE
        , self::PERMISSION_PRODUCT_EDIT
        , self::PERMISSION_PRODUCT_DELETE
        , self::PERMISSION_PRODUCT_STATUS
        , self::PERMISSION_PRODUCT_SELECTED
        , self::PERMISSION_PRODUCT_MARKETABLE
        , self::PERMISSION_PRODUCT_TAGS
        , self::PERMISSION_PRODUCT_VALUES
        , self::PERMISSION_PRODUCT_VALUE_SELECT
        , self::PERMISSION_PRODUCT_GALLERY
        , self::PERMISSION_PRODUCT_GALLERY_CREATE
        , self::PERMISSION_PRODUCT_GALLERY_DELETE
        , self::PERMISSION_PRODUCT_GUARANTEES
        , self::PERMISSION_PRODUCT_GUARANTEE_CREATE
        , self::PERMISSION_PRODUCT_GUARANTEE_EDIT
        , self::PERMISSION_PRODUCT_GUARANTEE_DELETE
        , self::PERMISSION_PRODUCT_GUARANTEE_STATUS
        , self::PERMISSION_PRODUCT_COLORS
        , self::PERMISSION_PRODUCT_COLOR_CREATE
        , self::PERMISSION_PRODUCT_COLOR_EDIT
        , self::PERMISSION_PRODUCT_COLOR_DELETE
        , self::PERMISSION_PRODUCT_COLOR_STATUS
        , self::PERMISSION_COLORS
        , self::PERMISSION_COLOR_CREATE
        , self::PERMISSION_COLOR_EDIT
        , self::PERMISSION_COLOR_DELETE
        , self::PERMISSION_COLOR_STATUS
        , self::PERMISSION_GUARANTEES
        , self::PERMISSION_GUARANTEE_CREATE
        , self::PERMISSION_GUARANTEE_EDIT
        , self::PERMISSION_GUARANTEE_DELETE
        , self::PERMISSION_GUARANTEE_STATUS
        , self::PERMISSION_WAREHOUSE
        , self::PERMISSION_WAREHOUSE_ADD
        , self::PERMISSION_WAREHOUSE_MODIFY
        , self::PERMISSION_PRODUCT_COMMENTS
        , self::PERMISSION_PRODUCT_COMMENT_SHOW
        , self::PERMISSION_PRODUCT_COMMENT_STATUS
        , self::PERMISSION_PRODUCT_COMMENT_APPROVE
        , self::PERMISSION_ORDERS
        , self::PERMISSION_NEW_ORDERS
//        , self::PERMISSION_NEW_ORDER_SHOW
//        , self::PERMISSION_NEW_ORDER_DETAIL
//        , self::PERMISSION_NEW_ORDER_PRINT
//        , self::PERMISSION_NEW_ORDER_CANCEL
//        , self::PERMISSION_NEW_ORDER_CHANGE_STATUS
//        , self::PERMISSION_NEW_ORDER_CHANGE_SEND_STATUS
        , self::PERMISSION_SENDING_ORDERS
//        , self::PERMISSION_SENDING_ORDER_SHOW
//        , self::PERMISSION_SENDING_ORDER_DETAIL
//        , self::PERMISSION_SENDING_ORDER_PRINT
//        , self::PERMISSION_SENDING_ORDER_CANCEL
//        , self::PERMISSION_SENDING_ORDER_CHANGE_STATUS
//        , self::PERMISSION_SENDING_ORDER_CHANGE_SEND_STATUS
        , self::PERMISSION_UNPAID_ORDERS
//        , self::PERMISSION_UNPAID_ORDER_SHOW
//        , self::PERMISSION_UNPAID_ORDER_SHOW_DETAIL
//        , self::PERMISSION_UNPAID_ORDER_SHOW_PRINT
//        , self::PERMISSION_UNPAID_ORDER_CANCEL
//        , self::PERMISSION_UNPAID_ORDER_CHANGE_STATUS
//        , self::PERMISSION_UNPAID_ORDER_CHANGE_SEND_STATUS
        , self::PERMISSION_CANCELED_ORDERS
//        , self::PERMISSION_CANCELED_ORDER_SHOW
//        , self::PERMISSION_CANCELED_ORDER_SHOW_DETAIL
//        , self::PERMISSION_CANCELED_ORDER_SHOW_PRINT
//        , self::PERMISSION_CANCELED_ORDER_CANCEL
//        , self::PERMISSION_CANCELED_ORDER_CHANGE_STATUS
//        , self::PERMISSION_CANCELED_ORDER_CHANGE_SEND_STATUS
        , self::PERMISSION_RETURNED_ORDERS
//        , self::PERMISSION_RETURNED_ORDER_SHOW
//        , self::PERMISSION_RETURNED_ORDER_SHOW_DETAIL
//        , self::PERMISSION_RETURNED_ORDER_SHOW_PRINT
//        , self::PERMISSION_RETURNED_ORDER_CANCEL
//        , self::PERMISSION_RETURNED_ORDER_CHANGE_STATUS
//        , self::PERMISSION_RETURNED_ORDER_CHANGE_SEND_STATUS
        , self::PERMISSION_ALL_ORDERS
        , self::PERMISSION_ORDER_SHOW
        , self::PERMISSION_ORDER_SHOW_DETAIL
        , self::PERMISSION_ORDER_PRINT
        , self::PERMISSION_ORDER_CANCEL
        , self::PERMISSION_ORDER_CHANGE_STATUS
        , self::PERMISSION_ORDER_CHANGE_SEND_STATUS
        , self::PERMISSION_PAYMENTS
        , self::PERMISSION_ALL_PAYMENTS
        , self::PERMISSION_PAYMENT_SHOW
        , self::PERMISSION_PAYMENT_CANCEL
        , self::PERMISSION_PAYMENT_RETURN
        , self::PERMISSION_ONLINE_PAYMENTS
//        , self::PERMISSION_ONLINE_PAYMENT_SHOW
//        , self::PERMISSION_ONLINE_PAYMENT_CANCEL
//        , self::PERMISSION_ONLINE_PAYMENT_RETURN
        , self::PERMISSION_OFFLINE_PAYMENTS
//        , self::PERMISSION_OFFLINE_PAYMENT_SHOW
//        , self::PERMISSION_OFFLINE_PAYMENT_CANCEL
//        , self::PERMISSION_OFFLINE_PAYMENT_RETURN
        , self::PERMISSION_CASH_PAYMENTS
//        , self::PERMISSION_CASH_PAYMENT_SHOW
//        , self::PERMISSION_CASH_PAYMENT_CANCEL
//        , self::PERMISSION_CASH_PAYMENT_RETURN
        , self::PERMISSION_DISCOUNTS
        , self::PERMISSION_COUPON_DISCOUNTS
        , self::PERMISSION_COUPON_DISCOUNT_CREATE
        , self::PERMISSION_COUPON_DISCOUNT_EDIT
        , self::PERMISSION_COUPON_DISCOUNT_DELETE
        , self::PERMISSION_COUPON_DISCOUNT_STATUS
        , self::PERMISSION_COMMON_DISCOUNTS
        , self::PERMISSION_COMMON_DISCOUNT_CREATE
        , self::PERMISSION_COMMON_DISCOUNT_EDIT
        , self::PERMISSION_COMMON_DISCOUNT_DELETE
        , self::PERMISSION_COMMON_DISCOUNT_STATUS
        , self::PERMISSION_AMAZING_SALES
        , self::PERMISSION_AMAZING_SALE_CREATE
        , self::PERMISSION_AMAZING_SALE_EDIT
        , self::PERMISSION_AMAZING_SALE_DELETE
        , self::PERMISSION_AMAZING_SALE_STATUS
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
        , self::PERMISSION_POST_CATEGORY_TAGS
        , self::PERMISSION_POSTS
        , self::PERMISSION_POST_CREATE
        , self::PERMISSION_POST_EDIT
        , self::PERMISSION_POST_DELETE
        , self::PERMISSION_POST_STATUS
        , self::PERMISSION_POST_COMMENTABLE
        , self::PERMISSION_POST_TAGS
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
        , self::PERMISSION_FAQ_TAGS
        , self::PERMISSION_PAGES
        , self::PERMISSION_PAGE_CREATE
        , self::PERMISSION_PAGE_EDIT
        , self::PERMISSION_PAGE_DELETE
        , self::PERMISSION_PAGE_STATUS
        , self::PERMISSION_PAGE_TAGS
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
        , self::PERMISSION_BANNER_LOCATION_SHOW
        , self::PERMISSION_COMMON
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
        , self::PERMISSION_ADMIN_USER_PERMISSIONS
        , self::PERMISSION_ADMIN_USER_ACTIVATION
        , self::PERMISSION_CUSTOMER_USERS
        , self::PERMISSION_CUSTOMER_USER_CREATE
        , self::PERMISSION_CUSTOMER_USER_EDIT
        , self::PERMISSION_CUSTOMER_USER_DELETE
        , self::PERMISSION_CUSTOMER_USER_STATUS
        , self::PERMISSION_CUSTOMER_USER_ACTIVATION
        , self::PERMISSION_ROLES
        , self::PERMISSION_ROLE_CREATE
        , self::PERMISSION_ROLE_EDIT
        , self::PERMISSION_ROLE_DELETE
        , self::PERMISSION_ROLE_STATUS
        , self::PERMISSION_ROLE_PERMISSIONS
//        , self::PERMISSION_PERMISSIONS_IMPORT
//        , self::PERMISSION_PERMISSIONS_EXPORT
        , self::PERMISSIONS
        , self::PERMISSION_CREATE
        , self::PERMISSION_EDIT
        , self::PERMISSION_STATUS
        , self::PERMISSION_DELETE
        , self::PERMISSION_ROLES_SHOW
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
        , self::PERMISSION_EMAIL_NOTIFYS
        , self::PERMISSION_EMAIL_NOTIFY_CREATE
        , self::PERMISSION_EMAIL_NOTIFY_EDIT
        , self::PERMISSION_EMAIL_NOTIFY_DELETE
        , self::PERMISSION_EMAIL_NOTIFY_STATUS
        , self::PERMISSION_EMAIL_NOTIFY_FILES
        , self::PERMISSION_EMAIL_NOTIFY_FILE_CREATE
        , self::PERMISSION_EMAIL_NOTIFY_FILE_EDIT
        , self::PERMISSION_EMAIL_NOTIFY_FILE_DELETE
        , self::PERMISSION_EMAIL_NOTIFY_FILE_STATUS
        , self::PERMISSION_SMS_NOTIFYS
        , self::PERMISSION_SMS_NOTIFY_CREATE
        , self::PERMISSION_SMS_NOTIFY_EDIT
        , self::PERMISSION_SMS_NOTIFY_DELETE
        , self::PERMISSION_SMS_NOTIFY_STATUS
        , self::PERMISSION_SETTING
        , self::PERMISSION_SETTING_EDIT
        , self::PERMISSION_PANEL_COUNTER_CARDS
        , self::PERMISSION_PANEL_ALERTS
        , self::PERMISSION_PANEL_ACTIVITY_LOG
        , self::PERMISSION_PANEL_USERS_LOG
        , self::PERMISSION_PANEL_LATEST_COMMENTS
        , self::PERMISSION_PANEL_SALES_CHARTS
//        , self::PERMISSION_OFFICE
//        , self::PERMISSION_SERVICE_CATEGORIES
//        , self::PERMISSION_SERVICE_CATEGORY_CREATE
//        , self::PERMISSION_SERVICE_CATEGORY_EDIT
//        , self::PERMISSION_SERVICE_CATEGORY_DELETE
//        , self::PERMISSION_SERVICE_CATEGORY_STATUS
//        , self::PERMISSION_SERVICES
//        , self::PERMISSION_SERVICE_CREATE
//        , self::PERMISSION_SERVICE_EDIT
//        , self::PERMISSION_SERVICE_DELETE
//        , self::PERMISSION_SERVICE_STATUS
//        , self::PERMISSION_SERVICE_COMMENTS
//        , self::PERMISSION_SERVICE_COMMENT_STATUS
//        , self::PERMISSION_SERVICE_COMMENT_SHOW
//        , self::PERMISSION_SERVICE_COMMENT_APPROVE
    ];
}
