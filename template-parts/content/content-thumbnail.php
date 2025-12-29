 <?php 
 $hide_image = get_field('hide_featured_image');  
 
 if (has_post_thumbnail() && !$hide_image) : ?>
  <picture>
    <!-- Large image for desktop -->
    <source media="(min-width: 768px)" srcset="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>">
    <!-- Medium image for mobile -->
    <source media="(max-width: 767px)" srcset="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>">
    <!-- Fallback for browsers that don't support <picture> -->
    <img class="w-100 h-auto border my-4 border-radius exclude-lazyload" 
        src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" 
        alt="<?php the_title_attribute(); ?>" 
        title="<?php the_title_attribute(); ?>" 
        width="800"
        height="480"
        fetchpriority="high"
        />
  </picture>
<?php endif; ?>