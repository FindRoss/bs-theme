<?php   
  $exclude_lazyload = $args['exclude_lazyload'] ?? false;

  $details_group = get_field('details_group');
  $name          = $details_group['name']; 
  $link          = $details_group['affiliate_link']; 
  $bonus         = $details_group['bonus']; 

  $mediaGroup = get_field('media_group');
  $siteColor  = $mediaGroup['theme_color'];

  $types  = get_the_terms(get_the_ID(), 'review_type');

  // Get all terms for the post in the specified taxonomy
  $crypto_terms = get_the_terms(get_the_ID(), 'cryptocurrency');
  $crypto_output = display_review_crypto($crypto_terms); 


// add function
  
    $truncate_exceprt = truncate_text(get_the_excerpt(), 112);
?>

<div class="card card-absolute hong-kong-card">
  
  <a class="card-absolute__link" href="<?php the_permalink(); ?>" aria-label="Read <?php echo $name; ?> review"></a>
  
  <div class="card__media hong-kong-card__media">
    <div class="hk-card-bg-color" style="background-color: <?php echo $siteColor; ?>">
      <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'site-small-logo'); ?>" width="70" height="40" aria-hidden="true" alt="<?php echo $name . ' logo'; ?>" <?php echo $exclude_lazyload ? 'class="exclude-lazyload"' : ''; ?>>
    </div>
  </div>
  <div class="hong-kong-card__content">
    
  <?php if (!empty($types) && !is_wp_error($types)) { ?>
    <div class="info-pills">
      <?php echo display_review_type($types); ?>
    </div>
  <?php } ?> 
    
    <h3><?php echo $name; ?></h3>
    <div class="excerpt"><?php echo $truncate_exceprt; ?></div>
        
    <?php if (!empty($crypto_terms) && !is_wp_error($crypto_terms)) { ?>
      <div class="crypto-icons">
        <?php echo $crypto_output; ?>
      </div>
    <?php }; ?>


  </div>
  <?php if (!empty($link)) {  ?>
    <div class="card-absolute__ctas hong-kong-card__ctas">
      <a href="<?php echo the_permalink(); ?>" class="button button__outline" aria-label="Read <?php echo $name; ?> review">Review</a>
      <a href="<?php echo $link; ?>" class="button button__primary" target="_blank" aria-label="Goto <?php echo $name; ?>">Play</a>
    </div>
  <?php }; ?>
</div>