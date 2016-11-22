<?php

namespace Chamber\Theme;

/**
 * Root relative URLs
 *
 * WordPress likes to use absolute URLs on everything - let's clean that up.
 * Inspired by http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 *
 * You can enable/disable this feature in functions.php (or lib/setup.php if you're using Sage):
 * add_theme_support('chamber-relative-urls');
 *
 * @package    Soil
 * @author     roots.io
 * @copyright  Copyright (c) Roots
 * @link       https://github.com/roots/soil
 */
class RelativeURLs {

    /**
     * Boot relative URLs.
     * 
     * @return void
     */
    public function boot() {
        if (is_admin() || isset($_GET['sitemap']) || in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php'])) {
            return;
        }

        $root_rel_filters = apply_filters('chamber/relative-url-filters', [
            'bloginfo_url',
            'the_permalink',
            'wp_list_pages',
            'wp_list_categories',
            'wp_get_attachment_url',
            'the_content_more_link',
            'the_tags',
            'get_pagenum_link',
            'get_comment_link',
            'month_link',
            'day_link',
            'year_link',
            'term_link',
            'the_author_posts_link',
            'script_loader_src',
            'style_loader_src'
        ]);

        $this->add_filters($root_rel_filters, [$this, 'root_relative_url']);

        add_filter('wp_calculate_image_srcset', function ($sources) {
            foreach ($sources as $source => $src) {
                $sources[$source]['url'] = $this->root_relative_url($src['url']);
            }
            return $sources;
        });
    }

    /**
     * Hooks a single callback to multiple tags
     */
    public function add_filters($tags, $function, $priority = 10, $accepted_args = 1) {
        foreach ((array) $tags as $tag) {
            add_filter($tag, $function, $priority, $accepted_args);
        }
    }

    /**
     * Make a URL relative
     */
    public function root_relative_url($input) {
        if (is_feed()) {
            return $input;
        }

        $url = parse_url($input);

        if (!isset($url['host']) || !isset($url['path'])) {
            return $input;
        }

        $site_url = parse_url(network_home_url());  // falls back to home_url

        if (!isset($url['scheme'])) {
            $url['scheme'] = $site_url['scheme'];
        }

        $hosts_match = $site_url['host'] === $url['host'];
        $schemes_match = $site_url['scheme'] === $url['scheme'];
        $ports_exist = isset($site_url['port']) && isset($url['port']);
        $ports_match = ($ports_exist) ? $site_url['port'] === $url['port'] : true;

        if ($hosts_match && $schemes_match && $ports_match) {
            return wp_make_link_relative($input);
        }

        return $input;
    }

}

// (new RelativeURLs)->boot();
