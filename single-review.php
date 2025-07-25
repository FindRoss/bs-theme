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
$same_site_posts_query = new WP_Query(array(
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
$taxonomies = [ 'cryptocurrency', 'game', 'provider', 'payment', 'country' ];
$all_terms = wp_get_object_terms( $review_id, $taxonomies );

$terms_by_tax = [];
foreach ( $all_terms as $term ) {
    $terms_by_tax[ $term->taxonomy ][] = $term;
}

// Now you can access them like this:
$crypto_terms   = $terms_by_tax['cryptocurrency'] ?? [];
$game_terms     = $terms_by_tax['game'] ?? [];
$provider_terms = $terms_by_tax['provider'] ?? [];
$payment_terms  = $terms_by_tax['payment'] ?? [];
$country_terms  = $terms_by_tax['country'] ?? [];

$languages = $fields['languages'] ?? []; 
$support_channels = $support_group['channels'];

function terms_to_box($terms, $title) {
  if (!is_array($terms) || count($terms) === 0) return;
  
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
              <img src="<?php echo $icon['sizes']['site-small-logo']; ?>" width="25" height="25" alt="<?php echo $icon['alt']; ?>">
            <?php } ?>
            <?php echo esc_html($term_name); ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div><!-- .box__content -->

    <?php if (count($terms) > $threshold) { ?>
      
      <div class="box__footer">
        <!-- <button id="expand-review-list">+</button> -->
        <button id="expand-review-list"><?php echo get_svg_icon('chevron-down'); ?></button>
      </div>
      
    <?php }; ?>
  </div>
  <?php return ob_get_clean(); 
}; ?>

<!-- Image overlay --> 
<?php if (count($images) > 0) : ?>
<div class="gallery-overlay" id="gallery-overlay" aria-hidden="true">
  <div class="container">
    <div class="gallery-overlay__layout">
      <div class="gallery-overlay-header">
        <span class="close-overlay" id="close-overlay" aria-label="Close overlay">
          <?php echo get_svg_icon('close'); ?>
        </span>
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
            tabindex="0"
            role="button"
            aria-label="View larger image"
            ></div>
          <?php } ?>
        </div><!-- .gallery --> 
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="container">

  <!-- CLOSED --> 
  <?php if ($closed) { ?>
    <div class="my-4">
      <div class="p-2 rounded-corners" style="background: #FAFAFA">
        <h2 class="h2"><?php echo $name; ?> is now closed</h2>
        <p class="fs-large">Explore our reviews of <a href="https://bitcoinchaser.com/sites/casino/"> popular crypto casinos</a> or <a href="https://bitcoinchaser.com/sites/sports/">sports betting sites</a> you might enjoy.</p>
        <?php if ($more_sites->have_posts()) :
           outputNewSlideHTML(array('query' => $more_sites)); 
          endif; ?>
      </div>
    </div>
  <?php } ?>
  
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
        <?php if ($bonus) { ?>
          <p><?php echo get_svg_icon('present'); ?><?php echo $bonus; ?></p>
        <?php } ?>
        <a href="<?php echo $link; ?>" class="button button__primary" target="_blank">Sign Up</a>
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
        echo '<section class="section">';
          outputNewSlideHTML(array(
            'query'   => $bonus_query,
            'heading' => 'Bonuses',
            'card_type' => 'shanghai'
          )); 
        echo '</section>';
      endif; ?>

      <!-- Content -->
      <section class="section content">
        <h2 class="h4" style="font-weight: bold;">Review</h2>
        <?php 
          if ($introduction) echo '<div class="introduction">' . $introduction . '</div>'; 
          foreach($content as $key => $value) { ?>
            <div class="content-dropdown">
              <div class="content-dropdown__controls">
                <h3 class="h4 title"><?php echo $key; ?></h3>
                <button><?php echo get_svg_icon('chevron-down'); ?></button>
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
      <section class="section">
        <h2 class="h4" style="font-weight: bold;">Gallery</h2>
        <div class="gallery">
          <?php foreach($images as $image) { ?>
            <div 
              class="gallery-item overlay" 
              style="background-image: url('<?php echo $image['sizes']['medium']; ?>');" 
              data-source="<?php echo $image['sizes']['large']; ?>"
              tabindex="0"
              role="button"
              aria-label="View larger image"
              ></div>
          <?php } ?>
        </div>
      </section>
      <?php endif; ?>

      
      <!-- Articles -->
      <?php
      if ($same_site_posts_query->have_posts()) : 
      $count = 1; ?>
        <section class="section borders-section">
          <h2 class="h4" style="font-weight: bold;">Articles</h2>
          <div class="layout">
            <?php while ($same_site_posts_query->have_posts()) : $same_site_posts_query->the_post(); ?>
            
              <?php 
              
              if ($count == 1) {
                get_template_part('template-parts/card/card', 'chengdu');
              } else if ($count > 1) {
                get_template_part('template-parts/card/card', 'hangzhou');  
              };
              
              ?>
              <?php $count++; ?>
            <?php endwhile; ?>
          </div><!-- .layout -->
        </section>
      <?php endif; ?>

    </div><!-- .col -->
  </div><!-- .row -->
  
  <?php if (!$closed) { 
    if ( $more_sites->have_posts() ) : ?>
      <section class="section">
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