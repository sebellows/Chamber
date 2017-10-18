<?php

namespace Chamber\Theme;

use Chamber\Theme\Theme;

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
}

global $chamber_theme;

$chamber_theme = Theme::getInstance();
// dd($chamber_theme);
$chamber_theme->boot();

# Enable shortcodes in text widgets - Joel
add_filter('widget_text', 'do_shortcode');

# re-order search results to prioritize pages > posts
add_action('pre_get_posts', function ($query) {
    if ($query->is_search()) {
        $query->set('orderby', 'post_type');
        $query->set('order', 'ASC');
    }
    return $query;

});
// dd(chamber('bootstrap'));
