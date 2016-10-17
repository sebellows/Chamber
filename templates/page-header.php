<?php 

use Chamber\Theme\Titles;
use Chamber\Theme\Sidebar;
use Chamber\Theme\Attr;


?>

<div class="page-header">

	<h1><?= Titles\title(); ?></h1>

	<?php if (!is_archive() || !is_search() ) : ?>
		<?php if ( is_active_sidebar('sidebar-page-header') ) : ?>
	
		<aside class="sidebar-vertical">
			<?php dynamic_sidebar( 'sidebar-page-header' ); ?>
		</aside>

		<?php endif; ?>
	<?php endif; ?>

</div>
