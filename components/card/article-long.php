<?php 
  $categories = get_the_category();
  $single_category_id = $categories[0]->cat_ID;
  $single_category_name = $categories[0]->name; 

  $expiry_date = get_field('expiry_date');
  $marked_expired = get_field('bonus_expired'); 
 ?>


  <div class="article-long">
    <div class="article-long__media">
      <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>" alt="" /> 
    </div>      

    <div class="article-long__title">
    
      <?php if ($expiry_date || $marked_expired) : ?>
        <div class="mb-1">
          <span class="info-pill info-pill-expiry timer" data-expiry="<?php echo $expiry_date ? esc_attr($expiry_date) : 'Expired'; ?>">
            <?php echo get_svg_icon('stopwatch'); ?>
            <span class="ends-in-text"></span>
          </span>
        </div>
      <?php endif; ?>
    
      <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    </div>
  </div>

