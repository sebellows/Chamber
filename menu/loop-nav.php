<?php if ( is_singular( 'post' ) ) : // If viewing a single post page. ?>

  <nav class="pager">
    <?php previous_post_link( '%link', '<span class="dir"><svg class="icon" m-Icon="chevron-left large" viewbox="0 0 32 32"><use xlink:href="#icon-chevron-left"></use></svg></span> <span class="pager-text">Previous Article</span><h4>%title</h4>', '%title' ); ?>
    <?php next_post_link(     '%link', '<span class="dir"><svg class="icon" m-Icon="chevron-right large" viewbox="0 0 32 32"><use xlink:href="#icon-chevron-right"></use></svg></span> <span class="pager-text">Next Article</span><h4>%title</h4></div>', '%title' ); ?>
  </nav><!-- .pager -->

<?php elseif ( is_home() || is_archive() || is_search() ) : // If viewing the blog, an archive, or search results. ?>

  <?php \Chamber\Theme\TemplateTags\post_pagination(); ?>

<?php endif; // End check for type of page being viewed. ?>
