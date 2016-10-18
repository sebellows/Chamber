<?php

namespace Chamber\Theme;

use Chamber\Theme\Config;
use Chamber\Theme\Helper;

class Menu
{
    protected static $sections = [];

    // Register wp_nav_menu() menus
    // http://codex.wordpress.org/Function_Reference/register_nav_menus
    public static function register_nav_menus() {
        register_nav_menus([
            'site_navigation'           => __('Site Navigation Menu', 'chamber'),
            'quick_links'               => __('Quick Links Menu', 'chamber'),
            'social_links'              => __('Social Links Menu', 'chamber'),
            'site_information'          => __('Site Information Menu', 'chamber'),
            'about_menu'                => __('About Menu', 'chamber'),
            'news_menu'                 => __('News Menu', 'chamber'),
            'cvb_menu'                  => __('CVB Menu', 'chamber'),
            'member_services_menu'      => __('Member Services Menu', 'chamber'),
            'economic_development_menu' => __('Economic Development Menu', 'chamber'),
            'education_training_menu'   => __('Education Training Menu', 'chamber'),
            'shared_services_menu'      => __('Shared Services Menu', 'chamber')
        ]);
    }

    /**
     * Function for grabbing a WP nav menu theme location name.
     *
     * @param  string  $location
     * @return string
     */
    public static function get_location( $location ) {

        $locations = get_registered_nav_menus();

        return isset( $locations[ $location ] ) ? $locations[ $location ] : '';
    }
}
