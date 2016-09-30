<?php
/**
 * Adds a meta box with contact and location information.
 */

$map     = get_field('attr_add_google_map');
$street  = get_field('attr_street_address');
$suite   = get_field('attr_apt_suite');
$city    = get_field('attr_city') ? get_field('attr_city') : null;
$state   = get_field('attr_state') ? get_field('attr_state')['label'] : null;
$postal  = get_field('attr_postal') ? get_field('attr_postal_code') : null;
$website = get_field('attr_website');
$email   = get_field('attr_email');
$phone   = get_field('attr_phone');
$fax     = get_field('attr_fax');
?>

<div class="attraction-contact">
    <?php if ($map) : ?>
    <div class="map-thumb"><?php echo the_field('attr_google_map'); ?></div>
    <?php endif; ?>

    <dl class="meta-list">
        <?php if ($street) : ?>
        <dt>Address:</dt>
        <dd>
            <?php echo $street; ?><!-- // remove the white space
            --><?php echo ', ' . $city; ?><!--
            --><?php echo ', ' . $state; ?><!--
            --><?php echo ' ' . $postal; ?>
        </dd>
        <?php endif; ?>

        <?php if ($website) : ?>
        <dt>Website:</dt>
        <dd><a href="<?php echo $website; ?>"><?php echo $website; ?></a></dd>
        <?php endif; ?>

        <?php if ($email) : ?>
        <dt>Email:</dt>
        <dd><a href="mailto='<?php echo $email; ?>'"><?php echo $email; ?></a></dd>
        <?php endif; ?>

        <?php if ($phone) : ?>
        <dt>Phone:</dt>
        <dd><?php echo $phone; ?></dd>
        <?php endif; ?>

        <?php if ($fax) : ?>
        <dt>Fax:</dt>
        <dd><?php echo $fax; ?></dd>
        <?php endif; ?>
    </dl>
</div>
