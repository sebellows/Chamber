<?php

if ( ! function_exists('chamber'))
{
    /**
     * Gets the oni container.
     *
     * @param  string $binding
     * @return string
     */
    function chamber($binding = null)
    {
        $instance = Chamber\Theme\Theme::getInstance();
        if ( ! $binding)
        {
            return $instance;
        }
        return $instance[$binding];
    }
}

function chamber_template() {
    return \Chamber\Theme\Wrapper\sage_template_path();
}

function chamber_template_part($path = '') {
    return \Chamber\Theme\Wrapper\sage_sidebar_path($path);
}

if ( ! function_exists('chamber_asset_path')) {
	/**
	 * Get the asset path.
	 * 
	 * @return string  The asset path
	 */
	function chamber_asset_path() {
		return trailingslashit( get_template_directory_uri() . '/public' );
	}
}

if ( ! function_exists('chamber_color')) {
	/**
	 * Theme color scheme that is used by the ACF Restrict Color Picker plugin.
	 * 
	 * @param  string $color The key/name in the `$colors` array
	 * @return string        The corresponding value
	 */
	function chamber_color($color) {
		$colors = [
			'paper'          => '#fefefe',
			'neutral light'  => '#cfd8dc',
			'neutral medium' => '#45555c',
			'neutral dark'   => '#263238',
			'alert'          => '#ec5840',
			'success'        => '#3adb76',
			'warning'        => '#ffae00',
			'primary'        => '#005f96',
			'brand'          => '#0f4466',
			'brand light'    => '#009dd7',
			'brand medium'   => '#005f96',
			'brand dark'     => '#003355',
			'cvb'            => '#eb6b23',
			'development'    => '#84c256',
			'education'      => '#4a54aa',
			'members'        => '#438fc7',
			'shared'         => '#a71930'
		];

		return collect($colors)->search($color);
	}
}

if ( ! function_exists('chamber_icon')) {
	/**
	 * Return an SVG icon.
	 *
	 * @param string $icon
	 * @param string $size  The icon size (xsmall, small, medium, large, xlarge)
	 * @return string SVG markup.
	 */
	function chamber_icon( $icon = '', $size = 'small' ) {
	    $svg .= '<span class="icon" m-Icon="' . esc_attr( $icon ) . ' ' . esc_attr( $size ) . '">';
	    $svg .= '<svg viewbox="' . esc_attr( $size ) . '" aria-hidden="true"  aria-labelledby="title" role="presentation">';
	    $svg .= '<use xlink:href="#icon-' . esc_html( $icon ) . '"></use>';
	    $svg .= '</svg>';
	    $svg .= '</span>';

	    return $svg;
	}
}

if ( ! function_exists('chamber_title')) {
	/**
	 * Page titles
	 * 
	 * @return string  The title
	 */
	function chamber_title() {
		if (is_home()) {
			if (get_option('page_for_posts', true)) {
				return get_the_title(get_option('page_for_posts', true));
			} else {
				return __('Latest Posts', 'chamber');
			}
		} elseif (is_archive()) {
			return get_the_archive_title();
		} elseif (is_search()) {
			return sprintf(__('Search Results for %s', 'chamber'), get_search_query());
		} elseif (is_404()) {
			return __('404: PAGE NOT FOUND!', 'chamber');
		} else {
			return get_the_title();
		}
	}
}
