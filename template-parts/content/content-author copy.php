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




<div class="main--meta__section">
  <div class="meta-media">
    <img src="<?php echo $get_avatar_url; ?>" width="35" height="35" alt="<?php the_author(); ?> profile picture" />
  </div>
  
  <div class="meta-content">
    <div class="meta-content__title">
      By <?php the_author(); ?>
    </div>
    <div class="meta-content__date">  
      <span><time datetime="<?php echo esc_attr( get_the_date('c') ); ?>"><?php echo esc_html( $publish_date ); ?></time></span>
    </div>

    
  </div>
</div>




 <?php 
  print_r("published");
  print_r($publish_date);
  print_r("updated");
  print_r($update_date);
  print_r("last editor name");
  print_r($last_editor_name);
 
  if ($publish_date_str !== $update_date_str && !empty($last_editor_name)) : ?>
    <div class="main--meta__section">
      <div class="meta-media">
        <span class="icon"><?php echo get_svg_icon('calendar-tick'); ?></span>
        <img src=" echo $last_editor_avatar_url; ?>" width="24" height="24" alt="Author profile picture of  echo esc_attr( $last_editor_name ); ?>" />
     </div>
     <div class="meta-content">
      <div class="meta-content__title">
          <?php echo esc_html( $last_editor_name ); ?>
       </div>
       <div class="meta-content__date">  
         <span>Updated <time datetime="<?php echo esc_attr( get_the_modified_date('c') ); ?>"><?php echo esc_html( $update_date ); ?><time></span>
       </div>
     </div>
   </div>
  <?php endif; ?> 


 