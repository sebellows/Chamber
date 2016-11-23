<?php

namespace Chamber\Theme;


/**
 * Clean up wp_head()
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS and JS from WP emoji support
 * Remove inline CSS used by Recent Comments widget
 * Remove inline CSS used by posts with galleries
 * Remove self-closing tag and change ''s to "'s on rel_canonical()
 *
 * You can enable/disable this feature in functions.php 
 * (or lib/setup.php if you're using Sage):
 * add_theme_support('chamber-clean-up');
 *
 * @package    Soil
 * @author     roots.io
 * @copyright  Copyright (c) Roots
 * @link       https://github.com/roots/soil
 */
class CleanUp 
{

    /**
     * Boot clean-up module.
     * 
     * @return void
     */
    public function boot()
    {
        add_filter('get_bloginfo_rss', [ $this, 'remove_default_description' ]);
        add_action('init', [ $this, 'head_cleanup' ]);

        # Remove the WordPress version from RSS feeds
        add_filter('the_generator', '__return_false');
        add_filter('language_attributes', [ $this, 'language_attributes' ]);
        add_filter('style_loader_tag', [ $this, 'clean_style_tag' ]);
        add_filter('script_loader_tag', [ $this, 'clean_script_tag' ]);
        add_filter('body_class', [ $this, 'body_class' ]);
        add_filter('embed_oembed_html', [ $this, 'embed_wrap' ]);
        add_action('admin_init', [ $this, 'remove_dashboard_widgets' ]);
        add_filter('get_avatar', [ $this, 'remove_self_closing_tags' ]); // <img />
        add_filter('comment_id_fields', [ $this, 'remove_self_closing_tags' ]); // <input />
        add_filter('post_thumbnail_html', [ $this, 'remove_self_closing_tags' ]); // <img />
    }

    public function head_cleanup() {
        // Originally from http://wpengineer.com/1438/wordpress-header/
        remove_action('wp_head', 'feed_links_extra', 3);
        add_action('wp_head', 'ob_start', 1, 0);
        add_action('wp_head', function () {
            $pattern = '/.*' . preg_quote(esc_url(get_feed_link('comments_' . get_default_feed())), '/') . '.*[\r\n]+/';
            echo preg_replace($pattern, '', ob_get_clean());
        }, 3, 0);
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'wp_shortlink_wp_head', 10);
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('use_default_gallery_style', '__return_false');
        add_filter('emoji_svg_url', '__return_false');

        global $wp_widget_factory;

        if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
            remove_action('wp_head', [$wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style']);
        }

        if (!class_exists('WPSEO_Frontend')) {
            remove_action('wp_head', 'rel_canonical');
            add_action('wp_head', [ $this, 'rel_canonical' ]);
        }
    }

    public function rel_canonical() {
        global $wp_the_query;

        if (!is_singular()) {
            return;
        }

        if (!$id = $wp_the_query->get_queried_object_id()) {
            return;
        }

        $link = get_permalink($id);
        echo "\t<link rel=\"canonical\" href=\"$link\">\n";
    }

    /**
     * Clean up language_attributes() used in <html> tag
     *
     * Remove dir="ltr"
     */
    public function language_attributes() {
        $attributes = [];

        if (is_rtl()) {
            $attributes[] = 'dir="rtl"';
        }

        $lang = get_bloginfo('language');

        if ($lang) {
            $attributes[] = "lang=\"$lang\"";
        }

        $output = implode(' ', $attributes);
        $output = apply_filters('chamber/language_attributes', $output);

        return $output;
    }

    /**
     * Clean up output of stylesheet <link> tags
     */
    public function clean_style_tag($input) {
        preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
        if (empty($matches[2])) {
            return $input;
        }
        // Only display media if it is meaningful
        $media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';
        return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
    }

    /**
     * Clean up output of <script> tags
     */
    public function clean_script_tag($input) {
        $input = str_replace("type='text/javascript' ", '', $input);
        return str_replace("'", '"', $input);
    }

    /**
     * Add and remove body_class() classes
     */
    public function body_class($classes) {
        // Add post/page slug if not present
        if (is_single() || is_page() && !is_front_page()) {
            if (!in_array(basename(get_permalink()), $classes)) {
                $classes[] = basename(get_permalink());
            }
        }

        // Remove unnecessary classes
        $home_id_class = 'page-id-' . get_option('page_on_front');
        $remove_classes = [
            'page-template-default',
            $home_id_class
        ];
        $classes = array_diff($classes, $remove_classes);

        return $classes;
    }

    /**
     * Wrap embedded media as suggested by Readability
     *
     * @link https://gist.github.com/965956
     * @link http://www.readability.com/publishers/guidelines#publisher
     */
    public function embed_wrap($cache) {
        return '<div class="entry-content-asset">' . $cache . '</div>';
    }

    /**
     * Remove unnecessary dashboard widgets
     *
     * @link http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
     */
    public function remove_dashboard_widgets() {
        remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
        remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
        remove_meta_box('dashboard_primary', 'dashboard', 'normal');
        remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
    }

    /**
     * Remove unnecessary self-closing tags
     */
    public function remove_self_closing_tags($input) {
        return str_replace(' />', '>', $input);
    }

    /**
     * Don't return the default description in the RSS feed if it hasn't been changed
     */
    public function remove_default_description($bloginfo) {
        $default_tagline = 'Just another WordPress site';
        return ($bloginfo === $default_tagline) ? '' : $bloginfo;
    }
}

// (new CleanUp)->boot();
