<?php

return [
    /**
     * Set menu for panel.
     */
    'menus' => [
        'panel' => [],
        'home' => [],
        'market' => [
            'vitrine' => [
                'category' => [],
                'property' => [],
                'brand' => [],
                'product' => [],
                'store' => [],
                'comment' => [],
            ],
            'orders' => [

            ],
            'payments' => [
                'new' => [],
                'sending' => [],
                'notPaid' => [],
                'all' => [],
                'returned' => [],
                'canceled' => [],
            ],
            'discounts' => [
                'coupon' => [],
                'common' => [],
                'amazingSale' => [],
            ],
            'delivery' => [],
        ],
        'content' => [
            'category' => [],
            'post' => [],
            'menu' => [],
            'page' => [],
            'faq' => [],
            'comment' => [],
            'banner' => [],
        ],
        'users' => [
            'admins' => [],
            'customers' => [],
            'role-permissions' => [
                'roles' => [],
                'permissions' => [],
            ],
        ],
        'tickets' => [
            'category' => [],
            'priority' => [],
            'admin' => [],
            'new' => [],
            'open' => [],
            'close' => [],
            'all' => [],
        ],

        'notify' => [
            'email' => [],
            'sms' => [],
        ],
        'settings' => [
            'setting' => [],
        ],
    ],
];
