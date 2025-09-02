<?php 
 $expiry_date = get_field('expiry_date');
 $expiry_timestamp = $expiry_date ? strtotime($expiry_date) * 1000 : 'Expired';
 $marked_expired = get_field('bonus_expired'); 
?>

<div class="card card-chengdu">
    <a class="card__link card-chengdu__link" href="<?php the_permalink(); ?>">
    
        <div class="card-chengdu__body">
        
            <?php if ($expiry_date || $marked_expired) : ?>
            <div class="mb-1">
                <span class="info-pill info-pill-expiry timer" data-expiry="<?php echo $expiry_timestamp; ?>">
                <?php echo get_svg_icon('stopwatch'); ?>
                <span class="ends-in-text"></span>
                </span>
            </div>
            <?php endif; ?>

            <h3><?php the_title(); ?></h3>
            
            <?php if (has_excerpt()) { ?><?php the_excerpt(); ?><?php }; ?>

        </div>

        <div class="card__media card-chengdu__media">
            <picture>
                <!-- Large image for desktop -->
                <source media="(min-width: 768px)" srcset="<?php echo get_the_post_thumbnail_url(null, 'large'); ?>">
                <!-- Medium image for mobile -->
                <source media="(max-width: 767px)" srcset="<?php echo get_the_post_thumbnail_url(null, 'medium'); ?>">
                <!-- Fallback for browsers that don't support <picture> -->
                <img 
                    src="<?php echo get_the_post_thumbnail_url(null, 'medium'); ?>" 
                    alt="<?php the_title_attribute(); ?>" 
                    title="<?php the_title_attribute(); ?>" 
                    width="800"
                    height="480"
                    loading="lazy"
                    aria-hidden="true" />
            </picture>
        </div>
    </a>
</div>