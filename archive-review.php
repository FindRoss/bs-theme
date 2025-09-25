<?php get_header(); ?>

<?php 
  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

  // Custom query
  $query = new WP_Query(array(
    'post_type'      => 'review',
    'posts_per_page' => 12,
    'paged'          => $paged,
    'orderby'        => 'meta_value_num',
    'meta_key'       => 'rank',
    'order'          => 'ASC',
    'meta_query' => array(
      array(
        'key'     => 'details_group_closed',
        'value'   => '1',
        'compare' => 'NOT LIKE'
      ),
    )
  ));
?>


  <div class="container">
    <header class="taxonomy-header">
      <h1>Reviews</h1>
      <div class="taxonomy-header__description main--content">
        <p>Discover casino and gambling site reviews including information about bonuses, payments, and games.</p>
      </div>
    </header>
  </div>

  <!-- MAIN QUERY -->
  <?php taxonomy_main_query($query, 61); ?>
  
      

<?php get_footer(); ?>