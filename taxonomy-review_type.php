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

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$query = new WP_Query( 
  array( 
    'post_type'      => 'review', 
    'posts_per_page' => 12,  
    'paged'          => $paged,
    'orderby'        => 'meta_value_num',
    'meta_key'       => 'rank',
    'order'          => 'ASC',
    'tax_query'      => array(
      array(
        'taxonomy' => $taxonomy,
        'field'    => 'term_id',
        'terms'    => $term_id
      )
    ),
    'meta_query' => array(
      array(
        'key' => 'details_group_closed', 
        'value' => '1',  
        'compare' => '!=' 
      ),
    )
  ) 
);

// Pagination fix
$temp_query = $wp_query;
$wp_query   = NULL;
$wp_query   = $query;
?>

<?php get_template_part('template-parts/breadcrumbs/breadcrumbs'); ?> 

<div class="container">
  <header class="taxonomy-header">
    <?php if ($hasIcon) { ?>
      <img src="<?php echo esc_url($icon['sizes']['thumbnail']); ?>"
            alt="<?php echo esc_attr($term_name .  ' casinos'); ?>"
            width="100" height="100" />
    <?php } ?>
    <h1>Crypto <?php  echo $term_name; ?></h1>

    <?php
      if (term_description()) {
    ?>
      <div class="taxonomy-header__description main--content">
        <?php echo term_description(); ?>
      </div>

    <?php }; ?>
  </header>
</div>

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
<?php taxonomy_main_query($query, $term); ?>


<!-- MAIN CONTENT -->
<?php if ($paged == 1) : ?>
  <div class="container">
    <section class="aberdeenshire-section">
      <?php $main_content = get_field('main_content', $term); ?>
      
      <div class="main--content">
        <?php echo $main_content; ?>
        <!-- FAQS -->
        <?php if (get_field('faqs', $term)) { get_template_part( 'template-parts/content/conent', 'faqs' ); }; ?>
      </div>

      
    </section>
  </div>
<?php endif; ?>


 
<?php get_footer();