<?php get_header(); 


$term = get_queried_object(); 
$term_id  = $term->term_id; 
$taxonomy = $term->taxonomy;
$term_name = $term->name;
$term_slug = $term->slug;

$featured_bonuses = get_field('featured_bonuses', $term);
$all_bonuses = get_posts(array(
  'post_type'      => 'bonus', 
  'posts_per_page' => -1,    
  'fields'         => 'ids',
  'tax_query' => array(
    array(
      'taxonomy' => $taxonomy,
      'field'    => 'slug',
      'terms'    => $term_slug,
    ),
  ),
  'meta_query' => bonus_expired_meta_query()
));

$featured_bonuses = is_array($featured_bonuses) ? $featured_bonuses : [];
$all_bonuses = is_array($all_bonuses) ? $all_bonuses : [];

$merged_bonuses = array_merge($featured_bonuses, $all_bonuses);

// $merged_bonuses = $featured_bonuses ? array_merge($featured_bonuses, $all_bonuses) : $all_bonuses;

$icon  = get_field('icon', $term);
if ($icon) $icon_thumbnail = $icon['url'];

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

if (empty($merged_bonuses)) {
  $query = null; 
} else {
  $query = new WP_Query(array(
    'post_type'  => 'bonus',
    'paged'      => $paged,
    'post__in'   => $merged_bonuses,
    'orderby'    => 'post__in',
  )); 
}

// Pagination fix
if (!empty($merged_bonuses)) {
  $temp_query = $wp_query;
  $wp_query   = NULL;
  $wp_query   = $query;
}

?>

<div class="container">
  <div class="row">
    
    <!-- INTRODUCTION -->
    <div class="col-12 col-lg-8">
      <h1><?php echo $term_name == 'Crypto' ? '' : 'Crypto '?><?php echo $term_name; ?> Bonuses</h1>
      <div class="main--content"><?php echo term_description($term); ?></div>
        
      <?php if ($icon) { ?>
      <div class="col-12 col-lg-4 d-flex justify-content-lg-center align-items-center">
        <div class="bg-white rounded-circle mb-4 mb-lg-0">
          <img src="<?php echo $icon_thumbnail; ?>" alt="<?php echo $term_name .  " casinos" ?>" width="200" height="200" />
        </div>
      </div>
      <?php }; ?>
    </div>

    <!-- MAIN QUERY -->
    <div class="col-12">
      <div class="row">
      <?php 
        if ($query && $query->have_posts()) : 
          while ($query->have_posts()) : $query->the_post();   
            echo '<div class="col-12 col-md-6 col-lg-4 mt-4">';
            get_template_part('template-parts/card/card', 'shanghai');
            echo '</div>';
          endwhile; 
          wp_reset_postdata();
        else : ?>
          <div class="p-2 bg-white rounded-corners mt-4 border-top" style="font-size: 18px;">
            <p>There are currently <strong>no <?php echo $term_name; ?> bonuses available</strong>.</p> 
            <p>Please explore the <a href="/bonuses/">other bonuses</a> we have currently listed.</p>
          </div>
        <?php endif; ?>

      <?php if (!empty($merged_bonuses)) {
        get_template_part('template-parts/content/content', 'pagination', array('query' => $query));
      }; ?>

      </div><!-- .row --> 
    </div><!-- .col --> 


    <!-- MAIN CONTENT -->
    <?php if ($paged == 1) : ?>
    <div class="col-12 col-lg-8">
      <?php $main_content = get_field('main_content', $term); ?>
      <div class="main--content">
      
        <?php echo $main_content; ?>
        <!-- FAQS -->
        <?php if (get_field('faqs', $term)) { 
          get_template_part( 'template-parts/content/conent', 'faqs' );
        }; ?>
      </div>
    </div>

    <aside class="col-12 col-lg-4 d-flex flex-column">
      <div class="pt-4 mt-2 mt-lg-0">
        <?php get_template_part( 'template-parts/sidebar/sidebar' ); ?>
      </div>
    </aside>
    <?php endif; ?>
  
  </div><!-- .row --> 
</div><!-- .container --> 

<?php get_footer(); ?>