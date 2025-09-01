<?php
function taxonomy_main_query($query, $taxonomy): void {

  $taxonomy_title = $taxonomy ? ucfirst($taxonomy) : "";

  if ( $query->have_posts() ) :

//$total_posts = $query->found_posts;

    $all_terms = ['cryptocurrency', 'review_type', 'game', 'payment'];

    $crypto_terms = get_terms(array(
          'taxonomy'    => $taxonomy,
          'hide_empty' => true,
          'order'      => 'DESC',
          'number'     => 35,
          'orderby'    => 'count',
    ));


    // echo '<pre>';
    // print_r($crypto_terms);
    // echo '</pre>';

    if (!is_wp_error($crypto_terms)) {
      usort($crypto_terms, function ($a, $b) {
        return strcasecmp($a->name, $b->name);
      });
    }
    

  ?>

    <!-- echo "Total reviews found: <strong>" . $total_posts . "</strong>" -->


  <div class="container">
    <section class="fife-section fife-section--reverse mt-4">

      <aside>
        <div class="term-boxes">
          <?php echo terms_to_box($crypto_terms, $taxonomy_title, true); ?>
        </div>
      </aside>

      <main>
        <div class="grid">
          <?php if ( $query->have_posts() ) : ?>
            <?php while ( $query->have_posts() ) : $query->the_post() ?>
              <div class="grid-item">
                <?php get_template_part('template-parts/card/card', 'hong-kong'); ?>
              </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
          <?php endif; ?>
        </div><!-- .grid -->

        <!-- Pagination -->
        <div class="mt-4">
          <?php get_template_part('template-parts/content/content', 'pagination', array('query' => $query)); ?>
        </div>
      </main>

    </section><!-- .fife-section -->
  </div><!-- .container -->



<?php 
  endif; 
};