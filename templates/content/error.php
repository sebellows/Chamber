<article <?php hybrid_attr( 'post' ); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'Nothing found', 'chamber' ); ?></h1>
	</header><!-- .entry-header -->

	<div <?php hybrid_attr( 'entry-content' ); ?>>
		<?= wpautop( __( 'Apologies, but no entries were found.', 'chamber' ) ); ?>
	</div><!-- .entry-content -->

</article><!-- .entry -->