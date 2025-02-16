<?php   
  $details_group = get_field('details_group');
  $name          = $details_group['name']; 
  $link          = $details_group['affiliate_link']; 
  $bonus         = $details_group['bonus']; 

  $mediaGroup = get_field('media_group');
  $siteColor  = $mediaGroup['theme_color'];

  $types  = get_the_terms(get_the_ID(), 'review_type');

  // Get all terms for the post in the specified taxonomy
  $crypto_terms = get_the_terms(get_the_ID(), 'cryptocurrency');

  if (!is_wp_error($crypto_terms) && !empty($crypto_terms)) {
    $total_terms_count = count($crypto_terms); // Total number of terms tagged to the post

    usort($crypto_terms, function ($a, $b) {
        return $b->count - $a->count;
    });

    $top_crypto_terms = array_slice($crypto_terms, 0, 5);

    $crypto_output = ''; 

    foreach ($top_crypto_terms as $term) {
      $icon = get_field('icon', $term);
      if (isset($icon['sizes']['thumbnail']) && !empty($icon['sizes']['thumbnail'])) {
        $thumbnail = $icon['sizes']['thumbnail'];
        $crypto_output .= '<img src="' . $thumbnail . '" class="icon" width="35" height="35">';
      }
    }

    if ($total_terms_count > 5) {
      $crypto_output .= '<span class="icon count-icon">+' . ($total_terms_count - 5) . '</span>'; 
    }
  }

  // $custom_excerpt = mb_strimwidth( get_the_excerpt(), 0, 62, '...' );
?>

<div class="excerpt-review-cover">
  <div class="excerpt-review-cover__media" style="background-color: <?php echo $siteColor; ?>">
    <div class="excerpt-review-cover__media--logo">
      <!-- <a href="<?php the_permalink(); ?>"> -->
        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'site-small-logo'); ?>" width="70" height="40" aria-hidden="true" alt="<?php echo $name . ' logo'; ?>">
      <!-- </a> -->
    </div>
  </div>
  <div class="excerpt-review-cover__content">
    
    <?php if (!empty($types) && !is_wp_error($types)) { ?>
    <div>
      <?php foreach ($types as $type) { 
        $type_name = ($type->name === 'Casinos') ? 'Casino' : $type->name;
      ?>
        <span class="info-pill">
          <span><?php echo $type_name; ?></span>
        </span>
      <?php } ?>
    </div>
    <?php } ?>
    
    <h3><a href="<?php the_permalink(); ?>"><?php echo $name; ?></a></h3>
    <div class="excerpt"><?php the_excerpt(); ?></div>
        
    <?php if (!empty($crypto_terms) && !is_wp_error($crypto_terms)) { ?>
      <div class="crypto-icons">
        <?php echo $crypto_output; ?>
      </div>
    <?php }; ?>


  </div>
  <?php if (!empty($link)) {  ?>
    <div class="excerpt-review-cover__cta">
      <a href="<?php echo the_permalink(); ?>" class="button button__outline">Review</a>
      <a href="<?php echo $link; ?>" class="button button__primary" target="_blank">Play</a>
    </div>
  <?php }; ?>
</div>