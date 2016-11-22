<?php

namespace Chamber\Theme;

/**
 * Sidebars.
 *
 * @package    Chamber Theme
 * @author     Sean Bellows <sebellows@github.com>
 * @copyright  Copyright (c) 2016, Sean Bellows
 * @link       https://github.com/sebellows/chamber
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 */
class Sidebar
{
	/**
	 * @var \Chamber\Theme\Theme $theme
	 */
	protected $theme;

	/**
	 * @var \Chamber\Theme\Config $config
	 */
	protected $config;

	/**
	 * Protected $sidebars.
	 * 
	 * @var array
	 */
	protected $data = [];

	/**
	 * Sidebars to create from config.
	 * 
	 * @var array
	 */
	protected $sidebars;

	/**
	 * Register the sidebars.
	 */
	public function __construct()
	{
		$this->config = new Config;
		$this->sidebars = $this->config->get('sidebars');
	}

	/**
	 * Register the sidebars.
	 * 
	 * @return void
	 */
	public function register()
	{
		add_action( 'widgets_init', [$this, 'registerSidebars'] );
		add_filter( 'dynamic_sidebar_params', [$this, 'index'] );
	}

	/**
	 * Wrapper function for WordPress' `register_sidebar()` function.
	 *
	 * @link   https://github.com/justintadlock/hybrid-core/blob/master/inc/functions-sidebars.php
	 * 
	 * @param  array $args
	 * @return string       Sidebar ID.
	 */
	public function registerSidebars()
	{
	    $data = ['name', 'id', 'class', 'container', 'title_tag'];
	    
	    foreach ( $this->sidebars as $sidebar => $value ) {
	        $name = ucwords(str_replace(['-', '_'], ' ', $sidebar)) . ' Sidebar';
	        $id = 'sidebar-' . $sidebar;

	        register_sidebar([
	            'name'          => __($name, 'chamber'),
	            'id'            => $id,
	            'before_widget' => '<'  . $value['container'] . ' class="' . $value['class']  . ' %1$s %2$s">',
	            'after_widget'  => '</' . $value['container'] . '>',
	            'before_title'  => '<'  . $value['title_tag'] . '>',
	            'after_title'   => '</' . $value['title_tag'] . '>'
	        ]);
	    }
	}

	/**
	 * Add a sidebar.
	 * 
	 * @param object $sidebar
	 */
	public function add( $sidebar = null )
	{
		if ( !is_string( $sidebar ) ) {
			throw new \Exception( '{$sidebar} is not a string!' );
		}

		if ( array_key_exists( $sidebar, $this->sidebars ) && $this->display() ) {
			return dynamic_sidebar( 'sidebar-' . $sidebar );
		}
	}

	/**
	 * Determine which pages should NOT display the sidebar.
	 *
	 * The sidebar will NOT be displayed if ANY `$tags` return true
	 * @link https://codex.wordpress.org/Conditional_Tags
	 *
	 * @param array $args  Conditional tags (i.e., `is_404()`, etc.)
	 *
	 * return mixed
	 */
	public static function display( array $tags = [] ) {
		$display;

		isset( $display) || $display = !in_array( true, [ $tags ] );

		return apply_filters( 'chamber/sidebar/display', $display );
	}

	/**
	 * Get the number of widgets in a sidebar and add a class to the parent container.
	 *
	 * @link: https://wordpress.stackexchange.com/questions/54162/get-number-of-widgets-in-sidebar
	 *
	 * @param  array $params
	 *
	 * @return  array
	 */
	public function index( $params )
	{
		$id = $params[0]['id'];

		$total = wp_get_sidebars_widgets();

		$widgets = count($total[$id]);

		$params[0]['before_widget'] = str_replace('class="', 'class="widget-1of' . $widgets . ' ', $params[0]['before_widget']);

		return $params;
	}

	/**
	 * Function for grabbing a dynamic sidebar name.
	 *
	 * @global array   $wp_registered_sidebars
	 * @param  string  $id
	 * 
	 * @return string
	 */
	public function get( $id ) {
		global $wp_registered_sidebars;

		return isset( $wp_registered_sidebars[ $id ] ) ? $wp_registered_sidebars[ $id ]['name'] : '';
	}

}

// (new Sidebar)->boot();
