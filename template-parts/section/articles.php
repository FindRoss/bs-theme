<?php 
  // RELATED ARTICLES
  $current_post_id = function_exists('get_the_ID') ? get_the_ID() : 0;
  
  $args = array(
    'post_type'      => 'post', 
    // Exclude the current post from the query
    'post__not_in'   => array($current_post_id),
    'posts_per_page' => 8, 
    'meta_query'     => bonus_expired_meta_query()
  ); 
  $query = new WP_Query( $args );
?>

<?php if ( $query->have_posts() ) : ?>  
  <div class="container mt-4 pt-4">
    <section>
    <?php chaser_styled_sub_heading(array(
      'heading' => 'Read More'
    )); ?>
     <div class="row">
      <?php while ( $query->have_posts() ) : $query->the_post() ?>
        <div class="col-12 col-md-6 col-lg-3 mt-3">
          <?php require locate_template('components/card/article.php'); ?>
          <?php $used_posts[] = get_the_ID(); ?>
        </div>
      <?php endwhile; ?>
    </section>
    </div>
<?php wp_reset_postdata(); ?>
<?php endif; ?>