<?php

namespace Chamber\Theme\Icons;
/**
 * SVG icons related functions and filters.
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

/**
 * Add SVG definitions to the footer.
 */
function include_svg_icons() {

    // Define SVG sprite file.
    $svg_icons = trailingslashit( get_template_directory() ) . 'public/images/svg-icons.svg';

    // If it exists, include it.
    if ( file_exists( $svg_icons ) ) {
        require_once( $svg_icons );
    }

}
add_action( 'wp_footer', __NAMESPACE__.'\include_svg_icons', 9999 );

/**
 * Return SVG markup.
 *
 * @param array $args {
 *     Parameters needed to display an SVG.
 *
 *     @type string $icon  Required SVG icon filename.
 *     @type string $title Optional SVG title.
 *     @type string $desc  Optional SVG description.
 * }
 * @return string SVG markup.
 */
function get_svg( $args = [] ) {

    // Make sure $args are an array.
    if ( empty( $args ) ) {
        return __( 'Please define default parameters in the form of an array.', __NAMESPACE__ );
    }

    // Define an icon.
    if ( false === array_key_exists( 'icon', $args ) ) {
        return __( 'Please define an SVG icon filename.', __NAMESPACE__ );
    }

    // Set defaults.
    $defaults = [
        'icon'        => '',
        'title'       => '',
        'desc'        => '',
        'aria_hidden' => true, // Hide from screen readers.
    ];

    // Parse args.
    $args = wp_parse_args( $args, $defaults );

    // Set aria hidden.
    $aria_hidden = '';

    if ( true === $args['aria_hidden'] ) {
        $aria_hidden = ' aria-hidden="true"';
    }

    // Set ARIA.
    $aria_labelledby = '';

    if ( $args['title'] && $args['desc'] ) {
        $aria_labelledby = ' aria-labelledby="title desc"';
    }

    // Begin SVG markup.
    $svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

    // If there is a title, display it.
    if ( $args['title'] ) {
        $svg .= '<title>' . esc_html( $args['title'] ) . '</title>';
    }

    // If there is a description, display it.
    if ( $args['desc'] ) {
        $svg .= '<desc>' . esc_html( $args['desc'] ) . '</desc>';
    }

    // Use absolute path in the Customizer so that icons show up in there.
    if ( is_customize_preview() ) {
        $svg .= '<use xlink:href="' . trailingslashit( get_template_directory_uri() ) . 'public/images/wp-svg-icons.svg' . '#icon-' . esc_html( $args['icon'] ) . '"></use>';
    } else {
        $svg .= '<use xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use>';
    }

    $svg .= '</svg>';

    return $svg;

}

/**
 * Display SVG icons in social links menu.
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function nav_menu_social_icons( $item_output, $item, $depth, $args ) {

    // Get supported social icons.
    $social_icons = social_links_icons();

    // Change SVG icon inside social links menu if there is supported URL.
    if ( 'social' === $args->theme_location ) {
        foreach ( $social_icons as $attr => $value ) {
            if ( false !== strpos( $item_output, $attr ) ) {
                $item_output = str_replace( $args->link_after, '</span>' . get_svg( [ 'icon' => esc_attr( $value ) ] ), $item_output );
            }
        }
    }

    return $item_output;

}
add_filter( 'walker_nav_menu_start_el', __NAMESPACE__.'\nav_menu_social_icons', 10, 4 );

/**
 * Add dropdown icon if menu item has children.
 *
 * @param  string $title The menu item's title.
 * @param  object $item  The current menu item.
 * @param  array  $args  An array of wp_nav_menu() arguments.
 * @param  int    $depth Depth of menu item. Used for padding.
 * @return string $title The menu item's title with dropdown icon.
 */
function dropdown_icon_to_menu_link( $title, $item, $args, $depth ) {

    if ( 'top' === $args->theme_location ) {
        foreach ( $item->classes as $value ) {
            if ( 'menu-item-has-children' === $value || 'page_item_has_children' === $value ) {
                $title = $title . get_svg( [ 'icon' => 'expand' ] );
            }
        }
    }

    return $title;

}
add_filter( 'nav_menu_item_title', __NAMESPACE__.'\dropdown_icon_to_menu_link', 10, 4 );

/**
 * Returns an array of supported social links (URL and icon name).
 *
 * @return array $social_links_icons
 */
function social_links_icons() {

    // Supported social links icons.
    $social_links_icons = array(
        'facebook.com'    => 'facebook',
        'flickr.com'      => 'flickr',
        'plus.google.com' => 'google-plus',
        'github.com'      => 'github',
        'instagram.com'   => 'instagram',
        'linkedin.com'    => 'linkedin',
        'mailto:'         => 'email',
        'pinterest.com'   => 'pinterest',
        'skype:'          => 'skype',
        'soundcloud.com'  => 'soundcloud',
        'tumblr.com'      => 'tumblr',
        'twitter.com'     => 'twitter',
        'vimeo.com'       => 'vimeo',
        'wordpress.org'   => 'wordpress',
        'youtube.com'     => 'youtube',
    );

    return apply_filters( 'chamber/icons/social', $social_links_icons );

}