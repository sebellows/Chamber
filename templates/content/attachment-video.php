<?php if ( is_attachment() ) : // If viewing a single attachment. ?>

	<article <?php hybrid_attr( 'post' ); ?>>

		<?php hybrid_attachment(); // Function for handling non-image attachments. ?>

		<header class="entry-header">
			<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<time <?php hybrid_attr( 'entry-published' ); ?>><?= get_the_date(); ?></time>
			<?php if ( function_exists( 'ev_post_views' ) ) ev_post_views( [ 'text' => '%s' ] ); ?>
			<?php edit_post_link(); ?>
		</footer><!-- .entry-footer -->

	</article><!-- .entry -->

	<div class="attachment-meta">

		<div class="media-info">

			<h3><?php _e( 'Video Info', 'chamber' ); ?></h3>

			<ul class="media-meta">
				<?php $pre = '<li><span class="prep">%s</span>'; ?>
				<?php hybrid_media_meta( 'length_formatted',  [ 'before' => sprintf( $pre, esc_html__( 'Run Time',      'chamber' ) ), 'after' => '</li>' ] ); ?>
				<?php hybrid_media_meta( 'dimensions',        [ 'before' => sprintf( $pre, esc_html__( 'Dimensions',    'chamber' ) ), 'after' => '</li>' ] ); ?>
				<?php hybrid_media_meta( 'file_type',         [ 'before' => sprintf( $pre, esc_html__( 'Type',          'chamber' ) ), 'after' => '</li>' ] ); ?>
				<?php hybrid_media_meta( 'file_name',         [ 'before' => sprintf( $pre, esc_html__( 'Name',          'chamber' ) ), 'after' => '</li>' ] ); ?>
				<?php hybrid_media_meta( 'mime_type',         [ 'before' => sprintf( $pre, esc_html__( 'Mime Type',     'chamber' ) ), 'after' => '</li>' ] ); ?>
			</ul>
		</div><!-- .media-info -->

	</div><!-- .attachment-meta -->

<?php else : // If not viewing a single attachment. ?>

	<article <?php hybrid_attr( 'post' ); ?>>

		<?php get_the_image( [ 'size' => 'fullwidth', 'order' => [ 'featured', 'attachment' ] ] ); ?>

		<header class="entry-header">
			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-summary' ); ?>>
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	</article><!-- .entry -->

<?php endif; // End single attachment check. ?>