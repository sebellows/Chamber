<?php

if ( ! is_front_page() && is_page_template( 'landing-page.php' ) ) :

?>

<nav id="deptNavigation" class="dept-navigation">

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