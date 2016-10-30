<?php
/**
 * Adds a meta box with contact and location information.
 */

$map     = get_field('attr_google_map');
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
    <div class="map-thumb" style="width:150px;height:150px">
        <div class="marker" data-lat="<?= $map['lat']; ?>" data-lng="<?= $map['lng']; ?>"></div>
    </div>
    <?php endif; ?>

    <dl class="meta-list">
        <?php if ($street) : ?>
        <dt>Address:</dt>
        <dd>
            <?= $street; ?><!-- // remove the white space
            --><?= ', ' . $city; ?><!--
            --><?= ', ' . $state; ?><!--
            --><?= ' ' . $postal; ?>
        </dd>
        <?php endif; ?>

        <?php if ($website) : ?>
        <dt>Website:</dt>
        <dd><a href="<?= $website; ?>"><?= $website; ?></a></dd>
        <?php endif; ?>

        <?php if ($email) : ?>
        <dt>Email:</dt>
        <dd><a href="mailto='<?= $email; ?>'"><?= $email; ?></a></dd>
        <?php endif; ?>

        <?php if ($phone) : ?>
        <dt>Phone:</dt>
        <dd><?= $phone; ?></dd>
        <?php endif; ?>

        <?php if ($fax) : ?>
        <dt>Fax:</dt>
        <dd><?= $fax; ?></dd>
        <?php endif; ?>
    </dl>
</div>
