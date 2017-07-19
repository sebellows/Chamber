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
class Shortcodes
{

    /**
     * Register the shortcodes.
     */
    public function __construct()
    {
    }

    /**
     * Boot the shortcodes.
     */
    public function boot()
    {
        add_shortcode('person-text', [$this, 'person_text']);
        add_shortcode('person-profile', [$this, 'person_profile']);
        add_shortcode('attraction', [$this, 'attraction']);
        add_shortcode('news-feed', [$this, 'news']);
    }

    public function person_text($arg)
    {
        $this->get_data($arg['id']);

        if (get_field('people_first_name')) {

            return get_template_part('templates/content/person');
        }else {
            return "Person not found!";
        }
    }

    public function get_data($id)
    {
        global $post;
        $post = wp_get_single_post($id);

        return setup_postdata($post);
    }

    public function person_profile($arg)
    {
        $this->get_data($arg['id']);

        if (get_field('people_first_name')) {

            return get_template_part('templates/content/person-text');
        }else {
            return "Person not found!";
        }
    }

    public function attraction($arg)
    {
        $this->get_data($arg['id']);

        if (get_field('attr_city')) {

            return get_template_part('templates/content/archive', 'attraction');
        }else {
            return "Attraction not found!";
        }
    }

    /**
     * Handles displying news articles with a shortcode by category.  defaults to five articles
     *
     * @author Joel Howard <joelhoward@gmail.com>
     * @param $arg
     * @return string
     */
    public function news($arg)
    {
        // set num of news items (optional)
        if (!isset($arg['items']) || !is_numeric($arg['items'])) {
            $arg['items'] = 5;
        }

        // check to ensure a category is set
        if (isset($arg['category']) && term_exists($arg['category'])) {
            // get our posts
            query_posts(array(
                'category-name'  => $arg['category'],
                'posts_per_page' => $arg['items'],
                'post_type'      => 'post',
                'orderby'        => 'id',
                'order'          => 'desc',
                'max_num_pages'  => 1
            ));
            if (have_posts()) {
                // buffer our output to be returned
                ob_start();
                while (have_posts()) {
                    the_post();
                    get_template_part('templates/content/post');
                }
                wp_reset_postdata();

                // return buffered output from template part
                return ob_get_clean();
            }else {
                return '<strong>No posts found for category:</strong> ' . $arg['category'];
            }

        }else {
            return '<strong>' . $arg['category'] . '</strong> is not a valid category.';
        }

    }
}
