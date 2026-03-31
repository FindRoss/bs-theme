<?php

// I love this site: https://www.justetf.com/en/how-to/sp-500-etfs.html

function taxonomy_main_query($query, $term): void {

  if (!$query->have_posts()) return; 

  $current_page_url = get_term_link($term); 

  $all_term_name = ['review_type', 'cryptocurrency', 'game', 'provider', 'payment'];
  $all_term_results = [];

  foreach($all_term_name as $term_name) {
    
    $terms = get_terms(array(
      'taxonomy'   => $term_name,
      'hide_empty' => true,
      'order'      => 'DESC',
      'number'     => 18,
      'orderby'    => 'count',
    ));

    // Orginaze into alphabetical order
    usort($terms, function ($a, $b) {
      return strcasecmp($a->name, $b->name);
    });

    $all_term_results[$term_name] = $terms;
  };
  
  $taxonomy_titles = [
    'cryptocurrency' => 'Cryptocurrency',
    'game'           => 'Games',
    'provider'       => 'Providers',
    'payment'        => 'Payment Methods',
    'country'        => 'Countries',
    'review_type'    => 'Sites',
  ];
  ?>


<div class="container">
  <section class="mt-4 grid grid-cols-12 gap-6 items-start">

    <main class="col-span-12 lg:col-span-9 lg:order-2">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php if ( $query->have_posts() ) :
          $counter = 1;
          while ( $query->have_posts() ) : $query->the_post() ?>
            <?php if ($counter < 3) {
              get_template_part('template-parts/card/card', 'hong-kong', array('exclude_lazyload' => true));
            } else {
              get_template_part('template-parts/card/card', 'hong-kong');
            } ?>
            <?php $counter++; ?>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php endif; ?>
      </div>
        
      <!-- Pagination -->
      <div class="mt-4">
        <?php get_template_part('template-parts/content/content', 'pagination', array('query' => $query)); ?>
      </div>
    </main>

    <aside class="col-span-12 lg:col-span-3">
      <div class="term-boxes">
        <?php
          foreach($all_term_results as $key => $value) {
            echo terms_to_box($value, $taxonomy_titles[$key], true, $current_page_url);
          }
        ?>
      </div>
    </aside>

    </section>
  </div><!-- .container -->


<?php }; ?>