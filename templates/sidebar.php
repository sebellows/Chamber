
<?php
    $sidebars = (new \Chamber\Theme\Config)->get('sidebars');

    if ( is_front_page() ) { ?>
		<aside class="sidebar sidebar-primary">
        <?php dynamic_sidebar('sidebar-primary'); ?>
	    </aside><!-- /.sidebar -->
    <?php
	}

    foreach ($sidebars as $sidebar) {
        if ( is_page( $sidebar ) ) { ?>
        	<aside class="sidebar sidebar-<?php echo $sidebar; ?>">
            <?php dynamic_sidebar('sidebar-' . $sidebar); ?>
            </aside><!-- /.sidebar -->
        <?php
    	}
    }
?>
