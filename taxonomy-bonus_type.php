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

$icon    = get_field('icon', $term);
$hasIcon = $icon && is_array($icon);

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

if (empty($merged_bonuses)) {
  $query = null; 
} else {
  $query = new WP_Query(array(
    'post_type'      => 'bonus',
    'posts_per_page' => 6,
    'paged'          => $paged,
    'post__in'       => $merged_bonuses,
    'orderby'        => 'post__in',
    'meta_query'     => bonus_expired_meta_query()
  ));
};

$title_output = '';
switch($term_name) {
  case 'Crypto': 
    $title_output = 'Crypto Casino Bonuses';
    break;
  case 'Bitcoin':
    $title_output = 'Bitcoin Casino Bonuses';
    break;
  default: 
    $title_output = $term_name . ' Bonuses';
};


?>

<?php get_template_part('template-parts/breadcrumbs/breadcrumbs'); ?>

<div class="container">
    
    <!-- INTRODUCTION -->
    <header class="taxonomy-header">
      <?php if ($hasIcon) { ?>
        <img
          src="<?php echo esc_url($icon['sizes']['medium']); ?>"
          alt="<?php echo esc_attr($term_name . ' casinos'); ?>"
          class="exclude-lazyload"
          fetchpriority="high"
        />
      <?php } ?>

      <h1><?php echo esc_html($title_output); ?></h1>

      <?php if (term_description($term)) { ?>
        <div class="taxonomy-header__description main--content"><?php echo term_description($term); ?></div>
      <?php } ?>
    </header>

    <!-- MAIN QUERY -->
    <section>
      <div id="km-card-list"
        class="mt-4 flex flex-col gap-3"
        data-term="<?php echo esc_attr($term_slug); ?>"
        data-taxonomy="<?php echo esc_attr($taxonomy); ?>"
        data-total-pages="<?php echo esc_attr($query ? $query->max_num_pages : 0); ?>"
        data-endpoint="chaser/v2/bonuses"
      >
        <?php if ($query && $query->have_posts()) : ?>
          <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php get_template_part('template-parts/card/card', 'suzhou'); ?>
          <?php endwhile; wp_reset_postdata(); ?>
        <?php else : ?>
          <div class="p-2 bg-white border-radius mt-4 border-top" style="font-size: 18px;">
            <p>There are currently <strong>no <?php echo esc_html($term_name); ?> bonuses available</strong>.</p>
            <p>Please explore the <a href="/bonuses/">other bonuses</a> we have currently listed.</p>
          </div>
        <?php endif; ?>
      </div>

      <?php if ($query && $query->max_num_pages > 1) : ?>
        <div class="km-load-more-wrapper mt-3">
          <button class="km-load-more button button__outline" data-page="2">
            <i data-feather="chevron-down"></i>
            <span>Load More</span>
          </button>
        </div>
      <?php endif; ?>
    </section>

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