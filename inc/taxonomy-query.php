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

  <div class="container">
    <section class="tax-query">
      <div class="tax-query__header">
        <div class="tax-query__header--content">
          <h2>Reviews</h2>
          <?php echo "Total reviews found: <strong>" . $total_posts . "</strong>"; ?>
        </div>
        <div class="tax-query__header--filters">
          <!-- Filters -->
        </div>
      </div>
    

      <div class="tax-query__results">
        <div class="tax-query__results--layout">
          <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <?php get_template_part('template-parts/card/card', 'hong-kong'); ?>
          <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
        <div class="mt-4">   
          <?php get_template_part('template-parts/content/content', 'pagination', array('query' => $query)); ?>
        </div> 
      </div>
    </section>
  </div><!-- .container -->
<?php endif;
};