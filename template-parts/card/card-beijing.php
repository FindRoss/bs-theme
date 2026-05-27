<?php
  $exclude_lazyload = $args['exclude_lazyload'] ?? false;
  $exclude_image    = $args['exclude_image'] ?? false;
  $thumb_id         = get_post_thumbnail_id();
  $image_alt        = get_post_meta($thumb_id, '_wp_attachment_image_alt', true) ?: the_title_attribute(['echo' => false]);
?>

<!-- .card-col-row --> 

<div class="card card-beijing">
  <a class="card__link card-beijing__link" href="<?php the_permalink(); ?>">

    <?php if (!$exclude_image) : ?>
      <div class="card__media card-beijing__media">
        <picture>
          <!-- Large image for desktop -->
          <source media="(min-width: 768px)" srcset="<?php echo get_the_post_thumbnail_url(null, 'large'); ?>">
          <!-- Medium image for mobile -->
          <source media="(max-width: 767px)" srcset="<?php echo get_the_post_thumbnail_url(null, 'medium'); ?>">
          <!-- Fallback for browsers that don't support <picture> -->
          <img 
            src="<?php echo get_the_post_thumbnail_url(null, 'medium'); ?>" 
            alt="<?php echo esc_attr($image_alt); ?>"
            title="<?php the_title_attribute(); ?>" 
            width="800"
            height="480"
            <?php echo $exclude_lazyload ? 'class="exclude-lazyload"' : ''; ?>
          />
        </picture>
      </div>
    <?php endif; ?>
          
    <div class="card-beijing__body">
      
      <h3><?php the_title(); ?></h3>
    </div>
  </a>
</div>
