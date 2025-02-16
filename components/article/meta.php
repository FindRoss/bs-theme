<?php 
    $u_time = get_the_time('U'); 
    $u_modified_time = get_the_modified_time('U'); 
    $has_been_updated = $u_modified_time >= $u_time + 86400;

    // author
    $author_id = get_the_author_meta('ID'); 
    $get_avatar_url = get_avatar_url($author_id);
      
    // category  
    $isPost = false; 
    $isReview = false; 
    $isBonus = false; 

    // Is a news post 
    $is_news = false; // Default to false

    if (!empty($categories)) {
      foreach ($categories as $category) {
        if (strpos($category->slug, 'news') !== false) { // Check if 'news' is part of the slug
          $is_news = true;
          break; // Exit loop once found
        }
      }
    }

    $metaPostType = get_post_type();
    
    if ($metaPostType === 'review') {
      $isReview = true; 
    } else if ($metaPostType === 'post') {
      $isPost = true;
    } else if ($metaPostType === 'bonus') {
      $isBonus = true;
    };
?>


<div class="main--meta">
  
  <?php if ($isPost) { ?>

    <!-- Author -->
    <div class="main--meta__section">
      <span class="icon">
        <img src="<?php echo $get_avatar_url; ?>" width="20" height="20" alt="Author profile picture of <?php the_author(); ?>" /> 
      </span>
      <span>By <?php the_author(); ?></span>
    </div>
    <?php }; ?>

    <!-- Published -->
    <div class="main--meta__section">
      <span class="icon"><?php echo get_svg_icon('calendar'); ?></span>
      <?php if ($is_news || !$has_been_updated) : ?>
        <span><?php the_date('M jS, Y'); ?></span>
      <?php else : ?>
        <span>Updated <?php echo the_modified_time('M jS, Y'); ?></span>
      <?php endif; ?>
    </div> 

    <!-- Category -->
    <?php if (!empty($categories)) { ?>
    <div class="main--meta__section">
      <span class="icon"><?php echo get_svg_icon('category'); ?></span>
      <span>
        <?php 
        $total_categories = count($categories);
        $current_index = 1;
        foreach($categories as $cat) { ?>
          <a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->name; ?></a>
          <?php if ($current_index < $total_categories) { echo ','; } 
          $current_index++; 
        }; ?>
      </span>
    </div> 

    <!-- Expiry date -->
    <!--     
      $expiry_date = get_field('expiry_date'); 
      if ($expiry_date) :

      <div class="main--meta__section">
        <span class="icon"><?php echo get_svg_icon('stopwatch'); ?></span>
        <span class="info-pill-expiry timer" data-expiry="<?php echo esc_attr($expiry_date); ?>">
            <span class="ends-in-text"></span>
        </span>
      </div>
    endif; -->

  <?php }; ?>

</div>



