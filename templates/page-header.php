<?php 

use Chamber\Theme\Titles;
use Chamber\Theme\Sidebar;
use Chamber\Theme\Attr;


?>

<div class="page-header">

	<h1><?= Titles\title(); ?></h1>

	<aside class="sidebar-vertical">
		<?php Sidebar::add('page-header'); ?>
	</aside>

</div>
