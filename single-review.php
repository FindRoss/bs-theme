<?php get_header(); ?>

<!-- Adding cards -->
<!-- https://bitcoinchaser.com/how-we-review/ -->
<!-- https://bitcoinchaser.com/why-casinos-ask-for-your-kyc-data/  -->

<?php
$review_id = get_the_ID();

// Array to fill with content parts
$content = array();
$images = array();

// Post From Same Site Query
$site_posts_query = new WP_Query(
  array(
    'post_type'      => 'post',
    'posts_per_page' => 8,
    'meta_query'     => array(
      'relation' => 'AND', // Important to tell WP how to combine all conditions
      array(
        'key'     => 'post-review-relationship',
        'value'   => '"' . $id . '"',
        'compare' => 'LIKE'
      ),
      array(
        'key'     => 'bonus_expired',
        'value'   => '1',
        'compare' => '!='
      ),
      array(
        'relation' => 'OR',
        array(
          'key'     => 'expiry_date',
          'value'   => current_time('mysql'),
          'compare' => '>',
          'type'    => 'DATETIME',
        ),
        array(
          'key'     => 'expiry_date',
          'value'   => '',
          'compare' => '='
        ),
      ),
    ),
  ),
);

// More Sites Query
$topSites = get_field('sites', 'option');
$filteredTopSites = array_diff($topSites, array($review_id));

$more_sites_args = array(
  'post_type'      => 'review',
  'post__in'       => $filteredTopSites,
  'posts_per_page' => 8,
  'orderby'        => 'post__in'
);
$more_sites = new WP_Query($more_sites_args);


// ACF FIELDS
/* Details Group */
$fields = get_fields();
$details_group = $fields['details_group'];
$name          = $details_group['name'];
$link          = $details_group['affiliate_link'];
$bonus         = $details_group['bonus'];
$closed        = $details_group['closed']; // nothing or 1 

/* Media Group */
$media        = $fields['media_group'];
$theme_color  = $media['theme_color'];
$homepageImg  = $media['homepage'];
$gamesImg     = $media['games'];
$bettingImg   = $media['betting'];

if ($homepageImg) {
  $homepageImg_url = $homepageImg['sizes']['large'];
  $homepageImg_alt = $homepageImg['alt'];
  $homepageImg_cap = $homepageImg['caption'];
  $homepageImg_name = $homepageImg['name'];
}

if ($homepageImg) $images[] = $homepageImg;
if ($gamesImg) $images[] = $gamesImg;
if ($bettingImg) $images[] = $bettingImg;

/* Introduction */
$introduction = $fields['introduction'] ?? '';

/* Sign Up */
$sign_up_content = $fields['sign_up'] ?? '';
if ($sign_up_content) $content['Sign Up'] = $sign_up_content;

/* KYC */
$kyc_content = $fields['kyc'] ?? '';
if ($kyc_content) $content['KYC'] = $kyc_content;

/* Games Group */
$games_group       = $fields['games_group'];
$games_content     = $games_group['games'];
$providers_content = $games_group['providers'];
if ($games_content) $content['Casino Games'] = $games_content;
if ($providers_content) $content['Providers'] = $providers_content;

/* Sports Betting */
$betting_content = $fields['betting'] ?? '';
if ($betting_content) $content['Sports Betting'] = $betting_content;

/* Poker Group */
$poker_content = $fields['poker'] ?? '';
if ($poker_content) $content['Poker'] = $poker_content;

/* Bonuses */
$bonus_content = $fields['bonuses'] ?? '';
if ($bonus_content) $content['Bonuses'] = $bonus_content;

/* Payments Group */
$payments_content = $fields['payments'] ?? '';
if ($payments_content) $content['Payments'] = $payments_content;

/* VIP Program */
$vip_content = $fields['vip_program'] ?? '';
if ($vip_content) $content['VIP Program'] = $vip_content;

/* Support Group */
$support_group    = $fields['support_group'];
$support_content  = $support_group['content'];
if ($support_content) $content['Support'] = $support_content;

/* Mobile */
$mobile_content = $fields['mobile'] ?? '';
if ($mobile_content) $content['Mobile'] = $mobile_content;

/* Conclusion */
$conclusion = $fields['conclusion'] ?? '';
if ($conclusion) $content['Conclusion'] = $conclusion;

// TAXONOMIES
$taxonomies = ['cryptocurrency', 'game', 'provider', 'payment', 'country'];
$all_terms = wp_get_object_terms($review_id, $taxonomies);

$terms_by_tax = [];
foreach ($all_terms as $term) {
  $terms_by_tax[$term->taxonomy][] = $term;
}

// And array of terms by taxonomy: An array of WP_Term Object
$crypto_terms   = $terms_by_tax['cryptocurrency'] ?? [];
$game_terms     = $terms_by_tax['game'] ?? [];
$provider_terms = $terms_by_tax['provider'] ?? [];
$payment_terms  = $terms_by_tax['payment'] ?? [];
$country_terms  = $terms_by_tax['country'] ?? [];

// ACF Fields (simple arrays eg Array ( [0] => English [1] => Français [2] => Deutsch [3] => Español [4]);
$languages = $fields['languages'] ?? [];
$support_channels = $support_group['channels'];

// Faqs
$review_faqs = get_review_faqs($review_id);


?>

<div class="container">

  <!-- CLOSED -->
  <?php if ($closed) { ?>
    <section class="section-closed">
      <div>
        <h2 class="h3">🚩<?php echo $name; ?> is now closed</h2>
        <p>Explore our reviews of <a href="https://bitcoinchaser.com/sites/casino/"> popular crypto casinos</a> or <a href="https://bitcoinchaser.com/sites/sports/">sports betting sites</a> you might enjoy.</p>
        <?php if ($more_sites->have_posts()) :
          outputNewSlideHTML(array('query' => $more_sites));
        endif; ?>
      </div>
    </section>
  <?php } ?>

  <!-- Header -->
  <header class="review-header">
    <div class="review-header__logo">
      <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo $name; ?>" width="500" height="250">
    </div>
    <div class="review-header__info">
      <h1><?php echo $name; ?></h1>
      <?php if (has_excerpt()) { ?>
        <p class="excerpt"><?php echo get_the_excerpt(); ?></p>
      <?php } ?>
    </div>
    <div class="review-header__cta">

      <?php if (!$closed && $link) { ?>
        <div class="cta-box">
          <?php if ($bonus) { ?>
            <p><?php echo get_svg_icon('present'); ?><?php echo $bonus; ?></p>
          <?php } ?>
          <a href="<?php echo $link; ?>" class="button button__primary" target="_blank">Sign Up</a>
        </div>
      <?php }; ?>
      
    </div>
  </header>

 
  <section class="skye-section">
    
    <aside class="skye-section__sidebar">
      <div class="term-boxes">
        <?php echo terms_to_box($crypto_terms, 'Cryptocurrency', true); ?>
        <?php echo terms_to_box($game_terms, 'Games', true); ?>
        <?php echo terms_to_box($provider_terms, 'Providers', true); ?>
        <?php echo terms_to_box($payment_terms, 'Payments', true); ?>
        <?php echo terms_to_box($languages, 'Languages'); ?>
        <?php echo terms_to_box($support_channels, 'Support'); ?>
      </div>
    </aside>

    <main class="skye-section__content">

      <?php
      // Problem with this here. When I remove this section I have no problem

        // Working
        // if (!$closed) {
          
        //   $bonus_query = get_bonuses_by_review_query(get_the_ID());
        //   if ($bonus_query->have_posts()) : 
        //     echo '<section class="section">';
        //     echo '<h2>Bonuses</h2>';
        //     while ($bonus_query->have_posts()) : $bonus_query->the_post();
        //       get_template_part('template-parts/card/card', 'hangzhou');
        //     endwhile;
        //     echo '</section>';
        //     wp_reset_postdata();
        //   endif; 
        // }; 

        // Issues
        // $bonus_query = get_bonuses_by_review_query(get_the_ID());
        // if ($bonus_query->have_posts()) :
        //   echo '<section class="section">';
        //   outputNewSlideHTML(array(
        //     'query'   => $bonus_query,
        //     'heading' => 'Bonuses',
        //     'card_type' => 'shanghai'
        //   ));
        //   echo '</section>';

        //   wp_reset_postdata();
        // endif;
      ?>

      <?php 
        if ($homepageImg) { ?>
          <figure class="homepage-image">
            <img src="<?php echo $homepageImg_url; ?>" alt="<?php echo $homepageImg_alt; ?>">
            <?php if ($homepageImg_cap): ?>
              <figcaption><?php echo $homepageImg_cap; ?></figcaption>
            <?php endif; ?>
          </figure>
          <?php
        };
        ?>

        <section class="content mt-5">
          <h2 class="title">Review</h2>
          <?php the_content(); ?>

          <?php if ($introduction) echo '<div class="introduction">' . $introduction . '</div>';
          foreach ($content as $key => $value) { ?>
            <div class="content-dropdown">
              <div class="content-dropdown__controls">
                <h3 class="h4 title"><?php echo $key; ?></h3>
                <button class="round-icon"><?php echo get_svg_icon('chevron-down'); ?></button>
              </div>
              <div class="content-dropdown__content">
                <?php echo $value; ?>
              </div>
            </div>
          <?php } ?>

        </section>
      

      <!-- FAQS -->

    </main>
  </section> 

  <?php if ($site_posts_query->have_posts()) : ?>
  <section class="skye-section skye-section--reverse mt-5 articles-box">
    <div class="skye-section__sidebar">
      <h4 class="title">Read more about <?php echo $name; ?></h2>
    </div>
    <div class="skye-section__content">
      <?php while ($site_posts_query->have_posts()) : $site_posts_query->the_post(); 
         get_template_part('template-parts/card/card', 'chengdu');
      endwhile; ?>
    </div>
  </section>
  <?php endif; ?>



  
  <!-- MORE SITES -->
  <?php 
    if ($more_sites->have_posts()) : ?>
      <section class="section">
        <?php
        outputNewSlideHTML(array(
          'query'   => $more_sites,
          'heading' => 'Top Sites'
        ));
        ?>
      </section>
  <?php endif; ?>


</div><!-- .container -->

<?php get_footer(); ?>