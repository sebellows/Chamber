<?php
/**
* Template for displaying attractions in a filterable date_create_immutable
*
* @author    Joel Howard <joelhoward@gmail.com>
*
*/
use Chamber\Theme\Helper;

    // get our attractions
    $attractions = new WP_Query(array(
        'posts_per_page'   => -1, // get all for now... add pagination later
        'post_type'        => 'attraction',
        'suppress_filters' => true
    ));

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
                                    <a href="<?php esc_url(the_permalink()); ?>"><?php the_post_thumbnail(); ?></a>
                                <?php endif; ?>
                                <h3><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h3>
                                <?php
                        			$excerpt = has_excerpt() ? get_the_excerpt() : get_the_content();
                        			$excerpt = Helper::limit_content($excerpt, 150, '<a class="continuedmark" href="' . esc_url( get_permalink() ) . '">&nbsp;&hellip;MORE</a>');
                    			?>
                                <p>
                                    <?php echo $excerpt; ?>
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
                                <?php echo get_field('attr_city'); ?>
                            </td>
                        </tr>

                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div><!-- .data-grid -->
