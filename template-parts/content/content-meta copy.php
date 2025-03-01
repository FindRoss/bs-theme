<?php 
    // author
    $author_id = get_the_author_meta('ID'); 
    $get_avatar_url = get_avatar_url($author_id);

    // Get the category - empty if it isnt a post.
    $categories = get_the_category(); 

    // Get the publish and updated date to compare
    $publish_date_str = get_the_date('Y-m-d');
    $update_date_str  = get_the_modified_date('Y-m-d');

    // Get formatted dates
    $publish_date = get_the_date('M j, Y');
    $update_date  = get_the_modified_date('M j, Y');
?>


<div class="main--meta">
  <!-- Author -->
  <div class="main--meta__section">
    <?php if ($get_avatar_url) { ?>
      <span class="icon">
        <img src="<?php echo $get_avatar_url; ?>" width="20" height="20" alt="Author profile picture of <?php the_author(); ?>" /> 
      </span>
    <?php }; ?>
    <span>By <?php the_author(); ?></span>
  </div>

  <!-- Category -->
  <?php if (!empty($categories)) { ?>
  <div class="main--meta__section">
    <span class="icon"><?php echo get_svg_icon('category'); ?></span>

      <?php 
      $total_categories = count($categories);
      $current_index = 1;
      foreach($categories as $cat) { ?>
        <span>
          <a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->name; ?></a><?php if ($current_index < $total_categories) { echo ', '; } ?>
        </span>
        <?php $current_index++; ?>
      <?php }; ?>
    </span>  
  </div> 
  <?php } ?>

  <!-- Published --> 
  <div class="main--meta__section">
    <span class="icon"><?php echo get_svg_icon('calendar'); ?></span>
    <span>Published <time datetime="<?php echo esc_attr( get_the_date('c') ); ?>"><?php echo esc_html( $publish_date ); ?></time></span>
  </div>

  <!-- Updated --> 
  <?php if ($publish_date_str !== $update_date_str) : ?>
  <div class="main--meta__section">
    <span class="icon"><?php echo get_svg_icon('calendar-tick'); ?></span>
    <span>Updated <time datetime="<?php echo esc_attr( get_the_modified_date('c') ); ?>"><?php echo esc_html( $update_date ); ?></time></span>
  </div>
  <?php endif; ?>
</div>



