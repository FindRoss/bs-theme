<?php get_header(); ?>

<?php 
  $paged    = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
  $category = get_category( get_query_var( 'cat' ) );
  $slug     = $category->slug;
  $id       = $category->cat_ID; 
  $name     = $category->name;
  $term     = get_queried_object(); 
?>

<!-- FEATURED FROM ACF --> 
<?php $featured_posts = get_field('featured', $term); ?>

<?php $args = array(
  'post_type'      => 'post', 
  'posts__not_in'  => $featured_posts,
  'paged'          => $paged,
  'cat'            => $id,
  'posts_per_page' => 15, 
); ?>

<?php $query = new WP_Query( $args );
      $total = $query->found_posts;
    
// Pagination fix
$temp_query = $wp_query;
$wp_query   = NULL;
$wp_query   = $query; ?>


<div class="container mb-4">
  
  <div class="row">
    <div class="col-12 col-md-8">
      <h1 class="m-0"><?php echo $name; ?></h1>
      <?php if ($paged === 1) { ?>
        <div class="fs-large"><?php echo term_description(); ?></div>
      <?php } ?>
    </div>
  </div>


<?php if ( $query->have_posts() ) : ?>

    <div class="row">
      <?php while ( $query->have_posts() ) : $query->the_post(); ?>
        <?php $category = get_the_category(); ?>
        <div class="col-12 col-sm-6 col-md-4 mt-3">
            <?php  get_template_part('template-parts/card/card', 'beijing'); ?>
          </div><!-- .col -->
        <?php endwhile; ?>

      <?php wp_reset_postdata(); ?>
    </div><!-- .row --> 
  </div><!-- .container --> 

  <?php if ($total > 10) { ?>
    <div class="container mt-4">
      <?php get_template_part('template-parts/content/content', 'pagination', array('query' => $query)); ?>
    </div><!-- container -->
  <?php }; ?>

<?php else: ?>
  <div class="container">
    <div class="row">
      <div class="alert alert-primary" role="alert">
        There are no post to show.
      </div>
    </div>
  </div>
  </div>
<?php endif; ?>

<?php 
// Restore original query
$wp_query = $temp_query;
?>

<?php get_footer(); ?>


