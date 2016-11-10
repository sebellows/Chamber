<?php
class chamberShortcodes {

    function __construct() {
        add_shortcode('person-text', array($this, 'person_text'));
        add_shortcode('person-profile', array($this, 'person_profile'));
        add_shortcode('attraction', array($this, 'attraction'));

    }

    function person_text($arg) {
        $this->get_data($arg['id']);

        if(get_field('people_first_name')) {

            return get_template_part( 'templates/content/person' );
        }
        else {
            return "Person not found!";
        }
    }

    function person_profile($arg) {
        $this->get_data($arg['id']);

        if(get_field('people_first_name')) {

            return get_template_part( 'templates/content/person-text' );
        }
        else {
            return "Person not found!";
        }
    }

    function attraction($arg) {
        $this->get_data($arg['id']);

        if(get_field('attr_city')) {

            return get_template_part( 'templates/content/archive', 'attraction' );
        }
        else {
            return "Attraction not found!";
        }
    }

    function get_data($id) {
        global $post;
        $post = wp_get_single_post($id);

        return setup_postdata($post);
    }
}

$shortcodes = new chamberShortcodes();
