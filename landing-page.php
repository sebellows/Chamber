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

</section>
