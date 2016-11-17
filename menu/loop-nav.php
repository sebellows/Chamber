<?php if ( is_home() || is_archive() || is_search() && ! is_post_type_archive('person') ) : // If viewing the blog, an archive, or search results. ?>

  <?php \Chamber\Theme\TemplateTags\post_pagination(); ?>

<?php endif; // End check for type of page being viewed. ?>
