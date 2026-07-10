<?php get_header();

$bs_use_homepage_cache   = ! is_user_logged_in();
$bs_cached_homepage_html = $bs_use_homepage_cache ? get_transient( BS_HOMEPAGE_CACHE_KEY ) : false;

if ( $bs_cached_homepage_html !== false ) {
  echo $bs_cached_homepage_html;
  get_footer();
  return;
}

if ( $bs_use_homepage_cache ) {
  ob_start();
}

$used_posts = array();

$featured_post_args = array(
  'post_type'      => 'post',
  'posts_per_page' => 3,
);
$featured_post_query = new WP_Query( $featured_post_args );

// ── Pills grid config ──────────────────────────────────────────────────────
$pills_per_section = 4;

$pill_sections = array(
  bs_get_geo_top_sites(),
  array( 'field' => 'no_kyc_sites',         'title' => 'No-KYC Sites',         'link' => '/anonymous-casinos/' ),
  array( 'field' => 'instant_payout_sites', 'title' => 'Instant Payout Sites', 'link' => '/instant-withdrawal-crypto-casinos/' ),
);
?>

<?php get_template_part( 'template-parts/section/icon-nav' ); ?>

<div class="container">

  <!-- Review Pills Grid -->
  <section class="pills-grid">
    <div class="pills-grid__list">

      <?php foreach ( $pill_sections as $section ) :
        if ( ! empty( $section['post_ids'] ) ) {
          $post_ids     = $section['post_ids'];
          $aff_link_map = [];
        } else {
          $rows = get_field( $section['field'], 'options' );
          if ( empty( $rows ) ) continue;

          $rows     = array_slice( $rows, 0, $pills_per_section );
          $post_ids = array_column( $rows, 'review' );
          if ( empty( $post_ids ) ) continue;

          $aff_link_map = [];
          foreach ( $rows as $row ) {
            if ( ! empty( $row['review'] ) ) {
              $aff_link_map[ $row['review'] ] = $row['affiliate_link'] ?? '';
            }
          }
        }

        $section_query = new WP_Query( array(
          'post_type'      => 'review',
          'orderby'        => 'post__in',
          'post__in'       => $post_ids,
          'posts_per_page' => $pills_per_section,
        ) );

        if ( ! $section_query->have_posts() ) continue;
      ?>
        <div class="pills-box">
          <header class="pills-box__header">
            <h2 class="pills-box__title"><?php echo esc_html( $section['title'] ); ?></h2>
            <?php if ( ! empty( $section['link'] ) ) : ?>
              <a class="pills-box__link" href="<?php echo esc_url( $section['link'] ); ?>">View all <?php echo get_svg_icon('arrow-right'); ?></a>
            <?php endif; ?>
          </header>
          <?php
          $rank = 0;
          while ( $section_query->have_posts() ) :
            $section_query->the_post();
            $rank++;
            get_template_part( 'template-parts/card/review-pill', null, [
              'rank'     => $rank,
              'is_top'   => $rank === 1,
              'aff_link' => $aff_link_map[ get_the_ID() ] ?? '',
            ] );
          endwhile;
          wp_reset_postdata();
          ?>
        </div>
      <?php endforeach; ?>

    </div>
  </section>

  <!-- LATEST -->
  <section class="hp-section">
    <div class="sec-head">
      <div class="sec-head__l">
        <span class="sec-head__bar"></span>
        <div class="sec-head__titles">
          <span class="sec-head__kicker">Fresh Today</span>
          <h2 class="sec-head__title">Latest</h2>
        </div>
      </div>
    </div>
    <div class="posts-row posts-row--3 mt-4">
      <?php if ( $featured_post_query->have_posts() ) : ?>
        <?php while ( $featured_post_query->have_posts() ) : $featured_post_query->the_post() ?>
          <?php get_template_part('template-parts/card/card', 'beijing', array('exclude_lazyload' => true)); ?>
          <?php $used_posts[] = get_the_ID(); ?>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      <?php endif; ?>
    </div>
  </section>

  <!-- BONUSES -->
  <?php
  $bonus_ids   = get_field( 'bonuses', 'options' ) ?: [];
  $bonus_posts = [ 123822, 122577 ];
  $bonus_rows  = array_map( fn( $id ) => [ 'review' => $id, 'affiliate_link' => '' ], $bonus_ids );

  if ( $bonus_rows || $bonus_posts ) :
    get_template_part( 'template-parts/section/topic-section', null, [
      'heading'        => 'Bonuses',
      'kicker'         => 'Top Picks',
      'link'           => [ 'url' => home_url( '/bonuses/' ), 'title' => 'View all', 'target' => '' ],
      'rows'           => $bonus_rows,
      'posts'          => $bonus_posts,
      'pill_post_type' => 'bonus',
      'pill_template'  => 'template-parts/card/bonus-pill',
    ] );
  endif;
  ?>

  <!-- NEWS -->
  <?php
  $news_query = new WP_Query( [
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'category_name'  => 'news',
    'post__not_in'   => $used_posts,
  ] );
  $used_posts = array_merge( $used_posts, wp_list_pluck( $news_query->posts, 'ID' ) );

  if ( $news_query->have_posts() ) : ?>
    <section class="hp-section">
      <div class="sec-head">
        <div class="sec-head__l">
          <span class="sec-head__bar"></span>
          <div class="sec-head__titles">
            <span class="sec-head__kicker">Breaking Stories</span>
            <h2 class="sec-head__title">News</h2>
          </div>
        </div>
        <a class="sec-head__link" href="<?php echo esc_url( home_url( '/category/news/' ) ); ?>">
          <span>View all</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
        </a>
      </div>
      <div class="posts-row mt-4">
        <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
          <?php get_template_part( 'template-parts/card/card', 'beijing' ); ?>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- PROMOTIONS -->
  <?php
  $promos_term       = get_term_by( 'slug', 'promotions', 'category' );
  $promos_review_ids = $promos_term ? ( get_field( 'featured_reviews', $promos_term ) ?: [] ) : [];
  $promos_posts      = $promos_term ? ( get_field( 'featured_posts',   $promos_term ) ?: [] ) : [];
  $promos_rows       = array_map( fn( $id ) => [ 'review' => $id, 'affiliate_link' => '' ], $promos_review_ids );

  if ( ! empty( $promos_posts ) ) {
    $promos_posts = array_diff( $promos_posts, $used_posts );
  }

  if ( empty( $promos_posts ) ) {
    $promos_query = new WP_Query( [
      'post_type'      => 'post',
      'post_status'    => 'publish',
      'posts_per_page' => 2,
      'category_name'  => 'promotions',
      'post__not_in'   => $used_posts,
    ] );
    $promos_posts = wp_list_pluck( $promos_query->posts, 'ID' );
  }

  $used_posts = array_merge( $used_posts, $promos_posts );

  if ( $promos_rows || $promos_posts ) :
    get_template_part( 'template-parts/section/topic-section', null, [
      'heading' => 'Promotions',
      'kicker'  => 'Claim Your Edge',
      'link'    => [ 'url' => get_term_link( $promos_term ), 'title' => 'View all', 'target' => '' ],
      'rows'    => $promos_rows,
      'posts'   => $promos_posts,
    ] );
  endif;
  ?>

  <!-- SPORTS -->
  <?php
  $sports_term       = get_term_by( 'slug', 'sports', 'review_type' );
  $sports_review_ids = $sports_term ? ( get_field( 'featured_reviews', $sports_term ) ?: [] ) : [];
  $sports_posts      = $sports_term ? array_diff( get_field( 'featured_posts', $sports_term ) ?: [], $used_posts ) : [];
  $sports_rows       = array_map( fn( $id ) => [ 'review' => $id, 'affiliate_link' => '' ], $sports_review_ids );
  $used_posts        = array_merge( $used_posts, $sports_posts );

  if ( $sports_rows || $sports_posts ) :
    get_template_part( 'template-parts/section/topic-section', null, [
      'heading' => 'Sports Betting',
      'kicker'  => 'Bet on It',
      'link'    => [ 'url' => $sports_term ? get_term_link( $sports_term ) : home_url( '/sites/sports/' ), 'title' => 'View all', 'target' => '' ],
      'rows'    => $sports_rows,
      'posts'   => $sports_posts,
    ] );
  endif;
  ?>

</div><!-- .container -->

<!-- STREAMERS -->
<?php
$homepage_streamers_query = new WP_Query([
  'post_type'      => 'streamer',
  'posts_per_page' => 8,
  'orderby'        => 'rand',
]);

if ( $homepage_streamers_query->have_posts() ) : ?>
<div class="container mt-5">
  <div class="sec-head">
    <div class="sec-head__l">
      <span class="sec-head__bar"></span>
      <div class="sec-head__titles">
        <span class="sec-head__kicker">Watch Live</span>
        <h2 class="sec-head__title">Streamers</h2>
      </div>
    </div>
    <a class="sec-head__link" href="https://bitcoinchaser.com/streamers/">
      <span>View all</span>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
    </a>
  </div>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4 mt-3">
    <?php while ( $homepage_streamers_query->have_posts() ) : $homepage_streamers_query->the_post(); ?>
      <?php get_template_part('template-parts/card/card', 'streamer'); ?>
    <?php endwhile; wp_reset_postdata(); ?>
  </div>
</div>
<?php endif; ?>

<div class="container">

  <!-- VIP -->
  <?php
  $vip_term       = get_term_by( 'slug', 'vip', 'category' );
  $vip_review_ids = $vip_term ? ( get_field( 'featured_reviews', $vip_term ) ?: [] ) : [];
  $vip_posts      = $vip_term ? array_diff( get_field( 'featured_posts', $vip_term ) ?: [], $used_posts ) : [];
  $vip_rows       = array_map( fn( $id ) => [ 'review' => $id, 'affiliate_link' => '' ], $vip_review_ids );
  $used_posts     = array_merge( $used_posts, $vip_posts );

  if ( $vip_rows ) :
    get_template_part( 'template-parts/section/topic-section', null, [
      'heading' => 'VIP Programs',
      'kicker'  => 'Loyalty & Rewards',  
      'link'    => [ 'url' => get_term_link( $vip_term ), 'title' => 'View all', 'target' => '' ],
      'rows'    => $vip_rows,
      'posts'   => $vip_posts,
    ] );
  endif;
  ?>

  <!-- CRASH SITES -->
  <?php
  $crash_term       = get_term_by( 'slug', 'crash', 'game' );
  $crash_review_ids = $crash_term ? ( get_field( 'featured_reviews', $crash_term ) ?: [] ) : [];
  $crash_posts      = $crash_term ? array_diff( get_field( 'featured_posts', $crash_term ) ?: [], $used_posts ) : [];
  $crash_rows       = array_map( fn( $id ) => [ 'review' => $id, 'affiliate_link' => '' ], $crash_review_ids );
  $used_posts       = array_merge( $used_posts, $crash_posts );

  if ( $crash_rows ) :
    get_template_part( 'template-parts/section/topic-section', null, [
      'heading' => 'Crash Sites',
      'kicker'  => 'To The Moon', 
      'link'    => [ 'url' => $crash_term ? get_term_link( $crash_term ) : home_url( '/game/crash/' ), 'title' => 'View all', 'target' => '' ],
      'rows'    => $crash_rows,
      'posts'   => $crash_posts,
    ] );
  endif;
  ?>

  <!-- EDITOR'S PICK -->
  <?php
  $editors_pick_ids = array_diff( get_field( 'articles', 'options' ) ?: [], $used_posts );
  $used_posts       = array_merge( $used_posts, $editors_pick_ids );
  if ( ! empty( $editors_pick_ids ) ) :
    get_template_part( 'template-parts/section/editors-pick', null, [
      'post_ids' => $editors_pick_ids,
    ] );
  endif;
  ?>

  <!-- ONLINE POKER -->
  <?php
  $poker_term       = get_term_by( 'slug', 'online-poker', 'review_type' );
  $poker_review_ids = $poker_term ? ( get_field( 'featured_reviews', $poker_term ) ?: [] ) : [];
  $poker_posts      = $poker_term ? array_diff( get_field( 'featured_posts', $poker_term ) ?: [], $used_posts ) : [];
  $poker_rows       = array_map( fn( $id ) => [ 'review' => $id, 'affiliate_link' => '' ], $poker_review_ids );
  $used_posts       = array_merge( $used_posts, $poker_posts );

  if ( $poker_rows ) :
    get_template_part( 'template-parts/section/topic-section', null, [
      'heading' => 'Online Poker',
      'kicker'  => 'Cards & Crypto',
      'link'    => [ 'url' => $poker_term ? get_term_link( $poker_term ) : home_url( '/sites/online-poker/' ), 'title' => 'View all', 'target' => '' ],
      'rows'    => $poker_rows,
      'posts'   => $poker_posts,
    ] );
  endif;
  ?>

  <!-- STRATEGY -->
  <?php
  $strategy_term = get_term_by('slug', 'strategy', 'category');
  if ($strategy_term) :
    $strategy_q = new WP_Query([
      'post_type'      => 'post',
      'post_status'    => 'publish',
      'posts_per_page' => 4,
      'cat'            => $strategy_term->term_id,
      'post__not_in'   => $used_posts,
    ]);
    $used_posts = array_merge( $used_posts, wp_list_pluck( $strategy_q->posts, 'ID' ) );
    if ($strategy_q->have_posts()) :
      get_template_part('template-parts/section/posts-section', null, [
        'heading' => 'Strategy',
        'kicker'  => 'Play Smarter',
        'link'    => get_term_link($strategy_term),
        'posts'   => $strategy_q->posts,
      ]);
    endif;
    wp_reset_postdata();
  endif;
  ?>

  <!-- ALTERNATIVES -->
  <?php
  $alternatives_term = get_term_by('slug', 'alternatives', 'category');
  if ($alternatives_term) :
    $alternatives_q = new WP_Query([
      'post_type'      => 'post',
      'post_status'    => 'publish',
      'posts_per_page' => 4,
      'cat'            => $alternatives_term->term_id,
      'post__not_in'   => $used_posts,
    ]);
    $used_posts = array_merge( $used_posts, wp_list_pluck( $alternatives_q->posts, 'ID' ) );
    if ($alternatives_q->have_posts()) :
      get_template_part('template-parts/section/posts-section', null, [
        'heading' => 'Alternatives',
        'kicker'  => 'Similar Sites',
        'link'    => get_term_link($alternatives_term),
        'posts'   => $alternatives_q->posts,
      ]);
    endif;
    wp_reset_postdata();
  endif;
  ?>

  <!-- WALLETS -->
  <?php
  $wallets_term = get_term_by('slug', 'wallets', 'category');
  if ($wallets_term) :
    $wallets_q = new WP_Query([
      'post_type'      => 'post',
      'post_status'    => 'publish',
      'posts_per_page' => 4,
      'cat'            => $wallets_term->term_id,
      'post__not_in'   => $used_posts,
    ]);
    $used_posts = array_merge( $used_posts, wp_list_pluck( $wallets_q->posts, 'ID' ) );
    if ($wallets_q->have_posts()) :
      get_template_part('template-parts/section/posts-section', null, [
        'heading' => 'Wallets',
        'kicker'  => 'Gamble Securely',
        'link'    => get_term_link($wallets_term),
        'posts'   => $wallets_q->posts,
      ]);
    endif;
    wp_reset_postdata();
  endif;
  ?>

</div><!-- .container -->
<div style="margin-top:3rem"></div><!-- Spacer -->

<?php
if ( $bs_use_homepage_cache ) {
  $bs_homepage_html = ob_get_clean();
  set_transient( BS_HOMEPAGE_CACHE_KEY, $bs_homepage_html, 12 * HOUR_IN_SECONDS );
  echo $bs_homepage_html;
}
get_footer(); ?>
