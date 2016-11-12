<?php

namespace Chamber\Theme;

use Chamber\Theme\Config;
use Chamber\Theme\Helper;

class Menu
{
    /**
     * The custom menus to register.
     * 
     * @var array
     */
    protected $menus = [];

    /**
     * The names of the menus.
     * 
     * @var array
     */
    protected $names = [];

    /**
     * The menu constructor.
     * 
     * @param array $menus
     */
    public function __construct()
    {
        $this->menus = (new Config)->get('menus');
        $this->names = $this->set_names( $this->menus );
    }

    /**
     * Register wp_nav_menu() menus
     *
     * @see http://codex.wordpress.org/Function_Reference/register_nav_menus
     */
    public function register() {
        $theme_menus = array_combine( $this->menus, $this->names );

        register_nav_menus( $theme_menus );
    }

    /**
     * Generate menu names from the menu IDs in `chamber.config.php`.
     * 
     * @param array $menus
     */
    public function set_names( $menus )
    {
        $names = [];

        foreach ( $menus as $menu ) {
            $names[] = __( title_case( str_replace( '_', ' ', $menu) ), 'chamber' );
        }

        return $names;
    }

    /**
     * Function for grabbing a WP nav menu theme location name.
     *
     * @param  string  $location
     * @return string
     */
    public function get_location( $location ) {

        $locations = get_registered_nav_menus();

        return isset( $locations[ $location ] ) ? $locations[ $location ] : '';
    }
}
