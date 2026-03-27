<?php
  $thumb_id  = get_post_thumbnail_id();
  $image_alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true) ?: get_the_title();
?>
<div class="card streamer-card">
  <div class="card__media streamer-card__media">
    <img src="<?php echo get_the_post_thumbnail_url(null, 'medium'); ?>" alt="<?php echo esc_attr($image_alt); ?>" width="500" height="333">
  </div>

  <h3>
    <a href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
    </a>
  </h3>
</div>


