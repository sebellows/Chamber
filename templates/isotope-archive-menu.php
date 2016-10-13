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
		// $terms = get_terms($taxonomy);
		$args = [
		    'taxonomy'     => $taxonomy,
		    'parent'        => 0,
		    'number'        => 6,
		    'hide_empty'    => false           
		];
		$terms = get_terms( $args );
?>

<header class="isotope-header" m-UI="cvb">

	<div class="isotope-hgroup">
		<h1>Things to do in <wbr>Flint&nbsp;&amp;&nbsp;Genesee</h1>
		
		<p class="lead">There is a lot to explore, see, and do here. You can filter activities by what you want to do or see them all!</p>
	</div>

	<menu class="isotope-sortable-menu">
		<?php foreach($terms as $term) { ?>
		<a href="javascript:void(0)" data-filter=".<?php echo $term->taxonomy . '-' . $term->slug; ?>">
			<svg class="icon" m-Icon="large" role="presentation" viewbox="0 0 32 32">
				<use xlink:href="#icon-<?php echo $term->slug; ?>"></use>
			</svg>
			<?php echo $term->name; ?>
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
