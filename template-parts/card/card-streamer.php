<?php
  $thumb_id  = get_post_thumbnail_id();
  $image_alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true) ?: get_the_title();
?>
<div class="streamer-card">
  <a href="<?php the_permalink(); ?>" class="streamer-card__link">
    <div class="streamer-card__media">
      <img src="<?php echo get_the_post_thumbnail_url(null, 'medium'); ?>" alt="<?php echo esc_attr($image_alt); ?>" width="500" height="333">
    </div>
    <div class="streamer-card__body">
      <h3 class="streamer-card__name"><?php the_title(); ?></h3>
    </div>
  </a>
</div>
