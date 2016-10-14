<?php

if( get_row_layout() == 'white_sheet' ) :

    $title       = get_sub_field( 'ws_title' );
    $lead        = get_sub_field( 'ws_lead' );
    $summary     = get_sub_field( 'ws_summary' );
    $columns     = get_sub_field( 'ws_columns' );

    ?>

    <section class="stripe whitesheet">

        <div class="row">

            <header class="callout whitesheet-header" m-Pad="medium large">

            <?php if ($title) : ?>
                <h1><?= $title; ?></h1>
            <?php endif; ?>

            </header>

            <div class="callout whitesheet-body" m-Pad="medium large">

            <?php if ($lead) : ?>
                <p class="lead"><?= $lead; ?></p>
            <?php endif; ?>

            <?php if ($summary) : ?>
                <div class="whitesheet-content" m-Cols="<?= $columns; ?>">
                    <?= $summary; ?>
                </div>
            <?php endif; ?>
           
            </div>
        </div>
    </section>

<?php #endif; ?>

<?php endif; ?>
