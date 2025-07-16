<?php get_header(); 

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

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
// $casinos = get_field('casinos', $term); 
// Selected sites from the options page
// $featured_sites = get_field('sites', 'options');

$query = new WP_Query(array( 
  'post_type'      => array('review'),  
  'posts_per_page' => 12, 
  'paged'          => $paged,
  'orderby'        => 'meta_value_num',
  'meta_key'       => 'rank',
  'order'          => 'ASC',
  // 'post__not_in'   => $casinos ? $casinos : $selected_sites,
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

$title_output = $term_name . ' Casinos and Gambling Sites';
if ($taxonomy == 'cryptocurrency') $title_output = 'Top ' . $term_name . ' Casinos of 2025';
if ($taxonomy == 'game') $title_output = 'Top Bitcoin & Crypto ' . $term_name . ' Casinos of 2025';
if ($taxonomy == 'provider') $title_output = 'Top ' . $term_name . ' Casinos of 2025';
?>

<!-- INTRODUCTION -->
<div class="pt-4">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-8">
        <?php if ($hasIcon) { ?>
          <img src="<?php echo $icon['sizes']['thumbnail']; ?>" alt="<?php echo $term_name .  " casinos" ?>" width="100" height="100" />
        <?php }; ?>
        <h1><?php echo $title_output; ?></h1>
        <div class="main--content"> 
          <?php echo term_description(); ?>
        </div>
      </div><!-- .col -->
    </div><!-- .row -->
  </div><!-- .container --> 
</div>

<!-- MAIN QUERY -->
<?php taxonomyMainQuery($query, $taxonomy); ?>

<div class="container">
<?php if ($paged == 1) : ?>

  <?php $main_content = get_field('main_content', $term); ?>
  
  <!-- MAIN CONTENT -->
  <section class="aberdeenshire-section">
  
    
    <div class="main--content">
      <?php echo $main_content; ?>
      <!-- FAQS -->
      <?php if (get_field('faqs', $term)) { get_template_part( 'template-parts/content/conent', 'faqs' ); }; ?>
    </div>

    <?php if ($main_content != '') { ?>
      <aside>
        <?php get_template_part( 'template-parts/sidebar/sidebar' ); ?>
      </aside>
    <?php }; ?>
  </section>



  <?php 
  $args = array(
    'post_type' => 'post',    
    'posts_per_page' => 8,   
    'tax_query' => array(
      array(
        'taxonomy' => $taxonomy,   
        'field'    => 'term_id', 
        'terms'    => $term_id, 
      ),
    ),
    'meta_query'     => bonus_expired_meta_query()
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
            <?php  get_template_part('template-parts/card/card', 'beijing'); ?>
          </div>
      <?php } ?>

    </div><!-- .row -->

  </section>
  <?php }

  wp_reset_postdata();
  
  endif; 
  ?>
  </div><!-- .container -->
 
<?php get_footer();