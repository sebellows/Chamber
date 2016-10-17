<?php

// Check for breadcrumb support.
if ( function_exists( 'breadcrumb_trail' ) ) : 

if ( !is_archive( 'attraction' ) ) :

breadcrumb_trail(
    [
		'container'     => 'nav', 
		'separator'     => '', 
		'show_browse'   => false,
		'show_on_front' => false,
    ]
);

endif;
endif;
