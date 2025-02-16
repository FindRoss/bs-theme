<?php
    
// cryptocurrency
// game
// provider
// country
// payment

function taxonomyMainQuery($query, $taxonomy) {

  if ( $query->have_posts() ) : 
    
    $total_posts = $query->found_posts;
  ?>
  <div class="py-4 mt-5">
    <div class="container">
      <h2>Reviews</h2>
      <?php echo "Total reviews found: <strong>" . $total_posts . "</strong>"; ?>
      <div class="row g-2">
        
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
          <div class="col-12 col-md-6 col-lg-4 mt-3">
            <?php require locate_template( 'components/card/review-excerpt.php' ); ?>
          </div> 
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>

      </div><!-- .row --> 
      
      <div class="mt-4">   
        <?php get_template_part('template-parts/content/content', 'pagination', array('query' => $query)); ?>
      </div> 
    </div><!-- .container -->
  </div>
<?php endif;
};