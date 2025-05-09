<?php 
  $categories = get_the_category();
  $single_category_id = $categories[0]->cat_ID;
  $single_category_name = $categories[0]->name; 
 
  $expiry_date = get_field('expiry_date');
  $marked_expired = get_field('bonus_expired'); 
?>

<!-- .card-col-row --> 

<div class="card card-beijing">

  <a class="card__link card-beijing__link" href="<?php the_permalink(); ?>">

    <div class="card__media card-beijing__media">
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
          
    <div class="card-beijing__body">
      
      <?php if ($expiry_date || $marked_expired) : ?>
        <span class="info-pill info-pill-expiry timer" data-expiry="<?php echo $expiry_date ? esc_attr($expiry_date) : 'Expired'; ?>">
          <?php echo get_svg_icon('stopwatch'); ?>
          <span class="ends-in-text"></span>
        </span>
      <?php endif; ?>

      <h3><?php the_title(); ?></h3>
    </div>
  </a>
</div>
