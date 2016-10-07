<?php

if ( ! is_front_page() && ! is_archive() ) :

    $sections = array_keys((new \Chamber\Config)->get('sections'));
	
	$current = \Chamber\Extras\get_current_page_name();

?>

<?php
foreach ($sections as $section) {
	// Check if name of current page OR if the name of the current page's parent matches config section 
    if ( $current === $section || get_post(wp_get_post_parent_id($post->ID))->post_name === $section ) :
    	// if so then display the section navigation bar
    	
	    // If user has assigned menu to this location then display it
    	if ( has_nav_menu( $section . '_menu' ) ) :
    ?>

		<nav class="section-navigation">
	    <?php wp_nav_menu( [ 'theme_location' => $section . '_menu', 'menu_class' => 'menu' ] ); ?>
	    </nav>

    <?php 
	    endif;
	endif;
}
?>

<?php endif; ?>