<?php

namespace Chamber\Theme;

/**
 * Shortcodes for custom post types.
 *
 * @package    Chamber Theme
 * @author     Joel Howard <joelhoward@github.com>
 * @author     Sean Bellows <sebellows@github.com>
 * @copyright  Copyright (c) 2016, Sean Bellows
 * @link       https://github.com/sebellows/chamber
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 */
class Shortcodes {

    /**
     * Register the shortcodes.
     */
    public function __construct() {}

    /**
     * Boot the shortcodes.
     */
    public function boot()
    {
        add_shortcode('person-text', [ $this, 'person_text' ]);
        add_shortcode('person-profile', [ $this, 'person_profile' ]);
        add_shortcode('attraction', [ $this, 'attraction' ]);
    }

    public function person_text($arg) {
        $this->get_data($arg['id']);

        if(get_field('people_first_name')) {

            return get_template_part( 'templates/content/person' );
        }
        else {
            return "Person not found!";
        }
    }

    public function person_profile($arg) {
        $this->get_data( $arg['id'] );

        if(get_field('people_first_name')) {

            return get_template_part( 'templates/content/person-text' );
        }
        else {
            return "Person not found!";
        }
    }

    public function attraction($arg) {
        $this->get_data($arg['id']);

        if(get_field('attr_city')) {

            return get_template_part( 'templates/content/archive', 'attraction' );
        }
        else {
            return "Attraction not found!";
        }
    }

    public function get_data($id) {
        global $post;
        $post = wp_get_single_post($id);

        return setup_postdata($post);
    }
}
