<?php
/**
 * The template for displaying archive pages of custom post types.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Chamber
 */

// categories to pull from
$attractionCategories = array(
	'arts-and-culture',
	'dining',
	'indoor-recreation',
	'lodging',
	'outdoor-recreation',
	'shopping',
	'local-events'
);

// number of attractions per category
$numAttractions = 12;

// our initial query for finding featured categories
$initialParams = array(
	'post_type'           => 'attraction',
	'orderby'             => 'rand',
	'attraction_category' => '',
	'posts_per_page'      => 12,
	'meta_query'          => array(
		'relation' => 'AND',
		array(
			'key'     => 'attr_featured',
			'value'   => '1',
			'compare' => '='
		)
	)
);

$attractionsToDisplay = array();

function loopAttractions( $attractions ) {
	if ( $attractions->have_posts() ) {
		while ( $attractions->have_posts() ) : $attractions->the_post();
			get_template_part( 'templates/archive/attraction' );
		endwhile;
	}
}

?>

<div id="app" class="isotope-archive">
	<?php get_template_part( 'menu/isotope' ); ?>
    <div class="card-grid">

		<?php
		foreach ( $attractionCategories as $attractionCategory ) {
			$initialParams['attraction_category'] = $attractionCategory;
			$initialResults                       = new WP_Query( $initialParams );

			loopAttractions( $initialResults );

			if ( $initialResults->post_count < $numAttractions ) {
				// get all our post ids... i'm sure there is an easier way
				$initialAttractionIds = wp_list_pluck( $initialResults->get_posts(), 'ID' );
				$resultsLimit         = $numAttractions - $initialResults->post_count;


				$fillerParams = array(
					'post_type'           => 'attraction',
					'orderby'             => 'rand',
					'post__not_in'        => $initialAttractionIds,
					'attraction_category' => $attractionCategory,
					'posts_per_page'      => $resultsLimit,
					'meta_query'          => array(
						array( 'key' => '_thumbnail_id' )
					)

				);

				$fillerResults = new WP_Query( $fillerParams );

				loopAttractions( $fillerResults );
			}

			wp_reset_postdata();
		}

		?>
    </div>
</div><!-- .isotope-archive -->
