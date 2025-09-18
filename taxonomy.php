<?php
  get_header();

  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

  $term      = get_queried_object();
  $term_id   = $term->term_id;
  $taxonomy  = $term->taxonomy;
  $term_name = $term->name;

  $icon = get_field('icon', $term);
  $hasIcon = $icon && is_array($icon); // simplified boolean check

  // Custom query
  $query = new WP_Query(array(
    'post_type'      => array('review'),
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
      ),
    ),
    'meta_query' => array(
      array(
        'key'     => 'details_group_closed',
        'value'   => '1',
        'compare' => 'NOT LIKE'
      ),
    )
  ));

  $count = 1;

  $title_output = $term_name . ' Casinos and Gambling Sites';
  if ($taxonomy == 'cryptocurrency') $title_output = 'Top ' . $term_name . ' Casinos of 2025';
  if ($taxonomy == 'game') $title_output = 'Top Crypto ' . $term_name . ' Casinos of 2025';
  if ($taxonomy == 'payment') $title_output = 'Top Crypto ' . $term_name . ' Casinos of 2025';
  if ($taxonomy == 'provider') $title_output = 'Top ' . $term_name . ' Casinos of 2025';
  if ($taxonomy == 'country') $title_output = 'Best Crypto Casino ' . $term_name . ' 2025';
?>

<div class="container">
  <header class="taxonomy-header">
    <?php if ($hasIcon) { ?>
      <img 
        src="<?php echo esc_url($icon['sizes']['medium']); ?>"
        alt="<?php echo esc_attr($term_name .  ' casinos'); ?>"
        class="exclude-lazyload"
        fetchpriority="high"
       />
    <?php } ?>
    <h1><?php echo esc_html($title_output); ?></h1>

    <?php
      if (term_description()) {
    ?>
      <div class="taxonomy-header__description main--content">
        <?php echo term_description(); ?>
      </div>

    <?php }; ?>
  </header>
</div>


<!-- MAIN QUERY -->
<?php taxonomy_main_query($query, $taxonomy, $term); // Pass $query directly ?>

<!--MAIN CONTENT-->
<div class="container">
  <?php if ($paged == 1) : ?>

    <?php $main_content = get_field('main_content', $term); ?>

    <section class="aberdeenshire-section">
      <div class="main--content">
        <?php echo $main_content; ?>
        <?php if (get_field('faqs', $term)) {
          get_template_part('template-parts/content/content', 'faqs');
        } ?>
      </div>
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
      'meta_query' => bonus_expired_meta_query()
    );

    $posts = get_posts($args);

    if (!empty($posts)) { ?>

      <section class="mt-5">
        <?php
          $read_more_heading = $term_name . ' Casino News and Guides';
          chaser_styled_sub_heading(array('heading' => $read_more_heading));
        ?>

        <div class="row">
          <?php foreach ($posts as $post) {
            setup_postdata($post); ?>

            <div class="col-6 col-sm-6 col-lg-3 mt-3">
              <?php get_template_part('template-parts/card/card', 'beijing'); ?>
            </div>
          <?php } ?>
        </div>
      </section>
    <?php }

    wp_reset_postdata();
  endif; ?>
</div><!-- .container -->

<?php get_footer(); ?>
