<?php
/**
 * Adds a details box to a single attraction post that lists hours and admission prices.
 */

$hours     = get_field('attr_hours');
$admission = get_field('attr_admission');
?>

<div class="attraction-details">
    <h3>Details</h3>

    <div class="row">
        <?php if ($hours) : ?>
        <div class="callout">
            <h5>Hours:</h5>
            <?= $hours; ?>
        </div>
        <?php endif; ?>

        <?php if ($admission) : ?>
        <div class="callout">
            <h5>Admission:</h5>
            <?= $admission; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
