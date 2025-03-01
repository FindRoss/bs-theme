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

    // Get the ID of the last user who edited the post
    $last_updated_by = get_post_meta( get_the_ID(), '_edit_last', true );

    // Get the user data for the last editor
    if ( !empty( $last_updated_by ) ) {
        
        $last_editor = get_userdata( $last_updated_by );
        $last_editor_name = $last_editor->display_name;
        $last_editor_avatar_url = get_avatar_url( $last_updated_by );
        print_r($last_editor);
    }
?>

<div class="main--meta">
  
  <!-- FIFE Section -->
  <div class="main--meta__section">
    <div class="meta-icon">
      <?php if ($get_avatar_url) { ?>
        <span class="icon"><img src="<?php echo $get_avatar_url; ?>" width="20" height="20" alt="Author profile picture of <?php the_author(); ?>" /> </span>
      <?php } else { ?>
        <span class="icon"><?php echo get_svg_icon('calendar'); ?></span>
      <?php } ?>
    </div>
    
    <div class="meta-content">
      <div class="meta-content__by">
        <span>By <?php the_author(); ?></span>
      </div>
      <div class="meta-content__date">  
        <span>Published <time datetime="<?php echo esc_attr( get_the_date('c') ); ?>"><?php echo esc_html( $publish_date ); ?></time></span>
      </div>
    </div>
  </div>

  <!-- FIFE Section -->
  <?php if ($publish_date_str !== $update_date_str && !empty($last_editor_name)) : ?>
  <div class="main--meta__section">
    <div class="meta-icon">
      <?php if ( !empty($last_editor_avatar_url) ) { ?>
        <span class="icon"><img src="<?php echo $last_editor_avatar_url; ?>" width="20" height="20" alt="Author profile picture of <?php echo esc_attr( $last_editor_name ); ?>" /> </span>
      <?php } else { ?>
        <span class="icon"><?php echo get_svg_icon('calendar-tick'); ?></span>
      <?php } ?>
    </div>
    
    <div class="meta-content">
      <div class="meta-content__by">
        <span>By <?php echo esc_html( $last_editor_name ); ?></span>
      </div>
      <div class="meta-content__date">  
        <span>Updated <time datetime="<?php echo esc_attr( get_the_modified_date('c') ); ?>"><?php echo esc_html( $update_date ); ?></time></span>
      </div>
    </div>
  </div>
  <?php endif; ?>

</div>



