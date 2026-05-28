<?php get_header();

$used_posts = array();

$featured_post_args = array(
  'post_type'      => 'post',
  'posts_per_page' => 2,
);
$featured_post_query = new WP_Query( $featured_post_args );

// ── Pills grid config ──────────────────────────────────────────────────────
$pills_per_section = 4; // Change to 4 to show 4 pills per section

$pill_sections = array(
  array( 'field' => 'sites',                'title' => 'Top Sites',            'link' => '' ),
  array( 'field' => 'no_kyc_sites',         'title' => 'No-KYC Sites',         'link' => '/anonymous-casinos/' ),
  array( 'field' => 'vip_sites',            'title' => 'VIP Sites',            'link' => '/vip-casinos-for-high-rollers/' ),
  array( 'field' => 'instant_payout_sites', 'title' => 'Instant Payout Sites', 'link' => '' ),
  array( 'field' => 'us_friendly_sites',    'title' => 'US-Friendly Sites',    'link' => '/country/united-states/'),
  array( 'field' => 'crash_sites',          'title' => 'Crash Sites',          'link' => '/game/crash/' ),
  // array( 'field' => 'new_sites',          'title' => 'New Sites',           'link' => '' ),
);
?>

<div class="container">

  <section class="lothian-section mt-4">
    <h1 class="h2 m-0">Welcome to BitcoinChaser!</h1>
    <p>Discover Bitcoin casino reviews, cryptocurrency sports betting sites, no-deposit bonuses, gambling guides, and more.</p>
  </section>

  <!-- Review Pills Grid -->
  <section class="pills-grid mt-4">
    <div class="pills-grid__grid">

      <?php foreach ( $pill_sections as $section ) :
        $post_ids = get_field( $section['field'], 'options' );
        if ( empty( $post_ids ) ) continue;

        $section_query = new WP_Query( array(
          'post_type'      => 'review',
          'orderby'        => 'post__in',
          'post__in'       => $post_ids,
          'posts_per_page' => $pills_per_section,
        ) );

        if ( ! $section_query->have_posts() ) continue;
      ?>
        <div class="pills-grid__section">
          <header class="pills-grid__header">
            <h2 class="pills-grid__title"><?php echo esc_html( $section['title'] ); ?></h2>
            <?php if ( ! empty( $section['link'] ) ) : ?>
              <a class="pills-grid__link" href="<?php echo esc_url( $section['link'] ); ?>">View all <?php echo get_svg_icon('arrow-right'); ?></a>
            <?php endif; ?>
          </header>
          <div class="pills-grid__pills">
            <?php
            $rank = 0;
            while ( $section_query->have_posts() ) :
              $section_query->the_post();
              $rank++;
              get_template_part( 'template-parts/card/review-pill', null, [
                'rank'   => $rank,
                'is_top' => $rank === 1,
              ] );
            endwhile;
            wp_reset_postdata();
            ?>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  </section>

  <!-- Two lead posts -->
  <section class="mt-4">
    <div class="section-heading">
      <h2 class="section-heading__title h4">Latest</h2>
    </div>
    <div class="dirplus-posts mt-4">
      <?php if ( $featured_post_query->have_posts() ) : ?>
        <?php while ( $featured_post_query->have_posts() ) : $featured_post_query->the_post() ?>
          <div>
            <?php get_template_part('template-parts/card/card', 'beijing', array('exclude_lazyload' => true)); ?>
          </div>
          <?php $used_posts[] = get_the_ID(); ?>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      <?php endif; ?>
    </div>
  </section>

</div><!-- .container -->

<!-- BONUSES -->
<?php
  $bonus_ids_to_include = get_field('bonuses', 'options');

  $featured_bonus_args = array(
    'post_type'      => 'bonus',
    'post_status'    => 'publish',
    'posts_per_page' => 6,
  );

  if ($bonus_ids_to_include) {
    $featured_bonus_args['post__in'] = $bonus_ids_to_include;
    $featured_bonus_args['orderby']  = 'post__in';
  };

  $featured_bonus_query = new WP_Query($featured_bonus_args);

  if ($featured_bonus_query->have_posts()) : ?>

<div class="container mt-5 pt-4">
  <section>
    <div class="section-heading">
      <h2 class="section-heading__title h4">
        <a href="https://bitcoinchaser.com/bonuses/">Bonuses <?php echo get_svg_icon('chevron-right'); ?></a>
      </h2>
    </div>
    <div class="bonus-cards-grid">
      <?php while ($featured_bonus_query->have_posts()) : $featured_bonus_query->the_post(); ?>
        <?php get_template_part('template-parts/card/card', 'shanghai'); ?>
      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </section>
</div>

<?php endif; ?>

<!-- NEWS -->
<?php
  $latest_casino_news_query = new WP_Query(array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'news',
  ));

  $latest_casino_news_foundPosts = $latest_casino_news_query->found_posts;

  if ($latest_casino_news_foundPosts >= 8) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php
         outputNewSlideHTML(array(
          'query' => $latest_casino_news_query,
          'heading' => 'News',
          'link' => '/category/news/'
        ));
      ?>
    </section>
  </div>
<?php }; ?>

<!-- PROMOTIONS -->
<?php
  $promotions_query = new WP_Query(array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'promotions',
  ));

  $promotions_foundPosts = $promotions_query->found_posts;

  if ($promotions_foundPosts >= 8) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php
        outputNewSlideHTML(array(
          'query'   => $promotions_query,
          'heading' => 'Promotions',
          'link'    => '/category/promotions/'
        ));
      ?>
    </section>
  </div>

<?php }; ?>

<!-- SPORTS -->
<?php
  $latest_sports_query = new WP_Query(array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'sports',
  ));

  $latest_sports_foundPosts = $latest_sports_query->found_posts;

  if ($latest_sports_foundPosts >= 8) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php
        outputNewSlideHTML(array(
          'query' => $latest_sports_query,
          'heading' => 'Sports',
          'link' => '/category/sports/'
        ))
      ?>
    </section>
  </div>
<?php }; ?>

<!-- ALTERNATIVES -->
<?php
  $alternatives_query = new WP_Query(array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'category_name'  => 'alternatives'
  ));

  $alternatives_foundPosts = $alternatives_query->found_posts;

  if ($alternatives_foundPosts >= 8) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php
        outputNewSlideHTML(array(
          'query' => $alternatives_query,
          'heading' => 'Alternatives',
          'link' => '/category/alternatives/'
        ));
      ?>
    </section>
  </div>

<?php }; ?>

<!-- BITCOIN CASINOS -->
<?php
  $top_sites = get_field('sites', 'option');

  if ($top_sites) {
    $bitcoin_casinos_query = new WP_Query(array(
      'post_type'      => 'review',
      'post_status'    => 'publish',
      'posts_per_page' => 8,
      'meta_key'       => 'rank',
      'orderby'        => 'meta_value_num',
      'order'          => 'ASC',
    ));

    if ($bitcoin_casinos_query->have_posts()) { ?>

  <div class="container mt-5 pt-4">
    <section>
      <?php
        outputNewSlideHTML(array(
          'query'   => $bitcoin_casinos_query,
          'heading' => 'Bitcoin Casinos',
          'link'    => '/sites/casino/'
        ));

        $bitcoin_term = get_term_by('slug', 'bitcoin', 'cryptocurrency');
        $exclude_ids  = $bitcoin_term ? array($bitcoin_term->term_id) : array();

        $crypto_terms = get_terms(array(
          'taxonomy'   => 'cryptocurrency',
          'hide_empty' => true,
          'orderby'    => 'count',
          'order'      => 'DESC',
          'number'     => 6,
          'exclude'    => $exclude_ids,
        ));

        if (!empty($crypto_terms) && !is_wp_error($crypto_terms)) : ?>
          <div class="coin-chips">
            <span class="coin-chips__label">Browse by coin</span>
            <?php foreach ($crypto_terms as $term) :
              $icon     = get_field('icon', $term);
              $icon_url = $icon['sizes']['thumbnail'] ?? null;
            ?>
              <a class="coin-chip" href="<?php echo esc_url(get_term_link($term)); ?>">
                <?php if ($icon_url) : ?>
                  <img src="<?php echo esc_url($icon_url); ?>" width="18" height="18" alt="" aria-hidden="true">
                <?php endif; ?>
                <?php echo esc_html($term->name); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
    </section>
  </div>

    <?php };
  };
?>

<!-- Spacer -->
<div style="margin-top:3rem"></div>

<?php get_footer(); ?>
