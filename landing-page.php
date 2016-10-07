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
    $landing_pages = (new \Chamber\Config)->get('landing-pages');

    if ( is_front_page() ) {
        dynamic_sidebar('sidebar-primary');
    }

    foreach ($landing_pages as $landing_page) {
        if ( is_page( $landing_page ) ) {
            dynamic_sidebar('sidebar-' . $landing_page);
        }
    }
?>

</section>
