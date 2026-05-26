<?php
$thumb_id  = get_post_thumbnail_id();
$image_alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true) ?: get_the_title();
$thumb_url = get_the_post_thumbnail_url(null, 'medium');
?>

<a class="review-article-card" href="<?php the_permalink(); ?>">
  <div>
    <h3 class="review-article-card__title"><?php the_title(); ?></h3>
    <?php if (has_excerpt()) : ?>
      <p class="review-article-card__lede"><?php echo get_the_excerpt(); ?></p>
    <?php endif; ?>
  </div>
  <div class="review-article-card__thumb" aria-hidden="true">
    <?php if ($thumb_url) : ?>
      <img src="<?php echo esc_url($thumb_url); ?>" alt="" loading="lazy">
    <?php endif; ?>
  </div>
</a>
