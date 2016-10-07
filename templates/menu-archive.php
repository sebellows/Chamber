<?php
/**
 * Template part for displaying Attractions posts in an Isotope application.
 * 
 * @package chamber
 */

$terms = get_terms('attraction_category');

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
