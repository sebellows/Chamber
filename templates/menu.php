<?php

if ( ! is_front_page() && ! is_archive() ) :

    $sections = array_keys((new \Chamber\Config)->get('sections'));
	
	$current = \Chamber\Extras\get_current_page_name();

?>

<?php
foreach ($sections as $section) {

    if ( $current === $section || get_post(wp_get_post_parent_id($post->ID))->post_name === $section ) :
    ?>

	<nav class="section-navigation">
    <?php wp_nav_menu( [ 'theme_location' => $section . '_menu' ] ); ?>
    </nav>

    <?php 
	endif;
}
?>

<?php endif; ?>