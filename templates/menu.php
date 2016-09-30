<?php

if ( ! is_front_page() ) :

?>

<nav id="deptNavigation" class="dept-navigation">

<button class="close-button" data-close aria-controls="dept-navigation" aria-expanded="false" aria-label="Close reveal">
    <!-- <span aria-hidden="true">&times;</span> -->
    <svg role="presentation" viewbox="0 0 24 24"><use xlink:href="#close"></use></svg>
</button>

<?php
    if ( is_page( 'cvb' ) ) {
        dynamic_sidebar('cvb-navigation-menu');
    }
    if ( is_page( 'economic-development' ) ) {
    	dynamic_sidebar('development-navigation-menu');
    }
    if ( is_page( 'education-training' ) ) {
    	dynamic_sidebar('education-training-navigation-menu');
    }
    if ( is_page( 'member-services' ) ) {
    	dynamic_sidebar('member-services-navigation-menu');
    }
    if ( is_page( 'shared-services' ) ) {
    	dynamic_sidebar('shared-services-navigation-menu');
    }
?>

</nav><!-- END .dept-navigation-container -->

<?php endif; ?>