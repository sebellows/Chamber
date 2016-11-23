<?php 
?>

<div class="page-header">

	<h1><?= chamber_title(); ?></h1>

	<?php if (!is_archive() || !is_search() ) : ?>
		<?php if ( is_active_sidebar('page-header') ) : ?>
	
		<aside class="list-box">
			<?php chamber('sidebar')->add( 'page-header' ); ?>
		</aside>

		<?php endif; ?>
	<?php endif; ?>

</div>
