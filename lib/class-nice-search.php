<?php

namespace Chamber\Theme;

/**
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 *
 * @link http://txfx.net/wordpress-plugins/nice-search/
 *
 * You can enable/disable this feature in functions.php (or lib/setup.php if you're using Sage):
 * add_theme_support('soil-nice-search');
 *
 * @package    Soil
 * @author     roots.io
 * @copyright  Copyright (c) Roots
 * @link       https://github.com/roots/soil
 */
class NiceSearch {

    /**
     * Boot nice search.
     * 
     * @return void
     */
    public function boot() {
        add_action('template_redirect', [$this, 'redirect']);
        add_filter('wpseo_json_ld_search_url', [$this, 'rewrite']);
    }

    public function redirect() {
        global $wp_rewrite;
        if (!isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->get_search_permastruct()) {
            return;
        }

        $search_base = $wp_rewrite->search_base;
        if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false && strpos($_SERVER['REQUEST_URI'], '&') === false) {
            wp_redirect(get_search_link());
            exit();
        }
    }

    public function rewrite($url) {
        return str_replace('/?s=', '/search/', $url);
    }
}

// (new NiceSearch)->boot();
