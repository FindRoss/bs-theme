<?php get_header(); 

$term = get_queried_object(); 
$term_id  = $term->term_id; 
$taxonomy = $term->taxonomy;
$term_name = $term->name;
$term_slug = $term->slug;

// Field from taxonomy page
$featured_bonuses = get_field('featured_bonuses', $term);
$featured_bonuses = is_array($featured_bonuses) ? $featured_bonuses : [];

// Get additional bonuses excluding featured
$additional_bonuses = get_posts(array(
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
  'meta_query' => bonus_expired_meta_query(),
  'post__not_in' => $featured_bonuses,
));

$additional_bonuses = is_array($additional_bonuses) ? $additional_bonuses : [];
$merged_bonuses = array_merge($featured_bonuses, $additional_bonuses);

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
    'meta_query' => bonus_expired_meta_query()
  )); 
};

// Pagination fix - dont need? - causing a problem with pagination
// if (!empty($merged_bonuses)) {
//   $temp_query = $wp_query;
//   $wp_query   = NULL;
//   $wp_query   = $query;
// };

?>

<?php get_template_part('template-parts/breadcrumbs/breadcrumbs'); ?>

<div class="container">
    
    <!-- INTRODUCTION -->
    <section class="">
      <h1><?php echo $term_name == 'Crypto' ? '' : 'Crypto '?><?php echo $term_name; ?> Bonuses</h1>
      <div class="main--content"><?php echo term_description($term); ?></div>
        
      <?php if ($icon) { ?>
        <div class="">
          <img src="<?php echo $icon_thumbnail; ?>" alt="<?php echo $term_name .  " casinos" ?>" width="200" height="200" />
        </div>
      <?php }; ?>
    </section>

    <!-- MAIN QUERY -->
    <section class="perthshire-section">
      <?php 
        if ($query && $query->have_posts()) : 
          while ($query->have_posts()) : $query->the_post();     
            get_template_part('template-parts/card/card', 'shanghai');
          endwhile; 
          wp_reset_postdata();
        else : ?>
          <div class="p-2 bg-white rounded-corners mt-4 border-top" style="font-size: 18px;">
            <p>There are currently <strong>no <?php echo $term_name; ?> bonuses available</strong>.</p> 
            <p>Please explore the <a href="/bonuses/">other bonuses</a> we have currently listed.</p>
          </div>
        <?php endif; ?>
      </section><!-- .perthshire-section --> 

      <?php if (!empty($merged_bonuses)) {
        get_template_part('template-parts/content/content', 'pagination', array('query' => $query));
      }; ?>



    <!-- MAIN CONTENT -->
    <?php if ($paged == 1) : ?>
      <section class="aberdeenshire-section">
        <?php $main_content = get_field('main_content', $term); ?>
        
        <div class="main--content">
          <?php echo $main_content; ?>
          <!-- FAQS -->
          <?php if (get_field('faqs', $term)) { get_template_part( 'template-parts/content/conent', 'faqs' ); }; ?>
        </div>

        <aside class="sidebar">
          <?php get_template_part( 'template-parts/sidebar/sidebar' ); ?>
        </aside>
      </section>
    <?php endif; ?>
  
</div><!-- .container --> 

<?php get_footer(); ?>