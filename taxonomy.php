<?php
  get_header();

  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

  $term      = get_queried_object();
  $term_id   = $term->term_id;
  $taxonomy  = $term->taxonomy;
  $term_name = $term->name;

  $acf_heading = trim((string) get_field('heading', $term));
  $icon    = get_field('icon', $term);
  $hasIcon = $icon && is_array($icon);

  $term_updated_by = get_term_meta($term_id, '_bs_term_updated_by', true);
  $term_updated_at = get_term_meta($term_id, '_bs_term_updated_at', true);

  $query = build_taxonomy_main_query( $term, $paged );
  
  if ($acf_heading !== '') {
    $title_output = $acf_heading;
  } else {
      $title_output = $term_name . ' Casinos and Gambling Sites';
      if ($taxonomy == 'cryptocurrency') $title_output = 'Top ' . $term_name . ' Casinos of 2026';
      if ($taxonomy == 'payment') $title_output = 'Top Crypto ' . $term_name . ' Casinos of 2026';
      if ($taxonomy == 'provider') $title_output = 'Top ' . $term_name . ' Crypto Casinos of 2026';
      if ($taxonomy == 'country') $title_output = 'Bitcoin and Crypto Casinos in ' . $term_name . ' 2026';
      if ($taxonomy == 'license') $title_output = 'Top ' . $term_name . ' Licensed Crypto Casinos of 2026';
      if ($taxonomy == 'game') {
          $title_output = $term_name == 'Live Casino'
              ? 'Top ' . $term_name . ' Sites of 2026'
              : 'Top Crypto ' . $term_name . ' Casinos of 2026';
      }
  }

?>

<?php get_template_part('template-parts/breadcrumbs/breadcrumbs'); ?> 

<div class="container">
  <header class="taxonomy-header">
    <h1><?php echo esc_html($title_output); ?></h1>

    <?php if ($term_updated_by) : ?>
      <?php get_template_part('template-parts/content/content-author', null, [
        'author_id'  => (int) $term_updated_by,
        'updated_at' => $term_updated_at,
      ]); ?>
    <?php endif; ?>

    <?php if (term_description()) { ?>
      <div class="taxonomy-header__description main--content">
        <?php echo term_description(); ?>
      </div>
    <?php }; ?>
  </header>
</div>

<!-- MAIN QUERY -->
<?php taxonomy_main_query($query, $term); ?>



<!--MAIN CONTENT-->
<div class="container">
  <?php if ($paged == 1) : ?>

    <section class="grid grid-cols-1 md:grid-cols-12 gap-4">
      <div class="col-span-1 md:col-span-8 main--content">

        <!-- Flexible Content -->
        <?php get_template_part('template-parts/content/flexible-content', null, [
          'post_id' => $term_id,
          'type'    => 'term',
        ]); ?>


        <?php 
          $main_content = get_field('main_content', $term); 
          
          if ($main_content) {
              echo '<hr />'; 
              echo $main_content;
          }

          if (get_field('faqs', $term)) {
            get_template_part('template-parts/content/content', 'faqs');
          } 
        ?>
  
      </div>
    </section>

    <?php if ( bs_theme_is_us_map_term( $term ) ) : ?>
      <?php get_template_part('template-parts/section/us-map', null, array(
        'statuses' => bs_theme_us_map_statuses(),
        'states'   => bs_theme_us_map_states(),
      )); ?>
    <?php endif; ?>

    <!-- RELATED -->
    <?php
      $related_config = [
        'provider'       => ['field' => 'related_provider', 'heading' => 'Providers Like ' . $term_name],
        'cryptocurrency' => ['field' => 'related_crypto',    'heading' => 'Cryptocurrency Like ' . $term_name],
        'game'           => ['field' => 'related_game',      'heading' => 'Games Like ' . $term_name],
      ];

      $related_terms   = [];
      $related_heading = '';

      if (isset($related_config[$taxonomy])) {
        $related_terms   = get_field($related_config[$taxonomy]['field'], $term) ?: [];
        $related_heading = $related_config[$taxonomy]['heading'];
      }
    ?>

    <?php if (!empty($related_terms)) : ?>
      <section class="angus-section mt-5">
        <div class="sec-head">
          <div class="sec-head__l">
            <span class="sec-head__bar"></span>
            <div class="sec-head__titles">
              <h2 class="sec-head__title"><?php echo esc_html($related_heading); ?></h2>
            </div>
          </div>
        </div>
        <div class="layout">
          <?php
            // card-chongqing.php reads an ambient $term, so stash/restore the
            // current term around the loop instead of duplicating the card markup.
            $current_term = $term;
            foreach ($related_terms as $term) {
              include locate_template('template-parts/card/card-chongqing.php');
            }
            $term = $current_term;
          ?>
        </div>
      </section>
    <?php endif; ?>

    <?php get_template_part('template-parts/section/latest-posts-review', null, array(
      'exclude' => array()
    )); ?>

  <?php endif; ?>
</div><!-- .container -->

<?php get_footer(); ?>