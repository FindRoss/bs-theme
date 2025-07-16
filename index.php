<?php get_header(); ?>

<?php   
  $author = get_queried_object();
  $author_id = $author->ID;
?>

<?php if(is_category()) {  ?>
<div class="container mb-4">
  <div class="row">
    <div class="col">
      <h1 class="h2 mb-0"><?php single_cat_title(); ?></h1>
    </div>
  </div>
</div>
<?php } elseif (is_author()) { ?>
  <div class="container mb-4">
    <div class="row">
      <div class="col">
        <h1 class="h2 mb-0">Posts by <?php echo $author->display_name; ?></h1>
      </div>
    </div>
  </div>
<?php } ?>

<?php $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1; ?>

<?php $args = array(
  'post_type' => 'post', 
  'paged' => $paged,
  'posts_per_page' => 20, 
); 

if(is_category()) {
  $category = get_category( get_query_var( 'cat' ) );
  $cat_id = $category->cat_ID;  
  $args['cat'] = $cat_id;
}

if (is_author()) {
  $args['author'] = $author_id;
}


?>

<?php $query = new WP_Query( $args );
      $total = $query->found_posts;
    
// Pagination fix
$temp_query = $wp_query;
$wp_query   = NULL;
$wp_query   = $query; ?>

<div class="container mb-5">
  <?php if ( $query->have_posts() ) : ?>
    <div class="row justify-content-md-center">
    
      <?php while ( $query->have_posts() ) : $query->the_post(); ?>
        <div class="col-6 mb-2 mb-md-4">
          <?php  get_template_part('template-parts/card/card', 'beijing'); ?>
        </div>
      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>

  </div><!-- .row --> 
</div><!-- .container --> 

<div class="container mb-4 text-center">
  <?php get_template_part('template-parts/content/content', 'pagination', array('query' => $query)); ?>
</div>

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

<?php get_footer(); ?>