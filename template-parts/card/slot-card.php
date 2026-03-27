<?php
  $thumb_id  = get_post_thumbnail_id();
  $image_alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true) ?: get_the_title() . ' slot review';
?>
<div class="col-12 col-lg-4 mt-3">
  <a class="slot-card-link" href="<?php the_permalink(); ?>">
    <div class="card shadow-sm border-0 rounded bg-cus-light">
      <img class="card-img-top h-auto" width="300" height="311" src="<?php echo the_post_thumbnail_url('large'); ?>" alt="<?php echo esc_attr($image_alt); ?>">
      <div class="card-body text-center">
        <h3 class="h4"><?php the_title(); ?></h3>
      </div>
    </div>
  </a>
</div>	