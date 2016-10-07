<?php

namespace Chamber;

use Chamber\Config;

class Menu
{
	
	protected $sections;
	
	protected $menus;
	
	protected $labels;

	public function __construct()
	{
		$this->sections = (new Config)->get('sections');

		$this->menus = array_keys($this->sections);

		$this->labels = array_values($this->sections);

		// add_action( 'init', [ $this, 'register' ] );
	}

	/**
	 * Add the menus.
	 * 
	 * @param string $suffix [description]
	 */
	public function add($suffix = '')
	{
		$nav = [];

		$suffix = !empty($suffix) ? '_' . $suffix : '';

		foreach ($this->menus as $menu) {
		    if ( is_page( $menu ) ) {
		        $nav = wp_nav_menu( [ 'theme_location' => snake_case($menu) . $suffix ] );
		    }
		}

		return $nav;
	}

	public function register()
	{
		register_nav_menus( $this->sections );
	}

}