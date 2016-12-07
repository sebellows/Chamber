<?php
/**
 * Template for full-width Chamber Master integration
 *
 * @author    Joel Howard <joelhoward@gmail.com>
 *
 */
use Chamber\Theme\Helper;

?>
<section class="stripe whitesheet">
    <div class="row">
        <div m-pad="medium large">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>
    </div>
</section>
