<?php

namespace Chamber\Theme;

use Chamber\Theme\Config;

class Sidebar
{
	// protected static $sidebars = [];
	protected static $data = [];

	/**
	 * Register the sidebars.
	 */
	public static function init()
	{
		self::register();

		add_action('widgets_init', __CLASS__.'::register');
		add_filter('dynamic_sidebar_params', __CLASS__ . '::indexer');
	}

	/**
	 * Wrapper function for WordPress' `register_sidebar()` function.
	 *
	 * @link   https://github.com/justintadlock/hybrid-core/blob/master/inc/functions-sidebars.php
	 * 
	 * @param  array $args
	 * @return string       Sidebar ID.
	 */
	public static function register()
	{
	    $data = ['name', 'id', 'class', 'container', 'title_tag'];
	    $config = new Config;
	    
	    $sidebars = $config->get('sidebars');

	    foreach ( $sidebars as $sidebar => $value ) {
	        $name = ucwords(str_replace(['-', '_'], ' ', $sidebar)) . ' Sidebar';
	        $id   = 'sidebar-' . $sidebar;

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

	public static function add( $sidebar = null )
	{
		$sidebars = (new Config)->get('sidebars');

		if ( !is_string( $sidebar ) ) {
			throw new \Exception('{$sidebar} is not a string!');
		}

		if ( array_key_exists($sidebar, $sidebars) && self::display() ) {
			return dynamic_sidebar('sidebar-' . $sidebar);
		}
	}

	/**
	 * Determine which pages should NOT display the sidebar
	 */
	public static function display() {
		static $display;

		isset($display) || $display = !in_array(true, [
			// The sidebar will NOT be displayed if ANY of the following return true.
			// @link https://codex.wordpress.org/Conditional_Tags
			is_archive(),
			is_404(),
			// is_home(),
			// is_single(),
			is_page_template('app.php')
		]);

		return apply_filters( 'chamber/sidebar/display', $display );
	}

	/**
	 * Get the number of widgets in a sidebar and add a class to the parent container.
	 *
	 * @link: https://wordpress.stackexchange.com/questions/54162/get-number-of-widgets-in-sidebar
	 */
	public static function indexer( $params )
	{
		$sidebar_id = $params[0]['id'];

		$total_widgets = wp_get_sidebars_widgets();

		$sidebar_widgets = count($total_widgets[$sidebar_id]);

		$params[0]['before_widget'] = str_replace('class="', 'class="widget-1of' . $sidebar_widgets . ' ', $params[0]['before_widget']);

		return $params;
	}

	/**
	 * Function for grabbing a dynamic sidebar name.
	 *
	 * @global array   $wp_registered_sidebars
	 * @param  string  $sidebar_id
	 * @return string
	 */
	public static function get( $sidebar_id ) {
		global $wp_registered_sidebars;

		return isset( $wp_registered_sidebars[ $sidebar_id ] ) ? $wp_registered_sidebars[ $sidebar_id ]['name'] : '';
	}

}