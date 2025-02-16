<?php /* Template Name: Casino Reviews */ ?>

<?php get_header(); ?>

<?php 
$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

$newArgs = array(
  'post_type'      => 'review', 
  'paged'          => $paged,
  'posts_per_page' => 16,
); 

$query = new WP_Query( $newArgs );
?>


<div class="container mb-4">
  <div class="row mb-2">
    <div class="col-12">
      <h1 class="h2 mb-4">Casino Reviews</h1>
    </div>
  </div>
</div><!-- .container --> 

<?php 
// Pagination fix
$temp_query = $wp_query;
$wp_query   = NULL;
$wp_query   = $query;
?>

<div class="container">

  <?php if ( $query->have_posts() ) : ?>
  
  <div class="row mb-5">   


    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
      <div class="col-12 col-sm-6 col-lg-3 mt-4">
        <?php require locate_template( 'components/card/review-excerpt.php' ); ?>
      </div>
    <?php endwhile; 
    wp_reset_postdata(); ?>

  </div><!-- .row --> 

  <div class="mb-4 pb-5">   
    <?php require locate_template( 'components/pagination.php' )?>
  </div>     

  <?php endif; ?>


</div><!-- container --> 


<?php get_footer();
