<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title' => 'Admin',
    'title_prefix' => 'SAFWA',
    'title_postfix' => 'Portal',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-favicon
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-logo
    |
    */

    'logo' => '<b>Admin</b>SAFWA',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'AdminSAFWA',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-user-menu
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => true,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#661-authentication-views-classes
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#662-admin-panel-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-sidebar
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-control-sidebar-right-sidebar
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-urls
    |
    */

    'use_route_url' => false,

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    //'register_url' => 'register',

    'register_url' => false,

    'password_reset_url' => 'password/reset',

    //'password_reset_url' => false,

    'password_email_url' => 'password/email',

    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-laravel-mix
    |
    */

    'enabled_laravel_mix' => true,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-menu
    |
    */

    'menu' => [
        [
            'text' => 'search',
            'search' => true,
            'topnav' => true,
        ],

        [
            'text' => 'dashboard',
            'route'  => 'home',
            'icon'    => 'icon-01-dashboard-icon',
            'can' => ['view dashboard'],
        ],
        // ],
        // [
        //     'text' => 'chat_head',
        //     'icon'    => 'icon-05-car-category',
        //     'can' => ['view chats','view groups'],
        //     'submenu' => [
        //         [
        //             'text' => 'chat',
        //             'route'  => 'chats.chat',
        //             'icon'    => 'icon-06-taxi-category',
        //             'can' => ['view chats'],

        //         ],
        //         [
        //             'text' => 'groups',
        //             'route'  => 'groups.group.index',
        //             'icon'    => 'icon-06-taxi-category',
        //             'can' => ['view groups'],
        //         ],
        //     ],
        // ],
        [
            'text'    => 'drivers',
            'route'  => 'drivers.driver.index',
            'icon'    => 'icon-02-drivers',
            'can' => ['view drivers'],
        ],
        [
            'text'    => 'customers',
            'route'  => 'customer.index',
            'icon'    => 'icon-03-customers',
            'can' => ['view customers'],
        ],
        [
            'text' => 'companies',
            'route'  => 'companies.company.index',
            'icon'    => 'icon-04-company',
            'can' => ['view companies'],
        ],
        [
            'text' => 'car_category',
            'icon'    => 'icon-05-car-category',
             'can' => ['view categories'],
            'submenu' => [
                [
                    'text' => 'taxi_category',
                    'url'  => 'categories/category_type/2',
                    'icon'    => 'icon-06-taxi-category',
                    'can' => ['view categories'],

                ],
                [
                    'text' => 'airport_car_category',
                    'url'  => 'categories/category_type/1',
                    'icon'    => 'icon-07-airport-category',
                    'can' => ['view categories'],

                ],
                [
                    'text' => 'rent_car_category',
                    'url'  => 'categories/category_type/3',
                    'icon'    => 'icon-08-rental-car',
                    'can' => ['view categories'],

                ],
                [
                    'text' => 'rent_lemo_category',
                    'url'  => 'categories/category_type/4',
                    'icon'    => 'icon-08-rental-lemo',
                    'can' => ['view categories'],

                ],
                [
                    'text' => 'smart_car_category',
                    'url'  => 'categories/category_type/5',
                    'icon'    => 'icon-09-smart-car',
                    'can' => ['view categories'],

                ],
            ],
        ],
        [
            'text' => 'branches',
            'route'  => 'branches.index',
            'icon'    => 'icon-10-branch',
            'can' => ['view branch'],

        ],
         /*[
            'text' => 'services',
            'route'  => 'services.service.index',
            'can' => ['view services'],
        ],*/
        [
            'text'    => 'cars',
            'icon'    => 'icon-11-cars',
             'can' => ['view cars'],
            'submenu' => [
               /*  [
                    'text' => 'taxi_cars',
                    'url'  => 'cars/cars_type/2',
                    'can' => ['view cars'],

                ], */
                [
                    'text' => 'rental_cars',
                    'url'  => 'cars/cars_type/3',
                    'can' => ['view cars'],

                ],
                /* [
                    'text' => 'rental_lemo',
                    'url'  => 'cars/cars_type/4',
                    'can' => ['view cars'],

                ], */
                [
                    'text' => 'smart_cars',
                    'url'  => 'cars/cars_type/5',
                    'can' => ['view cars'],

                ],
                [
                    'text' => 'airport_cars',
                    'url'  => 'cars/cars_type/1',
                    'can' => ['view cars'],

                ],
            ],
        ],
        [
            'text'    => 'car_rental',
            'route'  => 'car_rentals.index',
            'icon'    => 'icon-12-car-rental-booking',
            'can' => ['view booking'],
        ],
        [
            'text'    => 'trips',
            'icon'    => 'icon-13-trips',
	    'can' => ['view trips'],
            'submenu' => [
                [
                    'text' => 'all_trips',
                    'route'  => 'trip.index',
                    'can' => ['view trips'],

                ],
                [
                    'text' => 'now_trips',
                    'url'  => 'trips/trip_type/1',
                    'can' => ['view trips'],

                ],
                [
                    'text' => 'later_trips',
                    'url'  => 'trips/trip_type/2',
                    'can' => ['view trips'],

                ],
            ],
        ],
        /* [
            'text' => 'real_time',
            'url'  => '#',
            'icon'    => 'icon-14-real-time-map',
            'can' => ['view real_time'],

        ], */
        [
            'text'    => 'wallet',
            'icon'    => 'icon-25-wallets',
            'can' => ['view wallet'],
            'submenu' => [
                [
                    'text' => 'customer_wallet',
                    'url'  => 'wallets/wallet_type/4',
                    'icon'    => 'icon-16-customer-wallet',
                    'can' => ['view wallet'],

                ],
                [
                    'text' => 'driver_wallet',
                    'url'  => 'wallets/wallet_type/3',
                    'icon'    => 'icon-17-driver-wallet',
                    'can' => ['add wallet'],

                ],
                [
                    'text' => 'transactions',
                    'route'  => 'transaction.index',
                    'icon'    => 'icon-26-transactions',
                    'can' => ['view wallet'],

                ],
            ],
        ],
        /* [
            'text' => 'earnings',
            'url'  => '#',
            'icon'    => 'icon-19-earnings',
            'can' => ['view earnings'],

        ], */
        [
            'text' => 'reports',
            'icon'    => 'icon-20-reports',
             'can' => ['view reports'],
            'submenu' => [
                [
                    'text' => 'users',
                    'route'  => 'users.reports.listing',
                    'can' => ['view reports'],
                ],
                [
                    'text' => 'trips',
                    'route'  => 'trips.reports.listing',
                    'can' => ['view reports'],
                ],
               /* [
                    'text' => 'bookings',
                    'route'  => 'bookings.reports.listing',
                    'can' => ['view reports'],
                ],*/
               [
                    'text' => 'car_retnals',
                    'route'  => 'car_rentals.reports.listing',
                    'can' => ['view reports'],
                ],
                [
                    'text' => 'cars',
                    'route'  => 'cars.reports.listing',
                    'can' => ['view reports'],
                ],
                [
                    'text' => 'wallets',
                    'route'  => 'wallets.reports.listing',
                    'can' => ['view reports'],
                ],
                [
                    'text' => 'transactions',
                    'route'  => 'transactions.reports.listing',
                    'can' => ['view reports'],
                ],
                [
                    'text' => 'branches',
                    'route'  => 'branches.reports.listing',
                    'can' => ['view reports'],
                ],
                [
                    'text' => 'coupons',
                    'route'  => 'coupons.reports.listing',
                    'icon'    => 'icon-28-coupon',
                    'can' => ['view reports'],
                ],
            ]
        ],
        [
            'text' => 'promo_codes',
            'route'  => 'coupon.index',
            'icon'    => 'icon-29-promo-codes',
            'can' => ['view promo_codes'],

        ],
        [
            'text' => 'notifications',
            'route'  => 'notification.index',
            'icon'    => 'icon-30-notifications',
            'can' => ['view notifications'],

        ],
        [
            'text' => 'ratings',
            'route'=> 'rating.index',
            'icon'=> 'icon-31-ratings',
            'can' => ['view ratings'],

        ],
        // [
        //     'text' => 'invoices',
        //     'url'=> '#',
        //     'icon'=> 'icon-32-invoices',
        //     'can' => ['view invoices'],

        // ],
         [
            'text' => 'user_management',
            'icon'    => 'icon-33-user-managment',
             'can' => ['view user_manage'],
            'submenu' => [
                // [
                //     'text' => 'users',
                //     'route'  => 'users.user.index',
                //     'icon'    => 'icon-34-users',
                //     'can' => ['view user'],

                // ],
                [
                    'text' => 'permissions',
                    'route'  => 'permission.index',
                    'icon'    => 'icon-35-permissions',
                    'can' => ['view user_manage'],

                ],
                [
                    'text'    => 'user_admin',
                    'route'  => 'user_admin.index',
                    'icon'    => 'icon-36-admin-users',
                    'can' => ['view user_manage'],
                ],
            ],
        ],
       
        [
            'text'    => 'settings',
            'icon'    => 'icon-37-settings',
             'can' => ['view setting'],
            'submenu' => [
                [
                    'text' => 'general',
                    'route'  => 'setting.general',
                    'icon'    => 'icon-38-general-settings',
                    'can' => ['view setting'],

                ],
                [
                    'text' => 'country',
                    'route'  => 'countries.country.index',
                    'icon'    => 'icon-39-country-settings',
                    'can' => ['view setting'],

                ],
                 [
                    'text'    => 'privacy_policy',
                    'url'  => '/pages/privacy',
                    'icon'    => 'icon-45-privacy-policy-settings',
                    'can' => ['view setting'],
                ],
                [
                    'text' => 'terms_condition',
                    'url'  => '/pages/terms',
                    'icon'    => 'icon-46-terms-and-conditions-settings',
                    'can' => ['view setting'],
                ],
                [
                    'text' => 'city',
                    'route'  => 'cities.city.index',
                    'icon'    => 'icon-40-city-settings',
                    'can' => ['view city'],

                ],
                [
                    'text' => 'payment',
                    'route'  => 'paymentmethod.index',
                    'icon'    => 'icon-44-payment-method-settings',
                    'can' => ['view setting'],

                ],
                [
                    'text' => 'car_make',
                    'route'  => 'make.index',
                    'icon'    => 'icon-41-car-brand-settings',
                    'can' => ['view setting'],

                ],
                [
                    'text' => 'car_type',
                    'route'  => 'cartype.index',
                    'icon'    => 'icon-42-car-sizes-settings',
                    'can' => ['view setting'],

                ],
                [
                    'text' => 'fuel_types',
                    'route'  => 'fuel_types.fuel_type.index',
                    'icon'    => 'icon-43-fuel-type-settings',
                    'can' => ['view setting'],
                ]
               /* [
                    'text' => 'coupon',
                    'route'  => 'coupon.index',
                    'can' => ['view coupon'],

                ],*/
            ],
        ],
        /*
        [
            'text'    => 'bookings',
            'icon'    => 'far fa-fw fa-user',
            'submenu' => [
                [
                    'text' => 'all_bookings',
                    'route'  => 'booking.index',
                    'can' => ['view booking'],

                ],
                [
                    'text' => 'add_booking',
                    'route'  => 'booking.create',
                    'can' => ['add booking'],

                ],
                [
                    'text' => 'near_by_cars',
                    'url'  => '#',
                    'can' => ['add near_by_cars'],

                ],
            ],
        ],
        [
            'text'    => 'car',
            'icon'    => 'far fa fa-fw fa-taxi',
            'submenu' => [
                [
                    'text' => 'all_car',
                    'route'  => 'car.index',
                    'can' => ['view car'],

                ],
                [
                    'text' => 'add_car',
                    'route'  => 'car.create',
                    'can' => ['add car'],

                ],
            ],
        ],*/
        /*
        [
            'text' => 'stores',
            'route'  => 'stores.store.index',
            'can' => ['view stores'],
        ],
        [
            'header' => 'products',
            'can' => ['view categories'],
        ],
        [
            'text' => 'categories',
            'route'  => 'categories.category.index',
            'can' => ['view categories'],
        ], */
/*        [
            'header' => 'locations',
            'can' => ['view countries','view cities'],
        ],
        [
            'text' => 'countries',
            'route'  => 'countries.country.index',
            'can' => ['view countries'],
        ],
        [
            'text' => 'cities',
            'route'  => 'cities.city.index',
            'can' => ['view cities'],
        ],*/

        /*[
            'text'        => 'pages',
            'url'         => 'admin/pages',
            'icon'        => 'far fa-fw fa-file',
            'label'       => 4,
            'label_color' => 'success',
        ],
        ['header' => 'account_settings'],
        [
            'text' => 'profile',
            'url'  => 'admin/settings',
            'icon' => 'fas fa-fw fa-user',
        ],
        [
            'text' => 'change_password',
            'url'  => 'admin/settings',
            'icon' => 'fas fa-fw fa-lock',
        ],
        [
            'text'    => 'multilevel',
            'icon'    => 'fas fa-fw fa-share',
            'submenu' => [
                [
                    'text' => 'level_one',
                    'url'  => '#',
                ],
                [
                    'text'    => 'level_one',
                    'url'     => '#',
                    'submenu' => [
                        [
                            'text' => 'level_two',
                            'url'  => '#',
                        ],
                        [
                            'text'    => 'level_two',
                            'url'     => '#',
                            'submenu' => [
                                [
                                    'text' => 'level_three',
                                    'url'  => '#',
                                ],
                                [
                                    'text' => 'level_three',
                                    'url'  => '#',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'level_one',
                    'url'  => '#',
                ],
            ],
        ],
        ['header' => 'labels'],
        [
            'text'       => 'important',
            'icon_color' => 'red',
            'url'        => '#',
        ],
        [
            'text'       => 'warning',
            'icon_color' => 'yellow',
            'url'        => '#',
        ],
        [
            'text'       => 'information',
            'icon_color' => 'cyan',
            'url'        => '#',
        ],*/
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#612-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        // Comment next line out to remove the Gate filter.
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        //App\Filters\MyMenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#613-plugins
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ]
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],
];
