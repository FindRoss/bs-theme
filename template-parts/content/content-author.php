<?php 
    // author
    $author_id = get_the_author_meta('ID'); 
    $author_link = get_author_posts_url( $author_id );
    
    // Get the publish and updated date to compare
    $publish_date_str = get_the_date('Y-m-d');
    $update_date_str  = get_the_modified_date('Y-m-d');

    $publish_ts = strtotime($publish_date_str);
    $update_ts  = strtotime($update_date_str);

    // Get formatted dates
    $publish_date = get_the_date('M j, Y');
    $update_date  = get_the_modified_date('M j, Y');  
?>

<div class="main--published">
  <span>By <a href="<?php echo $author_link; ?>"><?php the_author(); ?></a></span>
  <?php if ($publish_date) : ?>
    <span><time datetime="<?php echo esc_attr( get_the_date('c') ); ?>"><?php echo esc_html( $publish_date ); ?></time></span>
  <?php endif; ?>
  <?php if ($update_ts > $publish_ts) : ?>
    <span>Updated <time datetime="<?php echo esc_attr( get_the_modified_date('c') ); ?>"><?php echo esc_html( $update_date ); ?><time></span>
  <?php endif; ?>
</div>

