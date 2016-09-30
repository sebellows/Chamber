<?php

namespace Chamber\Colors;

/**
 * Custom search form to display in the site header.
 *
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @package chamber
 */

/* Start the Loop */
function get_search_form( $echo = true ) {
    /**
     * Fires before the search form is retrieved, at the start of get_search_form().
     *
     * @since 2.7.0 as 'get_search_form' action.
     * @since 3.6.0
     *
     * @link https://core.trac.wordpress.org/ticket/19321
     */
    do_action( 'pre_get_search_form' );
 
    $format = current_theme_supports( 'html5', 'search-form' ) ? 'html5' : 'xhtml';
 
    /**
     * Filters the HTML format of the search form.
     *
     * @since 3.6.0
     *
     * @param string $format The type of markup to use in the search form.
     *        Accepts 'html5', 'xhtml'.
     */
    $format = apply_filters( 'search_form_format', $format );
 
    $search_form_template = locate_template( 'searchform.php' );

    if ( '' != $search_form_template ) {
        ob_start();
        require( $search_form_template );
        $form = ob_get_clean();
    } else {
        <?= >
            <form role="search" method="get" id="searchform" class="searchform" action="' . esc_url( home_url( '/' ) ) . '">
                <div>
                    <label class="screen-reader-text" for="s">' . _x( 'Search for:', 'label' ) . '</label>
                    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
                    <input type="submit" id="searchsubmit" value="'. esc_attr_x( 'Search', 'submit button' ) .'" />
                </div>
            </form>
        <?= >
    }
 
    /**
     * Filters the HTML output of the search form.
     *
     * @since 2.7.0
     *
     * @param string $form The search form HTML output.
     */
    $result = apply_filters( 'get_search_form', $form );
 
    if ( null === $result )
        $result = $form;
 
    if ( $echo )
        echo $result;
    else
        return $result;
}
