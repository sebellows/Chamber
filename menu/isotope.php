<?php
/**
 * Template part for displaying Attractions posts in an Isotope application.
 *
 * @package chamber
 */

function chamber_term_icon( $term ) {
	switch ( $term ) {
		case 'arts-and-culture':
			echo 'arts-and-culture';
			break;
		case 'indoor-recreation':
			echo 'buildings';
			break;
		case 'outdoor-recreation':
			echo 'golf';
			break;
		case 'lodging':
			echo 'lodging';
			break;
		case 'shopping':
			echo 'shopping-bag';
			break;
		case 'dining':
			echo 'dining';
			break;
	}
}

if ( taxonomy_exists( 'attraction_category' ) ) :

	$args = [
		'taxonomy'   => 'attraction_category',
		'orderby'    => 'id',
		'parent'     => 0,
		'child_of'   => 0,
		'number'     => 6,
		'hide_empty' => 0
	];

	$terms = get_terms( $args );

	?>

    <header class="isotope-header" m-UI="cvb">

        <div class="isotope-hgroup">
            <h1>Things to do in
                <wbr>
                Flint&nbsp;&amp;&nbsp;Genesee
            </h1>

            <p class="lead">
                There is a lot to explore, see, and do here.<br/>
                You can filter activities by what you want to do, see them all, or view a <a href="<?php echo site_url( 'visit' ); ?>" alt="Complete listing of attractions">complete listing</a>!
            </p>
        </div>

        <menu class="isotope-sortable-menu">
			<?php foreach ( $terms as $term ) { ?>
                <a href="#" data-filter=".<?= $term->taxonomy . '-' . $term->slug; ?>">
			<span class="icon" m-Icon="large">
				<svg role="presentation" viewbox="0 0 32 32">
					<use xlink:href="#icon-<?= chamber_term_icon( $term->slug ); ?>"></use>
				</svg>
			</span>
					<?= $term->name; ?>
                </a>
			<?php } ?>
            <a href="#" data-filter="*" class="is-selected">
			<span class="icon" m-Icon="large">
				<svg role="presentation" viewbox="0 0 32 32">
					<use xlink:href="#icon-bullet-list"></use>
				</svg>
			</span>
                All
            </a>
        </menu>

    </header> <!-- end isotope-header -->

<?php endif; ?>
