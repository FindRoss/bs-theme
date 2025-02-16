<?php get_header(); 

$term = get_queried_object(); 
$term_id  = $term->term_id; 
$taxonomy = $term->taxonomy;
$term_name = $term->name;
// $country = geot_country();
// $country_data = geot_user_country();
// print_r($country);


$icon = get_field('icon', $term);
// Check if the icon is an array
if ($icon && is_array($icon)) {
  $hasIcon = true;
} else {
  $hasIcon = false;
}

// Selected sites from the taxonomy page  
$casinos = get_field('casinos', $term);
// Selected sites from the options page
$selected_sites = get_field('sites', 'options');
$featured_args = array(
  'posts_per_page' => 8, 
  'post_type'      => 'review',
  'post__in'       => $casinos ? $casinos : $selected_sites,
  'orderby'        => 'post__in',
  'tax_query'      => array(
    array(
      'taxonomy' => $term->taxonomy,
      'field'    => 'term_id',
      'terms'    => $term->term_id
    )
  ),
);

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$query = new WP_Query(array( 
  'post_type'      => array('review'),  
  'posts_per_page' => 24, 
  'paged'          => $paged,
  'orderby'        => 'meta_value_num',
  'meta_key'       => 'rank',
  'order'          => 'ASC',
  'post__not_in'   => $casinos ? $casinos : $selected_sites,
  'tax_query'      => array(
    'relation'       => 'AND',
      array(
        'taxonomy' => $taxonomy,
        'field'    => 'term_id',
        'terms'    => $term_id
      ),
    ),
    'meta_query' => array(
      array(
        'key'     => 'details_group_closed',
        'value'   => '1', 
        'compare' => 'NOT LIKE'
      ),
    )
  )); ?>

<?php 
// Pagination fix
$temp_query = $wp_query;
$wp_query   = NULL;
$wp_query   = $query;

$count = 1;
?>

<!-- INTRODUCTION -->
<div class="pt-4">
  <div class="container">
    <div class="row flex-column-reverse flex-lg-row">
      <div class="col-12 col-lg-8">
        <h1><?php  echo $term_name; ?> Casinos and Gambling Sites</h1>
        <div class="main--content"> 
          <?php echo term_description(); ?>
        </div>
      </div><!-- .col -->

      <?php if ($hasIcon) { ?>
      <div class="col-12 col-lg-4 d-flex justify-content-lg-center align-items-center">
        <div class="bg-white rounded-circle mb-4 mb-lg-0">
          <img src="<?php echo $icon['sizes']['thumbnail']; ?>" alt="<?php echo $term_name .  " casinos" ?>" width="150" height="150" />
        </div>
      </div>
      <?php }; ?>

    </div><!-- .row -->
  </div>
</div>

<!-- FEATURED -->
<?php if ($paged == 1) : 
  $featured_query = new WP_Query($featured_args); 

  if ($featured_query->have_posts()) : ?>

    <section class="taxonomy-featued-sites">
      <div class="container">
        
        <?php
        chaser_styled_sub_heading(array(
          'heading' => 'Featured'
        )); ?>
        <?php outputBigSlideHTML($featured_query); ?>
      </div><!-- .container -->
    </section>

  <?php endif;  
endif; ?>

<!-- MAIN QUERY -->
<?php taxonomyMainQuery($query, $taxonomy); ?>


<?php if ($paged == 1) : ?>
  <!-- CONTENT --> 
  <div class="container py-5">
    <?php $main_content = get_field('main_content', $term); ?>
    <div class="main--content">
      <div class="row">
        <div class="col-12 col-lg-8"> 
          <?php echo $main_content; ?>
          <!-- FAQS -->
          <?php if (get_field('faqs', $term)) { 
            require locate_template('components/article/faqs.php'); 
          }; ?>
        </div>
      </div>
    </div>



  <?php 
  
  $args = array(
    'post_type' => 'post',    
    'posts_per_page' => 8,   
    'tax_query' => array(
      array(
        'taxonomy' => $taxonomy,   // Define the taxonomy
        'field'    => 'term_id',       // Can be 'slug' or 'term_id'
        'terms'    => $term_id,       // The term slug (or ID if 'field' is set to 'term_id')
      ),
    ),
  );

  
  $posts = get_posts($args);



  if (!empty($posts)) { ?>


  <section class="mt-5">
  <?php 
    $read_more_heading = $term_name . ' Casino News and Guides';
    
    chaser_styled_sub_heading(array(
      'heading' => $read_more_heading
    )); ?>
    
    <div class="row">
      <?php foreach ($posts as $post) {
          setup_postdata($post); ?>
          
          <div class="col-6 col-sm-6 col-lg-3 mt-3">
            <?php require locate_template('components/card/article.php'); ?>
          </div>
      <?php } ?>

    </div><!-- .row -->

  </section>
  <?php }

  wp_reset_postdata();
  
  
  ?>

  </div><!-- .container -->

<?php endif; ?>

 
<?php 
get_footer();