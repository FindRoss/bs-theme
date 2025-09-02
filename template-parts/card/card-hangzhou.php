<?php 
 $expiry_date = get_field('expiry_date');
 $expiry_timestamp = $expiry_date ? strtotime($expiry_date) * 1000 : 'Expired';
 $marked_expired = get_field('bonus_expired'); 
?>

<div class="card card-hangzhou">
    <a class="card__link" href="<?php the_permalink(); ?>">
        <div class="card-hangzhou__body">
            <?php if ($expiry_date || $marked_expired) : ?>
            <div class="mb-1">
                <span class="info-pill info-pill-expiry timer" data-expiry="<?php echo $expiry_timestamp; ?>">
                <?php echo get_svg_icon('stopwatch'); ?>
                <span class="ends-in-text"></span>
                </span>
            </div>
            <?php endif; ?>

            <h3><?php the_title(); ?></h3>
        </div>
    </a>
</div>