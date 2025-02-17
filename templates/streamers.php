<?php 
/* 
Template Name: Streamers
Template Post Type: page
*/ 
 

get_header(); 

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

$args = array(
  'post_type'      => 'streamer',
  'posts_per_page' => 20,
  'paged'          => $paged,
);
$query = new WP_Query($args);

// Pagination fix
$temp_query = $wp_query;
$wp_query   = NULL;
$wp_query   = $query;
?>

<div class="py-5">
  <div class="container">
    <h1><?php the_title(); ?></h1>

    <div class="mt-4">
      <?php the_content(); ?>
    </div>
    
    <?php if ( $query->have_posts() ) : ?>
      <div class="row mt-4">
      <?php while ( $query->have_posts() ) : $query->the_post(); ?>

        <div class="col-12 col-md-6 col-lg-3 mt-4">
          <?php require locate_template('components/card/streamer.php'); ?>
        </div><!-- .col --> 

      <?php endwhile; ?>
      </div><!-- .row -->

      <!-- pagination -->
      <div class="mb-4">   
        <?php get_template_part('template-parts/content/content', 'pagination', array('query' => $query)); ?>
      </div>  

    <?php endif; ?>
    <?php wp_reset_postdata(); ?>

  </div><!-- .container --> 
</div>
<?php get_footer(); ?>








