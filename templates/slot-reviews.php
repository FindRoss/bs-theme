<?php /* Template Name: Slot Reviews */ ?>
<?php get_header(); ?>

	<div class="container mb-4">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
    <?php endwhile; endif; wp_reset_postdata(); ?>     
  </div>

  <div class="container mb-4">
        
    <!-- ARGS --> 
    <?php 
      $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
      $args = array(
        'post_type'      => 'slots',
        'posts_per_page' => 12,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'paged'          => $paged
      );

      // get posts
      $query = new WP_Query( $args );

      // Pagination fix
      $temp_query = $wp_query;
      $wp_query   = NULL;
      $wp_query   = $query;

      ?>

      <?php if ( $query->have_posts() ) : ?>
      <div class="row">
        <?php	while ( $query->have_posts() ) : $query->the_post();?>
          <?php require locate_template( 'components/card/slot.php' ); ?>
        <?php endwhile; ?> 
      </div>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>

      <div class="mb-4">   
        <?php require locate_template( 'components/pagination.php' )?>
      </div>  
    
	</div><!-- .container -->

<?php

get_footer();
