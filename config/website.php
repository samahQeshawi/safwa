<?php

return [

    // Self
    // 'self' => [
    //     'layout' => 'default', // blank, default
    //     'fluid' => true, // true, false
    //     'rtl' => true, // true, false
    //     'template' => '', // true, false
    // ],

    // // Template
    // 'template' => 'template/basic/', // blank, default

    // // Base Layout
    // 'js' => [
    //     'breakpoints' => [
    //         'sm' => 576,
    //         'md' => 768,
    //         'lg' => 992,
    //         'xl' => 1200,
    //         'xxl' => 1200
    //     ],
    //     'colors' => [
    //         'theme' => [
    //             'base' => [
    //                 'white' => '#ffffff',
    //                 'primary' => '#6993FF',
    //                 'secondary' => '#E5EAEE',
    //                 'success' => '#1BC5BD',
    //                 'info' => '#8950FC',
    //                 'warning' => '#FFA800',
    //                 'danger' => '#F64E60',
    //                 'light' => '#F3F6F9',
    //                 'dark' => '#212121'
    //             ],
    //             'light' => [
    //                 'white' => '#ffffff',
    //                 'primary' => '#E1E9FF',
    //                 'secondary' => '#ECF0F3',
    //                 'success' => '#C9F7F5',
    //                 'info' => '#EEE5FF',
    //                 'warning' => '#FFF4DE',
    //                 'danger' => '#FFE2E5',
    //                 'light' => '#F3F6F9',
    //                 'dark' => '#D6D6E0'
    //             ],
    //             'inverse' => [
    //                 'white' => '#ffffff',
    //                 'primary' => '#ffffff',
    //                 'secondary' => '#212121',
    //                 'success' => '#ffffff',
    //                 'info' => '#ffffff',
    //                 'warning' => '#ffffff',
    //                 'danger' => '#ffffff',
    //                 'light' => '#464E5F',
    //                 'dark' => '#ffffff'
    //             ]
    //         ],
    //         'gray' => [
    //             'gray-100' => '#F3F6F9',
    //             'gray-200' => '#ECF0F3',
    //             'gray-300' => '#E5EAEE',
    //             'gray-400' => '#D6D6E0',
    //             'gray-500' => '#B5B5C3',
    //             'gray-600' => '#80808F',
    //             'gray-700' => '#464E5F',
    //             'gray-800' => '#1B283F',
    //             'gray-900' => '#212121'
    //         ]
    //     ],
    //     'font-family' => 'Tajawal'
    // ],

    // // Page loader
    // 'page-loader' => [
    //     'type' => '' // default, spinner-message, spinner-logo
    // ],

    // // Header
    // 'header' => [
    //     'self' => [
    //         'display' => true,
    //         'width' => 'fluid', // fixed, fluid
    //         'theme' => 'light', // light, dark
    //         'fixed' => [
    //             'desktop' => true,
    //             'mobile' => true
    //         ]
    //     ],

    //     'menu' => [
    //         'self' => [
    //             'display' => true,
    //             'layout'  => 'default', // tab, default
    //             'root-arrow' => false, // true, false
    //         ],

    //         'desktop' => [
    //             'arrow' => true,
    //             'toggle' => 'click',
    //             'submenu' => [
    //                 'theme' => 'light',
    //                 'arrow' => true,
    //             ]
    //         ],

    //         'mobile' => [
    //             'submenu' => [
    //                 'theme' => 'dark',
    //                 'accordion' => true
    //             ],
    //         ],
    //     ]
    // ],

    // // Subheader
    // 'subheader' => [
    //     'display' => true,
    //     'displayDesc' => true,
    //     'layout' => 'subheader-v1',
    //     'fixed' => true,
    //     'width' => 'fluid', // fixed, fluid
    //     'clear' => false,
    //     'layouts' => [
    //         'subheader-v1' => 'Subheader v1',
    //         'subheader-v2' => 'Subheader v2',
    //         'subheader-v3' => 'Subheader v3',
    //         'subheader-v4' => 'Subheader v4',
    //     ],
    //     'style' => 'solid' // transparent, solid. can be transparent only if 'fixed' => false
    // ],

    // // Content
    // 'content' => [
    //     'width' => 'fixed', // fluid, fixed
    //     'extended' => false, // true, false
    // ],

    // // Brand
    // 'brand' => [
    //     'self' => [
    //         'theme' => 'dark' // light, dark
    //     ]
    // ],

    // // Footer
    // 'footer' => [
    //     'width' => 'fluid', // fluid, fixed
    //     'fixed' => false
    // ],

    // // Extras
    // 'extras' => [

    //     // Search
    //     'search' => [
    //         'display' => true,
    //         'layout' => 'dropdown', // offcanvas, dropdown
    //         'offcanvas' => [
    //             'direction' => 'right'
    //         ],
    //     ],


    //     // Quick Actions
    //     'quick-actions' => [
    //         'display' => true,
    //         'layout' => 'dropdown', // offcanvas, dropdown
    //         'dropdown' => [
    //             'style' => 'dark' // light|dark
    //         ],
    //         'offcanvas' => [
    //             'direction' => 'right'
    //         ]
    //     ],

    //     // Languages
    //     'languages' => [
    //         'display' => true
    //     ],

    //     // Scrolltop
    //     'scrolltop' => [
    //         'display' => true
    //     ]
    // ],

    // Assets
    'resources' => [
        'fonts' => [
            'google' => [
                'families' => [
                    'Tajawal:300,400,500,600,700'
                ]
            ]
        ],
        'css' => [
            'css/all.css',
            'css/bootstrap.min.css',
            'css/font-styles.css',
            'css/style.css',
            'css/mdtimepicker.css',
            'css/immersive-slider.css',
            // 'css/slider-csss.css',
        ],
        'js' => [
            // Theme Initialization Files ***
            'js/all.js',
            'js/bootstrap.min.js',
            'js/mdtimepicker.js',
            'js/jquery.immersive-slider.js',
        ],
    ],

];
