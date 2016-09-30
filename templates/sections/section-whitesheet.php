<?php

use Chamber\Colors;

if( get_row_layout() == 'white_sheet' ) :

    $title       = get_sub_field( 'ws_title' );
    $lead        = get_sub_field( 'ws_lead' );
    $summary     = get_sub_field( 'ws_summary' );
    $columns     = get_sub_field( 'ws_columns' );
    // dd($columns);

    ?>

    <section class="stripe whitesheet">

        <div class="row">

            <header class="callout whitesheet-header" m-Pad="medium large">

            <?php if ($title) : ?>
                <h1><?php echo $title; ?></h1>
            <?php endif; ?>

            </header>

            <div class="callout whitesheet-body" m-Pad="medium large">

            <?php if ($lead) : ?>
                <p class="lead"><?php echo $lead; ?></p>
            <?php endif; ?>

            <?php if ($summary) : ?>
                <div class="whitesheet-content" m-Cols="<?php echo $columns; ?>">
                    <?php echo $summary; ?>
                </div>
            <?php endif; ?>
           
            </div>
        </div>
    </section>

<?php #endif; ?>

<?php endif; ?>
