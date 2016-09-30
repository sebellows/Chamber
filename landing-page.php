<?php
/**
 * Template Name: Landing Page
 */
?>

<?php get_template_part('templates/content', 'landing'); ?>

<?php
	if ( is_page( 'home' ) ) {
		'<aside class="sidebar sidebar-primary">' . dynamic_sidebar('sidebar-primary') . '</aside>';
	}
	if ( is_page( 'cvb' ) ) {
		'<aside class="sidebar cvb-sidebar">' . dynamic_sidebar('cvb-sidebar') . '</aside>';
	}
    if ( is_page( 'economic-development' ) ) {
    	'<aside class="sidebar development-sidebar">' . dynamic_sidebar('development-sidebar') . '</aside>';
    }
    if ( is_page( 'education-training' ) ) {
    	'<aside class="sidebar education-training-sidebar">' . dynamic_sidebar('education-training-sidebar') . '</aside>';
    }
    if ( is_page( 'member-services' ) ) {
    	'<aside class="sidebar member-services-sidebar">' . dynamic_sidebar('member-services-sidebar') . '</aside>';
    }
    if ( is_page( 'shared-services' ) ) {
    	'<aside class="sidebar shared-services-sidebar">' . dynamic_sidebar('shared-services-sidebar') . '</aside>';
    }
?>
