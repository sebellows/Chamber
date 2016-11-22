<?php

namespace Chamber\Theme;

/**
 * Register and output menus.
 *
 * @package    Chamber Theme
 * @author     Sean Bellows <sean@seanbellows.com>
 * @copyright  Copyright (c) 2016, Sean Bellows
 * @link       https://github.com/sebellows/chamber
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 */
class Menu
{
    /**
     * @var \Chamber\Theme\Config $config
     */
    protected $config;

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
        $this->config = new Config;

        $this->menus = $this->config->get('menus');
        $this->names = $this->setNames();
    }

    /**
     * Register wp_nav_menu() menus
     *
     * @see http://codex.wordpress.org/Function_Reference/register_nav_menus
     */
    public function register() {
        $themeMenus = array_combine( $this->menus, $this->names );

        register_nav_menus( $themeMenus );
    }

    /**
     * Generate menu names from the menu IDs in `chamber.config.php`.
     * 
     * @param array $menus
     */
    public function setNames()
    {
        $names = [];

        foreach ( $this->menus as $menu ) {
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
    public function getLocation( $location ) {

        $locations = get_registered_nav_menus();

        return isset( $locations[ $location ] ) ? $locations[ $location ] : '';
    }
}
