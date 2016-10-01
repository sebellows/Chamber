<?php
/**
 * Template Name: Landing Page
 */
?>

<?php get_template_part('templates/content', 'landing'); ?>

<?php
    $slug = ! is_front_page() || is_home() ? basename(get_permalink()) : 'primary';
?>

<section class="sidebar sidebar-<?php echo $slug ?>">

<?php
    if ( is_front_page() ) {
        dynamic_sidebar('sidebar-primary');
    }
    elseif ( is_page( 'cvb' ) ) {
        dynamic_sidebar('sidebar-cvb');
    }
    elseif ( is_page( 'economic-development' ) ) {
        dynamic_sidebar('sidebar-economic-development');
    }
    elseif ( is_page( 'education-training' ) ) {
        dynamic_sidebar('sidebar-education-training');
    }
    elseif ( is_page( 'member-services' ) ) {
        dynamic_sidebar('sidebar-member-services');
    }
    elseif ( is_page( 'shared-services' ) ) {
        dynamic_sidebar('sidebar-shared-services');
    }
?>

</section>
