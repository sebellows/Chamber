<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Department names
    |--------------------------------------------------------------------------
    |
    | Individual breakdown of organization. These names will be used to 
    | organize employees, create menus, and register pages.
    |
    */
    'departments' => [
        'executive',
        'communications',
        'convention & visitors bureau',
        'economic development',
        'education & training',
        'grants',
        'human resources',
        'information technology',
        'marketing',
        'member services',
        'operations',
        'shared services',
        'contract employees & consultants'
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Embedded font families from Google Fonts (https://fonts.google.com).
    | @see lib/Setup.php
    |
    */
    'fonts' => [
        'Roboto:400italic,700italic,400,700',
        'Roboto Slab:400,700'
    ],

    /*
    |--------------------------------------------------------------------------
    | Site Menus
    |--------------------------------------------------------------------------
    |
    | Menus registered for use in the site. This includes main navigation,
    | sub-site navigation, and complimentary menus for services.
    | @see lib/Setup.php
    |
    */
    'menus' => [
        'site_navigation',  // @header.php
        'quick_links',      // @sidebar-primary
        'site_information', // @footer.php]
        'social_links',     // @post-footer
        'about_menu',
        'news_menu',
        'cvb_menu',
        'member_services_menu',
        'economic_development_menu',
        'education_training_menu',
        'shared_services_menu'
    ],

    /*
    |--------------------------------------------------------------------------
    | Post Formats
    |--------------------------------------------------------------------------
    |
    | Post formats to be enabled in WordPress.
    | @see lib/Setup.php
    |
    */
    'post-formats' => [
        'aside',
        'audio',
        'chat',
        'gallery',
        'image',
        'link',
        'quote',
        'status',
        'video'
    ],

    /*
    |--------------------------------------------------------------------------
    | Post Types
    |--------------------------------------------------------------------------
    |
    | Custom post types registered in the Chamber-CMS plugin.
    | @see plugins/chamber-cms/app/PostTypes/
    |
    */
    'posttypes' => [
        'attraction',
        'business',
        'community',
        'person',
        'project',
        'testimonial'
    ],

    /*
    |--------------------------------------------------------------------------
    | Sidebars
    |--------------------------------------------------------------------------
    |
    | The registered sidebars used in the site. They are used to display
    | widgets and menus.
    | @see lib/Setup.php
    |
    */
    'sidebars' => [
        // news uses the home.php template
        'column' => [
            'class' => 'widget column-widget',
            'container' => 'section',
            'title_tag' => 'h3',
            'index' => true
        ],
        // footer widgets
        'footer' => [
            'class' => 'widget footer-widget',
            'container' => 'section',
            'title_tag' => 'h4',
            'index' => true
        ],
        // top-level navigation menu container
        'navigation' => [
            'class' => 'section-navigation',
            'container' => 'nav',
            'title_tag' => 'h2',
            'index' => false
        ],
        // front page
        'primary' => [
            'class' => 'widget',
            'container' => 'section',
            'title_tag' => 'h3',
            'index' => true
        ],
        // displays social at bottom of single post
        'post-footer' => [
            'class' => 'widget post-footer-widget',
            'container' => 'section',
            'title_tag' => 'h3',
            'index' => false
        ],
        // for displaying either a subsidiary menu or share buttons on default page template
        'page-header' => [
            'class' => 'subsidiary-navigation',
            'container' => 'nav',
            'title_tag' => 'h3',
            'index' => false
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Taxonomies
    |--------------------------------------------------------------------------
    |
    | Custom taxonomies registered in the Chamber-CMS plugin.
    | @see plugins/chamber-cms/app/PostTypes/
    |
    */
    'taxonomies' => [
        'attraction-category',
        'business_type',
        'department'
    ]

];
