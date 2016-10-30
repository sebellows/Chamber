<?php if ( is_home() || is_archive() || is_search() ) : // If viewing the blog, an archive, or search results. ?>

  <?php \Chamber\Theme\TemplateTags\post_pagination(); ?>

<?php endif; // End check for type of page being viewed. ?>
