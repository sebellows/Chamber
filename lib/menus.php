<?php

namespace Chamber\Theme;

use Chamber\Theme\Config;
use Chamber\Theme\Helper;

class Menus
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
            'economic_development_menu' => __('Development Menu', 'chamber'),
            'education_training_menu'   => __('Education Training Menu', 'chamber'),
            'shared_services_menu'      => __('Shared Services Menu', 'chamber')
        ]);
    }

    /**
     * Make the top-level navigation bars.
     * 
     * @param  integer $post_id because this needs to be called in the loop
     * @param  string  $class   the class for the container set by \Chamber\Theme\NavWalker
     * @return mixed            the menu object
     */
    public static function make_top_level_navs($post_id, $class = '') {
        if ( ! is_front_page() && ! is_archive() ) :

            $sections = array_keys((new Config)->get('sections'));
            
            $current = Helper::get_current_page_name();

            foreach ($sections as $section) {

                // Check if name of current page OR if the name of the current page's parent matches config section 
                if ( $current === $section || get_post(wp_get_post_parent_id($post_id))->post_name === $section ) :

                    // if so then display the section navigation bar
                    
                    // If user has assigned menu to this location then display it
                    if ( has_nav_menu( $section . '_menu' ) ) :
                    ?>
                        <?php
                        wp_nav_menu(
                            [ 
                                'theme_location' => $section . '_menu', 
                                'menu_class' => 'menu',
                                'menu_id' => $section . '-menu',
                                'container_class' => $class
                            ] 
                        );
                        ?>

                    <?php
                    endif;
                endif;
            }

        endif;
    }
}
