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

?>

<?php get_template_part( 'template-parts/section/icon-nav' ); ?>

<div class="container">

  <!-- TOP SITES -->
  <?php
  $top_sites = bs_get_geo_top_sites();
  $top_rows  = array_map( fn( $id ) => [ 'review' => $id ], $top_sites['post_ids'] );

  if ( $top_rows ) :
    get_template_part( 'template-parts/section/review-cards-section', null, [
      'heading' => $top_sites['title'],
      'kicker'  => "Editor's Choice",
      'rows'    => $top_rows,
    ] );
  endif;
  ?>

  <!-- How We Actually Review These Sites -->
  <section class="hp-section review-process">
    <div class="review-process__grid">

      <div class="review-process__content">
        <div class="sec-head">
          <div class="sec-head__l">
            <span class="sec-head__bar"></span>
            <div class="sec-head__titles">
              <span class="sec-head__kicker">Our Standards</span>
              <h2 class="sec-head__title">How We Review Crypto Gambling Sites</h2>
            </div>
          </div>
        </div>

        <div class="review-process__body">
          <p class="review-process__intro">We test every casino and sportsbook ourselves before we write a word about it — signing up, depositing real crypto, chasing down a withdrawal, and sitting in the support queue like any other player. No sponsored scores, no fluff: if licensing is unclear or a bonus buries you in wagering requirements, we say so.</p>
          <a class="review-process__link" href="<?php echo esc_url( home_url( '/how-we-review/' ) ); ?>">
            Read our full methodology
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
          </a>
        </div>
      </div>

      <div class="review-process__badges">
        <?php
        $review_process_badges = [
          '800+ Sites Reviewed',
          '140+ Crypto Tracked',
          'Licensing Checked',
          'Withdrawals Tested',
          'Support Tested',
          'Bonus T&Cs Checked',
        ];
        foreach ( $review_process_badges as $badge ) :
        ?>
          <div class="review-process__badge">
            <span class="review-process__badge-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </span>
            <?php echo esc_html( $badge ); ?>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- NO-KYC SITES -->
  <?php
  $nokyc_rows = get_field( 'no_kyc_sites', 'options' ) ?: [];

  if ( $nokyc_rows ) :
    get_template_part( 'template-parts/section/review-cards-section', null, [
      'heading' => 'No-KYC Sites',
      'kicker'  => 'Play Anonymously',
      'link'    => [ 'url' => home_url( '/anonymous-casinos/' ), 'title' => 'View all', 'target' => '' ],
      'rows'    => $nokyc_rows,
    ] );
  endif;
  ?>

  <!-- INSTANT PAYOUT SITES -->
  <?php
  $instant_rows = get_field( 'instant_payout_sites', 'options' ) ?: [];

  if ( $instant_rows ) :
    get_template_part( 'template-parts/section/review-cards-section', null, [
      'heading' => 'Instant Payout Sites',
      'kicker'  => 'Fast Withdrawals',
      'link'    => [ 'url' => home_url( '/instant-withdrawal-crypto-casinos/' ), 'title' => 'View all', 'target' => '' ],
      'rows'    => $instant_rows,
    ] );
  endif;
  ?>

  

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
  $bonus_ids = get_field( 'bonuses', 'options' ) ?: [];

  if ( $bonus_ids ) :
    get_template_part( 'template-parts/section/bonus-section', null, [
      'ids'     => $bonus_ids,
      'heading' => 'Bonuses',
      'kicker'  => 'Top Picks',
      'link'    => home_url( '/bonuses/' ),
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
    get_template_part( 'template-parts/section/review-cards-section', null, [
      'heading' => 'Online Poker',
      'kicker'  => 'Cards & Crypto',
      'link'    => [ 'url' => $poker_term ? get_term_link( $poker_term ) : home_url( '/sites/online-poker/' ), 'title' => 'View all', 'target' => '' ],
      'rows'    => $poker_rows,
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
