<?php get_header();  


$term = get_queried_object(); 
$term_id  = $term->term_id; 
$taxonomy = $term->taxonomy;
$term_name = $term->name;

$array_of_terms = array();

if ($term_name == 'Casino') { 
  $terms_to_push = array(
    array(
      'taxonomy' => 'cryptocurrency',
      'field'    => 'slug',
      'terms'    => 'bitcoin'
    ),
    array(
      'taxonomy' => 'cryptocurrency',
      'field'    => 'slug',
      'terms'    => 'litecoin'
    ),
    array(
      'taxonomy' => 'game',
      'field'    => 'slug',
      'terms'    => 'slots'
    ),
    array(
      'taxonomy' => 'game',
      'field'    => 'slug',
      'terms'    => 'crash'
    ),
    array(
      'taxonomy' => 'provider',
      'field'    => 'slug',
      'terms'    => 'bgaming'
    ),
    array(
      'taxonomy' => 'provider',
      'field'    => 'slug',
      'terms'    => 'netent'
    )
  );

  foreach ($terms_to_push as $t) {
      array_push($array_of_terms, $t);
  };
}

$icon = get_field('icon', $term);
// Check if the icon is an array
if ($icon && is_array($icon)) {
  // If it's an array, access the URL
  $hasIcon = true;
} else {
  // If it's a string, use it directly
  $hasIcon = false;
}

$selected_casinos = get_field('sites', 'options');
$featured_args = array(
'post_type'      => 'review', 
'posts_per_page' => 8,
'post__in'       => $selected_casinos,
'orderby'        => 'post__in',
'tax_query'      => array(
    array(
      'taxonomy' => $taxonomy,
      'field'    => 'term_id',
      'terms'    => $term_id
    )
  ),
);

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$query = new WP_Query( 
  array( 
    'post_type'      => 'review', 
    'posts_per_page' => 24, 
    'paged'          => $paged,
    'exclude'        => $selected_casinos,
    'orderby'        => 'rand',
    'tax_query'      => array(
      array(
        'taxonomy' => $taxonomy,
        'field'    => 'term_id',
        'terms'    => $term_id
      )
    ),
    'meta_query' => array(
      array(
        'key' => 'details_group_closed', // Correct field reference inside 'details_group'
        'value' => '1',  // ACF stores true as '1'
        'compare' => '!=' // Exclude posts where 'closed' is true
      ),
    )
  ) 
);

// Pagination fix
$temp_query = $wp_query;
$wp_query   = NULL;
$wp_query   = $query;
?>


<!-- INTRODUCTION -->
<section class="pt-4">
  <div class="container">
    <div class="row flex-column-reverse flex-lg-row">
      <div class="col-12 col-lg-8">
        <h1>Crypto <?php  echo $term_name; ?></h1>
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
</section> 

<!-- FEATURED -->
<?php if ($paged == 1) : 
  $featured_query = new WP_Query($featured_args);

  if ($featured_query->have_posts()) :  

  ?>

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

<!-- LOOP THROUGH TAXONOMIES -->
<?php 
if ($paged == 1) {
  foreach ($array_of_terms as $terms) {
    $setup_args = array(
      'post_type'      => 'review', 
      'posts_per_page' => 8,
      'tax_query'      => array(
          array(
          'taxonomy' => $taxonomy,
          'field'    => 'term_id',
          'terms'    => $term_id
          )
        ),
      );
      array_push($setup_args['tax_query'], $terms); 
      
      $setup_query = new WP_Query($setup_args);
      $setup_foundPosts = $setup_query->found_posts;

      if ($setup_foundPosts >= 8) {

        $current_term = get_term_by('slug', $terms['terms'], $terms['taxonomy']);
      ?> 

      <section class="mt-5">
        <div class="container">

          <?php 
            $capitalized_slug = ucwords(str_replace('-', ' ', $terms['terms']));
          
            outputNewSlideHTML(array(
              'query'   => $setup_query,
              'heading' => $capitalized_slug . ' Casinos',
              'link'    => get_term_link($current_term)
            ))
          ?>

        </div>
      </section>

    <?php }; ?>
  <?php }; ?>
<?php };  ?>

<!-- MAIN QUERY -->
<?php taxonomyMainQuery($query, $taxonomy); ?>


<!-- CONTENT --> 
<?php 
  $main_content = get_field('main_content', $term); 
  
  if ($main_content && $paged == 1) : ?> 
  <section>
    <div class="container py-5">
      <div class="main--content">
        <div class="row">
          <div class="col-12 col-lg-8"> 
            <?php echo $main_content; ?>
            <!-- FAQS -->
            <?php get_template_part( 'template-parts/content/content-faqs' ); ?>
          
          </div>
        </div>
      </div>
    </div><!-- .container -->
  </section>
<?php endif; ?>


 
<?php 
get_footer();



