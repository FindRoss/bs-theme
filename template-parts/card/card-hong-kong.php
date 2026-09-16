<?php   
  $exclude_lazyload = $args['exclude_lazyload'] ?? false;

  $details_group = get_field('details_group');
  $name          = $details_group['name'];
  $link          = $details_group['affiliate_link'];

  $bonus_group = get_field('bonus_group') ?: [];
  $bonus_info  = $bonus_group['bonus'] ?? '';
  $bonus_code  = $bonus_group['bonus_code'] ?? '';

  $mediaGroup = get_field('media_group');
  $siteColor  = $mediaGroup['theme_color'];

  $types  = get_the_terms(get_the_ID(), 'review_type');

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

  </div>
  <?php if ($bonus_info) : ?>
    <div class="hong-kong-card__offer">
      <div class="hong-kong-card__offer-text"><?php echo esc_html($bonus_info); ?></div>
      <?php if ($bonus_code) : ?>
        <button class="bonus-code bonus-code--card" type="button" aria-label="Copy bonus code to clipboard">
          <span class="bonus-code__label">Code</span>
          <span class="bonus-code__code"><?php echo esc_html($bonus_code); ?></span>
          <span class="bonus-code__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
            </svg>
          </span>
          <span class="sr-only" aria-live="polite"></span>
        </button>
      <?php endif; ?>
    </div>
  <?php endif; ?>
  <?php if (!empty($link)) {  ?>
    <div class="card-absolute__ctas hong-kong-card__ctas">
      <a href="<?php echo the_permalink(); ?>" class="button button__outline" aria-label="Read <?php echo $name; ?> review">Review</a>
      <a href="<?php echo esc_url($link); ?>" class="button button__primary" target="_blank" rel="sponsored noopener" aria-label="Goto <?php echo $name; ?>">Play</a>
    </div>
  <?php }; ?>
</div>