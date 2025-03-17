
<?php get_header(); ?>

<?php 
$review_id = get_the_ID();

// Array to fill with contet parts
$contet = array();

// TAXONOMIES
$crypto_terms   = get_the_terms( $review_id, 'cryptocurrency' );
$game_terms     = get_the_terms( $review_id, 'game' );
$provider_terms = get_the_terms( $review_id, 'provider' );
$payment_terms  = get_the_terms( $review_id, 'payment' ); 
$country_terms  = get_the_terms( $review_id, 'country' );

function terms_to_box($terms, $title) {
  if (!is_array($terms)) return;
  
  if (count($terms) > 8) $terms = array_slice($terms, 0, 10);
  
  ob_start(); ?>
  
  <div class="box">
    <h3 class="title"><?php echo $title; ?></h2>
    <ul>
      <?php foreach ($terms as $term): 
        $icon = get_field('icon', $term); ?>

        <li>
          <?php if (isset($icon['sizes']['site-small-logo'])) { ?>
            <img src="<?php echo $icon['sizes']['site-small-logo']; ?>" width="25" height="25">
          <?php } ?>
          <?php echo $term->name; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>


  <?php return ob_get_clean(); 
};


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
        <p><?php echo $bonus; ?></p>
        <a href="<?php echo $link; ?>" class="button button__primary">Sign Up</a>
      </div>
    </div>
  </div>

  <!-- Details -->
  <section style="margin-top: 2rem;">
    <h2>Details</h2>
    <div class="details-section__boxes">

      <?php echo terms_to_box($crypto_terms, 'Crypto'); ?> 

      <div class="box">
        <h3 class="title">Cryptocurrency</h3>
        <ul>
          <li>Bitcoin</li>
          <li>Ethereum</li>
          <li>Litecoin</li>
          <li>Bitcoin Cash</li>
          <li>Cardano</li>
          <li>Stellar</li>
          <li>Chainlink</li>
          <li>Uniswap</li>
        </ul>
      </div><!-- .box -->

      <div class="box">
        <h3 class="title">Games</h3>
        <ul>
          <li>Blackjack</li>
          <li>Slots</li>
          <li>Plinko</li>
          <li>Crash</li>
          <li>Baccarat</li>
          <li>Lottery</li>
          <li>Poker</li>
          <li>Mines</li>
        </ul>
      </div><!-- .box -->


    </div>
  </section>

  <!-- Screenshots -->
  <section style="margin-top: 2rem;">
    <?php 
      if ($introduction) echo $introduction; 
      foreach($content as $key => $value) {
        echo '<h2>' . $key . '</h2>';
        echo $value;  
      }
    
    ?>
    
  </section>
  <!-- Bottom -->


 
</div><!-- .container -->

<?php get_footer(); ?>