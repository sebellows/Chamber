<?php
/**
 * Template part for displaying Attractions posts in an Isotope application.
 * 
 * @package chamber
 */

use Chamber\Theme\Config;
use Chamber\Theme\Icon;

$config = new Config;
$isotopes = $config->get('isotope');

foreach ($isotopes as $key => $value) {
	$posttype = $key;
	$taxonomy = $value;

	if ( taxonomy_exists($taxonomy) ) :
		$menu_items = $config->get($posttype);

?>

<header class="isotope-header" m-UI="cvb">

	<div class="isotope-hgroup">
		<h1>Things to do in <wbr>Flint&nbsp;&amp;&nbsp;Genesee</h1>
		
		<p class="lead">There is a lot to explore, see, and do here. You can filter activities by what you want to do or see them all!</p>
	</div>

	<menu class="isotope-sortable-menu">
		<?php foreach($menu_items as $menu_item) { 
			$term  = array_get($menu_item, 'term');
			$label = array_get($menu_item, 'label');
			$icon  = array_get($menu_item, 'icon');
		?>
		<a href="javascript:void(0)" data-filter=".<?php echo $taxonomy . '-' . $term; ?>">
			<svg class="icon" m-Icon="large" role="presentation" viewbox="0 0 32 32">
				<use xlink:href="#icon-<?php echo $icon; ?>"></use>
			</svg>
			<?php echo $label; ?>
		</a>
		<?php } ?>
		<a href="javascript:void(0)" data-filter="*" class="is-selected">
			<svg class="icon" m-Icon="large" role="presentation" viewbox="0 0 32 32">
				<use xlink:href="#icon-all"></use>
			</svg>
			All
		</a>
	</menu>

</header> <!-- end isotope-header -->

	<?php
	endif;
}
