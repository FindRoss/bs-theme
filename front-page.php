<?php get_header();

$used_posts = array();

$featured_post_args = array(
  'post_type'      => 'post',
  'posts_per_page' => 4,
);
$featured_post_query = new WP_Query( $featured_post_args );

// ── Pills grid config ──────────────────────────────────────────────────────
$pills_per_section = 4; // Change to 4 to show 4 pills per section

$pill_sections = array(
  array( 'field' => 'sites',                'title' => 'Top Sites',            'link' => '' ),
  array( 'field' => 'no_kyc_sites',         'title' => 'No-KYC Sites',         'link' => '/anonymous-casinos/' ),
  array( 'field' => 'instant_payout_sites', 'title' => 'Instant Payout Sites', 'link' => '/instant-withdrawal-crypto-casinos/' ),
);
?>

<?php get_template_part( 'template-parts/section/icon-nav' ); ?>

<div class="container">

  <!-- Review Pills Grid -->
  <section class="pills-grid mt-4">
    <div class="pills-grid__grid">

      <?php foreach ( $pill_sections as $section ) :
        $rows = get_field( $section['field'], 'options' );
        if ( empty( $rows ) ) continue;

        $rows = array_slice( $rows, 0, $pills_per_section );
        $post_ids = array_column( $rows, 'review' );
        if ( empty( $post_ids ) ) continue;

        $section_query = new WP_Query( array(
          'post_type'      => 'review',
          'orderby'        => 'post__in',
          'post__in'       => $post_ids,
          'posts_per_page' => $pills_per_section,
        ) );

        if ( ! $section_query->have_posts() ) continue;

        // Build a map of post ID → affiliate link for quick lookup
        $aff_link_map = [];
        foreach ( $rows as $row ) {
          if ( ! empty( $row['review'] ) ) {
            $aff_link_map[ $row['review'] ] = $row['affiliate_link'] ?? '';
          }
        }
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
                'rank'     => $rank,
                'is_top'   => $rank === 1,
                'aff_link' => $aff_link_map[ get_the_ID() ] ?? '',
              ] );
            endwhile;
            wp_reset_postdata();
            ?>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  </section>

  <!-- LATEST -->
  <section class="mt-4">
    <div class="section-heading">
      <h2 class="section-heading__title h4">Latest</h2>
    </div>
    <div class="posts-row mt-4">
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
  ] );

  if ( $news_query->have_posts() ) : ?>
    <section class="mt-5 pt-4">
      <div class="section-heading">
        <h2 class="section-heading__title h4">
          <a href="<?php echo esc_url( home_url( '/category/news/' ) ); ?>">News <?php echo get_svg_icon( 'chevron-right' ); ?></a>
        </h2>
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

  if ( empty( $promos_posts ) ) {
    $promos_query = new WP_Query( [
      'post_type'      => 'post',
      'post_status'    => 'publish',
      'posts_per_page' => 2,
      'category_name'  => 'promotions',
    ] );
    $promos_posts = wp_list_pluck( $promos_query->posts, 'ID' );
  }

  if ( $promos_rows || $promos_posts ) :
    get_template_part( 'template-parts/section/topic-section', null, [
      'heading' => 'Promotions',
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
  $sports_posts      = $sports_term ? ( get_field( 'featured_posts',   $sports_term ) ?: [] ) : [];
  $sports_rows       = array_map( fn( $id ) => [ 'review' => $id, 'affiliate_link' => '' ], $sports_review_ids );

  if ( $sports_rows || $sports_posts ) :
    get_template_part( 'template-parts/section/topic-section', null, [
      'heading' => 'Sports',
      'link'    => [ 'url' => $sports_term ? get_term_link( $sports_term ) : home_url( '/review-type/sports/' ), 'title' => 'View all', 'target' => '' ],
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
  'orderby'        => 'date',
  'order'          => 'DESC',
]);

if ( $homepage_streamers_query->have_posts() ) : ?>
<section class="review-streamers mt-5">
  <div class="container">
    <h2 class="section-heading__title h4">
      <a href="https://bitcoinchaser.com/streamers/">Streamers <?php echo get_svg_icon('chevron-right'); ?></a>
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4 mt-3">
      <?php while ( $homepage_streamers_query->have_posts() ) : $homepage_streamers_query->the_post(); ?>
        <?php get_template_part('template-parts/card/card', 'streamer'); ?>
      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<div class="container">

  <!-- VIP -->
  <?php
  $vip_term       = get_term_by( 'slug', 'vip', 'category' );
  $vip_review_ids = $vip_term ? ( get_field( 'featured_reviews', $vip_term ) ?: [] ) : [];
  $vip_posts      = $vip_term ? ( get_field( 'featured_posts',   $vip_term ) ?: [] ) : [];
  $vip_rows       = array_map( fn( $id ) => [ 'review' => $id, 'affiliate_link' => '' ], $vip_review_ids );

  if ( $vip_rows || $vip_posts ) :
    get_template_part( 'template-parts/section/topic-section', null, [
      'heading' => 'VIP Programs',
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
  $crash_posts      = $crash_term ? ( get_field( 'featured_posts',   $crash_term ) ?: [] ) : [];
  $crash_rows       = array_map( fn( $id ) => [ 'review' => $id, 'affiliate_link' => '' ], $crash_review_ids );

  if ( $crash_rows || $crash_posts ) :
    get_template_part( 'template-parts/section/topic-section', null, [
      'heading' => 'Crash Sites',
      'link'    => [ 'url' => $crash_term ? get_term_link( $crash_term ) : home_url( '/game/crash/' ), 'title' => 'View all', 'target' => '' ],
      'rows'    => $crash_rows,
      'posts'   => $crash_posts,
    ] );
  endif;
  ?>

  <!-- ONLINE POKER -->
  <?php
  $poker_term       = get_term_by( 'slug', 'online-poker', 'review_type' );
  $poker_review_ids = $poker_term ? ( get_field( 'featured_reviews', $poker_term ) ?: [] ) : [];
  $poker_posts      = $poker_term ? ( get_field( 'featured_posts',   $poker_term ) ?: [] ) : [];
  $poker_rows       = array_map( fn( $id ) => [ 'review' => $id, 'affiliate_link' => '' ], $poker_review_ids );

  if ( $poker_rows || $poker_posts ) :
    get_template_part( 'template-parts/section/topic-section', null, [
      'heading' => 'Online Poker',
      'link'    => [ 'url' => $poker_term ? get_term_link( $poker_term ) : home_url( '/review-type/online-poker/' ), 'title' => 'View all', 'target' => '' ],
      'rows'    => $poker_rows,
      'posts'   => $poker_posts,
    ] );
  endif;
  ?>

</div><!-- .container -->
<div style="margin-top:3rem"></div><!-- Spacer -->

<?php get_footer(); ?>
