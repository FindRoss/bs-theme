<!-- RELATED ARTICLES --> 
<?php 

  $current_post_id = get_the_ID();
  $categories = get_the_category();
  $category_title = $categories[0]->name;
  
  
  $args = array(
    'post_type'      => 'post', 
    'post__not_in'   => array($current_post_id),
    'posts_per_page' => 8, 
    'cat'            => $categories,
    
  ); 
  $latest_query = new WP_Query( $args );
?>

<?php if ( $latest_query->have_posts() ) : ?>  
  <div class="container mt-5 pt-4">
    <section>
      <h2>Here</h2>
    </section>
  </div>
<?php wp_reset_postdata(); ?>
<?php endif; ?>