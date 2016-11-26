<?php

if ( is_home() || is_archive() || is_search()) {
    // don't display pagination for people
    if(!is_post_type_archive('person') && !is_post_type_archive('attraction')) {
        \Chamber\Theme\TemplateTags\post_pagination();
    }
}
