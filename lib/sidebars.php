<?php

namespace Chamber\Theme;

use Chamber\Theme\Config;

class Sidebars
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

		self::display();
	}

	/**
	 * Wrapper function for WordPress' `register_sidebar()` function.
	 *
	 * @link   https://github.com/justintadlock/hybrid-core/blob/master/inc/functions-sidebars.php
	 * 
	 * @param  array $args
	 * @return string       Sidebar ID.
	 */
	public static function register($class = '', $container = null, $title = null)
	{
	    $data = ['name', 'id', 'class', 'container', 'title'];
	    $config = new Config;
	    
	    $data['class']     = empty($class) ? 'widget' : $class;
	    $data['container'] = !is_null($container) ? $container : 'section';
	    $data['title']     = !is_null($title) ? $title : 'h3';

	    $globals = $config->get('global_sidebars');
	    $sections = $config->get('sidebars');

	    $sidebars = array_merge($globals, $sections);

	    foreach ($sidebars as $sidebar) {
	        $data['name'] = $sidebar === 'cvb' ? strtoupper(str_replace(['-', '_'], ' ', $sidebar)) . ' Sidebar' : ucwords(str_replace(['-', '_'], ' ', $sidebar)) . ' Sidebar';
	        $data['id']   = 'sidebar-' . $sidebar;

	        register_sidebar([
	            'name'          => __($data['name'], 'chamber'),
	            'id'            => $data['id'],
	            'before_widget' => '<'  . $data['container'] . ' class="' . $data['class'] . ' %1$s %2$s">',
	            'after_widget'  => '</' . $data['container'] . '>',
	            'before_title'  => '<'  . $data['title'] . '>',
	            'after_title'   => '</' . $data['title'] . '>'
	        ]);
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
			is_home(),
			is_single(),
			is_page_template('app.php')
		]);

		return apply_filters('chamber/sidebar/display', $display);
	}

	/**
	 * Get the number of widgets in a sidebar and add a class to the parent container.
	 *
	 * @link: https://wordpress.stackexchange.com/questions/54162/get-number-of-widgets-in-sidebar
	 */
	public static function indexer($params)
	{

		$sidebar_id = $params[0]['id'];

		$total_widgets = wp_get_sidebars_widgets();
		$sidebar_widgets = count($total_widgets[$sidebar_id]);

		$params[0]['before_widget'] = str_replace('class="', 'class="widget-1of' . $sidebar_widgets . ' ', $params[0]['before_widget']);

		return $params;
	}

}