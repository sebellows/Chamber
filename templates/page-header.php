<?php 

use Chamber\Theme\Titles;
use Chamber\Theme\Sidebar;

?>

<div class="page-header">
	<h1><?= Titles\title(); ?></h1>

	<?php Sidebar::add('page-header'); ?>
</div>
