<?php
/**
* Template for displaying attractions in a filterable date_create_immutable
*
* @author    Joel Howard <joelhoward@gmail.com>
*
*/
use Chamber\Theme\Helper;
global $wpdb;

// get our attractions
$attractions = new WP_Query(array(
    'posts_per_page'   => -1, // get all for now... add pagination later
    'post_type'        => 'attraction',
    'suppress_filters' => true
));

// get all our types for filters
$attractionTypes = get_terms('attraction_category');

// get all of our cities... this should be good!
$attractionCities = $wpdb->get_results("SELECT DISTINCT wp_postmeta.meta_value FROM wp_postmeta
    LEFT JOIN wp_posts ON wp_postmeta.post_id = wp_posts.ID
    WHERE wp_postmeta.meta_key='attr_city' AND  wp_posts.post_status='publish'
    ORDER BY meta_value ASC;");
    ?>

    <div class="data-grid full-screen-grid">

        <div class="row column">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    the_content();
                endwhile;
                ?>
                <hr />
            <?php endif; ?>
            <div class='filter-buttons'>
                <h3>Cities</h3>
                <?php foreach($attractionCities as $attractionCity): ?>
                    <button type="button" class="small hollow button" data-filter='city' data-value="<?= $attractionCity->meta_value; ?>"><?= $attractionCity->meta_value; ?></button>
                <?php endforeach; ?>
                <button type="button" class="small secondary button" data-clear='city'>Clear City Filter</button>

                <h3>Types</h3>
                <?php foreach($attractionTypes as $attractionType): ?>
                    <button type="button" class="small hollow button" data-filter='type' data-value="<?= $attractionType->name; ?>"><?= $attractionType->name; ?></button>
                <?php endforeach; ?>
                <button type="button" class="small secondary button" data-clear='type'>Clear Type Filter</button>
                <hr />

            </div>
            <?php if($attractions->have_posts()): ?>
                <table id="attractionsDataTable" class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>City</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($attractions->have_posts()): $attractions->the_post();  ?>
                            <tr>
                                <td>
                                    <?php if ( has_post_thumbnail() ) : ?>

                                        <?php get_the_image(
                                            [
                                                'size'         => 'thumbnail',
                                                'order'        => [ 'featured' ],
                                                'link'         => true
                                            ]
                                        ); ?>

                                    <?php endif; ?>

                                    <h3 itemprop="headline"><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h3>

                                    <?php
                                    $excerpt = has_excerpt() ? get_the_excerpt() : get_the_content();
                                    $excerpt = Helper::limit_content($excerpt, 150, '<a class="continuedmark" href="' . esc_url( get_permalink() ) . '">&nbsp;&hellip;MORE</a>');
                                    ?>

                                    <p <?php hybrid_attr( 'entry-summary' ); ?>>
                                        <?= $excerpt; ?>
                                    </p>
                                </td>
                                <td>
                                    <?php
                                    $categories = get_the_terms( $post->ID, 'attraction_category' );
                                    if($categories):
                                        $prefix = '';
                                        foreach ( $categories as $category):
                                            //echo $prefix . '<a href="/attractions/' . $category->slug .'">' . $category->name . '</a>'; ~ until we figure out how to display these
                                            echo $prefix . '<a href="#">' . $category->name . '</a>';
                                            $prefix = ', ';
                                        endforeach;
                                    endif;
                                    ?>
                                </td>
                                <td>
                                    <?= get_field('attr_city'); ?>
                                </td>
                            </tr>

                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div><!-- .data-grid -->
