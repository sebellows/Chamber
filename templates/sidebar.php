
<?php
    $sidebars = (new \Chamber\Config)->get('sidebars');

    if ( is_front_page() ) {
        dynamic_sidebar('sidebar-primary');
    }

    foreach ($sidebars as $sidebar) {
        if ( is_page( $sidebar ) ) {
            dynamic_sidebar('sidebar-' . $sidebar);
        }
    }
?>
