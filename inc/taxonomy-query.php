<?php

// I love this site: https://www.justetf.com/en/how-to/sp-500-etfs.html

function taxonomy_main_query($query, $taxonomy, $term): void {

  if (!$query->have_posts()) return; 

  $current_page_url = get_term_link($term); 

  $all_term_name = ['cryptocurrency', 'game', 'provider', 'payment'];
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
  
  $crypto_terms = get_terms(array(
    'taxonomy'    => $taxonomy,
    'hide_empty' => true,
    'order'      => 'DESC',
    'number'     => 35,
    'orderby'    => 'count',
  ));
  
  if (!is_wp_error($crypto_terms)) {
    usort($crypto_terms, function ($a, $b) {
      return strcasecmp($a->name, $b->name);
    });
  }
  
  $taxonomy_titles = [
    'cryptocurrency' => 'Cryptocurrencies',
    'game'           => 'Games',
    'provider'       => 'Providers',
    'payment'        => 'Payments',
    'country'        => 'Countries',
    'review_type'    => 'Sites',
  ];
  // Use the mapped title if it exists, otherwise just ucfirst
  // $taxonomy_title = $taxonomy_titles[$taxonomy] ?? ucfirst($taxonomy);
  ?>


<div class="container">
  <section class="skye-section mt-4">
    <aside class="skye-section__sidebar">
      <div class="term-boxes">
        <?php 
          foreach($all_term_results as $key => $value) {  
            echo terms_to_box($value, $taxonomy_titles[$key], true, $current_page_url); 
          }
        ?>
      </div>
    </aside>
    
    <main class="skye-section__content">
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
  };
  ?>