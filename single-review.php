<?php get_header(); ?>

<?php 
$review_id = get_the_ID();

// Array to fill with content parts
$content = array();
$images = array();

// TAXONOMIES
$crypto_terms   = get_the_terms( $review_id, 'cryptocurrency' );
$game_terms     = get_the_terms( $review_id, 'game' );
$provider_terms = get_the_terms( $review_id, 'provider' );
$payment_terms  = get_the_terms( $review_id, 'payment' ); 
$country_terms  = get_the_terms( $review_id, 'country' );

function terms_to_box($terms, $title) {
  if (!is_array($terms)) return;
  
  ob_start(); ?>
  
  <div class="box <?php echo (count($terms) > 10) ? 'show-more-list' : ''; ?>">
    <h3 class="title"><?php echo $title; ?></h3>
    <ul>
      <?php foreach ($terms as $index => $term): 
        $icon = get_field('icon', $term); ?>

        <li class="<?php echo ($index > 10) ? 'list-item-hidden' : ''; ?>">
          <?php if (isset($icon['sizes']['site-small-logo'])) { ?>
            <img src="<?php echo $icon['sizes']['site-small-logo']; ?>" width="25" height="25">
          <?php } ?>
          <?php echo $term->name; ?>
        </li>
      <?php endforeach; ?>
    </ul>

    <?php if (count($terms) > 10) { ?>
      <div class="box__footer">
        <button class="button button__outline" id="expand-review-list">+</button>
      </div>
    <?php }; ?>
  </div>
  <?php return ob_get_clean(); 
}


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

$images[] = $homepageImg;
$images[] = $gamesImg;
$images[] = $bettingImg;
$images[] = 'https://bitcoin-chaser.local/wp-content/uploads/2019/06/Stake-Casino-Games..jpg';
$images[] = 'https://bitcoin-chaser.local/wp-content/uploads/2019/06/FortuneJack-Live-Casino-Games..jpg';

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
$support_channels = $support_group['channels'];
if ($support_content) $content['Support'] = $support_content;

/* Languages */
$languages = get_field('languages'); 

/* Mobile */
$mobile_content = get_field('mobile');
if ($mobile_content) $content['Mobile'] = $mobile_content;

/* Conclusion */
$conclusion = get_field('conclusion');
if ($conclusion) $content['Conclusion'] = $conclusion;
?>

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

  <!-- Details -->
  <section style="margin-top: 3rem;">
    <div class="details-section__boxes">
      <?php echo terms_to_box($crypto_terms, 'Cryptocurrency'); ?> 
      <?php echo terms_to_box($game_terms, 'Games'); ?> 
      <?php echo terms_to_box($provider_terms, 'Providers'); ?> 
      <?php echo terms_to_box($payment_terms, 'Payments'); ?> 
    </div>
  </section>

  <!-- Bonuses -->
  <?php
  $bonus_query = get_bonuses_by_review_query(get_the_ID()); 
  if ( $bonus_query->have_posts() ) :
    
    echo '<section style="margin-top: 3rem;">';
      echo '<h2>Bonuses</h2>';
      echo '<div class="row">';
        while ( $bonus_query->have_posts() ) : $bonus_query->the_post();  
          echo '<div class="col-12 col-md-6 col-lg-3 mt-3">';
          get_template_part('template-parts/card/card', 'shanghai');
          echo '</div>';
        endwhile;
      echo '</div>';
    echo '</section>';
  endif; ?>

  <!-- Content -->
  <section style="margin-top: 3rem;">
    <h2>Review</h2>
    <div class="row">
      <div class="col-12 col-md-8">
      <?php 
        if ($introduction) echo $introduction; 
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
      </div>
    </div><!-- .row -->
  </section>
  
  
  <!-- Screenshots -->
   <section style="margin-top: 3rem;">
      <h2>Gallery</h2>
      <div class="gallery">
        <?php foreach($images as $image) { ?>
          <div class="gallery-item">
            <img src="<?php echo $image; ?>" style="width: 100%; height: auto;" />
          </div>
        <?php } ?>
      </div>
   </section>


 
</div><!-- .container -->

<?php get_footer(); ?>