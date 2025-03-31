<?php get_header(); ?>

<?php 
$review_id = get_the_ID();

// Array to fill with content parts
$content = array();
$images = array();


// Post From Same Site Query
$same_site_posts_query = new WP_Query(array(
  'post_type'      => 'post', 
  'posts_per_page' => 8, 
  'meta_query'     => array(
    array(
      'key'     => 'post-review-relationship', 
      'value'   => '"' . $id . '"', 
      'compare' => 'LIKE'
      )
    )
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
$details_group = get_field('details_group');
$name          = $details_group['name']; 
$link          = $details_group['affiliate_link']; 
$bonus         = $details_group['bonus']; 
$closed        = $details_group['closed']; // nothing or 1 

/* Media Group */
$media        = get_field('media_group');
$theme_color  = $media['theme_color'];
$homepageImg  = $media['homepage'];
$gamesImg     = $media['games'];
$bettingImg   = $media['betting'];

if ($homepageImg) $images[] = $homepageImg;
if ($gamesImg) $images[] = $gamesImg;
if ($bettingImg) $images[] = $bettingImg; 

/* Introduction */
$introduction = get_field('introduction');

/* Sign Up */
$sign_up_content = get_field('sign_up');
if ($sign_up_content) $content['Sign Up'] = $sign_up_content;

/* KYC */
$kyc_content = get_field('kyc'); 
if ($kyc_content) $content['KYC'] = $kyc_content;

/* Games Group */
$games_group       = get_field('games_group');
$games_content     = $games_group['games'];
$providers_content = $games_group['providers']; 
if ($games_content) $content['Casino Games'] = $games_content;
if ($providers_content) $content['Providers'] = $providers_content;

/* Sports Betting */
$betting_content = get_field('betting'); 
if ($betting_content) $content['Sports Betting'] = $betting_content;

/* Bonuses */
$bonus_content = get_field('bonuses');
if ($bonus_content) $content['Bonuses'] = $bonus_content;

/* Payments Group */
$payments_content = get_field('payments'); 
if ($payments_content) $content['Payments'] = $payments_content;

/* VIP Program */
$vip_content = get_field('vip_program');
if ($vip_content) $content['VIP Program'] = $vip_content;

/* Support Group */
$support_group    = get_field('support_group');
$support_content  = $support_group['content'];
if ($support_content) $content['Support'] = $support_content;

/* Mobile */
$mobile_content = get_field('mobile');
if ($mobile_content) $content['Mobile'] = $mobile_content;

/* Conclusion */
$conclusion = get_field('conclusion');
if ($conclusion) $content['Conclusion'] = $conclusion;

// TAXONOMIES
$crypto_terms   = get_the_terms( $review_id, 'cryptocurrency' );
$game_terms     = get_the_terms( $review_id, 'game' );
$provider_terms = get_the_terms( $review_id, 'provider' );
$payment_terms  = get_the_terms( $review_id, 'payment' ); 
$country_terms  = get_the_terms( $review_id, 'country' );

$languages = get_field('languages'); 
$support_channels = $support_group['channels'];


function terms_to_box($terms, $title) {
  if (!is_array($terms)) return;
  
  // Define a consistent threshold
  $threshold = 10;
  
  ob_start(); ?>
  
  <div class="box <?php echo (count($terms) > $threshold) ? 'show-more-list' : ''; ?>">
    <div class="box__content">
      <h3 class="title"><?php echo $title; ?></h3>
      <ul>
       <?php foreach ($terms as $index => $term):
          // Determine the term name based on the data type.
          $term_name = is_object($term) ? $term->name : $term;
          // Only attempt to retrieve an icon if we have a WP_Term object.
          $icon = is_object($term) ? get_field('icon', $term) : null;
        ?>

          <li class="<?php echo ($index >= $threshold) ? 'list-item-hidden' : ''; ?>">
            <?php if ($icon && isset($icon['sizes']['site-small-logo'])) { ?>
              <img src="<?php echo $icon['sizes']['site-small-logo']; ?>" width="25" height="25">
            <?php } ?>
            <?php echo esc_html($term_name); ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div><!-- .box__content -->


    <?php if (count($terms) > $threshold) { ?>
      
      <div class="box__footer">
        <span id="expand-review-list">+</span>
      </div>
      
    <?php }; ?>
  </div>
  <?php return ob_get_clean(); 
};

?>

<!-- Image overlay --> 
<?php if (count($images) > 0) : ?>
<div class="gallery-overlay" id="gallery-overlay">
  <div class="container">
    <div class="gallery-overlay__layout">
      <div class="gallery-overlay-header">
        <span class="close-overlay" id="close-overlay"><?php echo get_svg_icon('close'); ?></span>
      </div>
      <div class="gallery-overlay-content">
        <img src="" alt="" id="gallery-overlay-image" width="900" height="450">
      </div>
      <div class="gallery-overlay-footer">
        <div class="gallery">
          <?php foreach($images as $image) { ?>
          <div 
            class="gallery-item overlay" 
            style="background-image: url('<?php echo $image['sizes']['medium']; ?>');" 
            data-source="<?php echo $image['sizes']['large']; ?>"
            ></div>
          <?php } ?>
        </div><!-- .gallery --> 
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="container">
  
  <!-- Header -->
  <div class="review-header">
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
      <div class="cta-box">
        <p><?php echo get_svg_icon('present'); ?><?php echo $bonus; ?></p>
        <a href="<?php echo $link; ?>" class="button button__primary">Sign Up</a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-lg-4">

      <div class="details-section__boxes" style="margin-top: 3rem;">
        <?php echo terms_to_box($crypto_terms, 'Cryptocurrency'); ?> 
        <?php echo terms_to_box($game_terms, 'Games'); ?> 
        <?php echo terms_to_box($provider_terms, 'Providers'); ?> 
        <?php echo terms_to_box($payment_terms, 'Payments'); ?> 
        <?php echo terms_to_box($languages, 'Languages'); ?> 
        <?php echo terms_to_box($support_channels, 'Support'); ?> 
      </div>
    </div>

    <div class="col-12 col-lg-8">
      <!-- Bonuses -->
      <?php
      $bonus_query = get_bonuses_by_review_query(get_the_ID()); 
      if ( $bonus_query->have_posts() ) :
        echo '<section style="margin-top: 2rem;">';
          outputNewSlideHTML(array(
            'query'   => $bonus_query,
            'heading' => 'Bonuses',
            'card_type' => 'shanghai'
          )); 
        echo '</section>';
      endif; ?>

      <!-- Content -->
      <section style="margin-top: 2rem;">
        <h2 class="h4" style="font-weight: bold;">Review</h2>
        <?php 
          if ($introduction) echo '<div class="introduction">' . $introduction . '</div>'; 
          foreach($content as $key => $value) { ?>
            <div class="content-dropdown">
              <div class="content-dropdown__controls">
                <h3 class="h4 title"><?php echo $key; ?></h3>
                <span><?php echo get_svg_icon('chevron-down'); ?></span>
              </div>
              <div class="content-dropdown__content">
                <?php echo $value; ?>
              </div>
            </div>
          <?php }
        ?>
      </section>

      <!-- Screenshots -->
      <?php if (count($images) > 0) : ?>
      <section style="margin-top: 2rem;">
        <h2 class="h4" style="font-weight: bold;">Gallery</h2>
        <div class="gallery">
          <?php foreach($images as $image) { ?>
            <div 
              class="gallery-item overlay" 
              style="background-image: url('<?php echo $image['sizes']['medium']; ?>');" 
              data-source="<?php echo $image['sizes']['large']; ?>"></div>
          <?php } ?>
        </div>
      </section>
      <?php endif; ?>

      <!-- Articles -->
      <?php
      $bonus_query = get_bonuses_by_review_query(get_the_ID()); 
      if ( $bonus_query->have_posts() ) :
        echo '<section style="margin-top: 2rem;">';
          outputNewSlideHTML(array(
            'query'   => $same_site_posts_query,
            'heading' => 'News and Promos',
            // 'card_type' => 'shanghai'
          )); 
        echo '</section>';
      endif; ?>

    </div><!-- .col -->
  </div><!-- .row -->
  
  <?php if (!$closed) { 
    if ( $more_sites->have_posts() ) : ?>
      <section class="mt-5 pt-4">
        <?php 
          outputNewSlideHTML(array(
            'query'   => $more_sites,
            'heading' => 'Top Sites'
          ));
        ?>
      </section>
    <?php endif; 
  }; ?> 

 
</div><!-- .container -->

<?php get_footer(); ?>