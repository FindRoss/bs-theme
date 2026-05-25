<?php 
  $bid = get_the_ID();

  // Bonus Fields
  $bonus_title = get_field('bonus_title', $bid);
  $bonus       = get_field('bonus', $bid);
  $bonus_plus  = get_field('bonus_plus', $bid);
  $title       = get_the_title($bid);
  $code        = get_field('code', $bid);
  $blockLink   = get_field('bonus_link', $bid);


  $siteArr    = get_field('single_bonus_casino', $bid);
  $site       = $siteArr[0];  
  
  $permalink  = get_permalink($bid);
  $postStatus = get_post_status($bid);
  
  // Review Fields
  $details_group = get_field('details_group', $site);
  $name          = $details_group['name']; 
  $link          = $details_group['affiliate_link'];  
  $media_group   = get_field('media_group', $site);
  $color         = $media_group['theme_color'];

  $bonusLink = $link;
  if ($blockLink) $bonusLink = $blockLink;  
?>

<div class="bonus-pill-wrapper">
  <div class="card card-absolute bonus-pill">

    <!-- aria -->
    <a class="card-absolute__link" href="<?php echo esc_url($permalink); ?>" aria-label="<?php echo esc_attr($title); ?>"></a>

    <div class="bonus-pill__content">
      <img class="logo" src="<?php echo get_the_post_thumbnail_url($site, 'site-small-logo'); ?>" alt="<?php echo $name . ' logo'; ?>" width="100" height="50" title="<?php echo $name; ?>"/>
      <h3>
        <?php if ($bonus_title) { ?><div class="title"><?php echo $bonus_title; ?></div><?php } ?>
        <?php if ($bonus)       { ?><div class="bonus"><?php echo $bonus; ?></div><?php } ?>
        <?php if ($bonus_plus)  { ?><div class="subtitle"><?php echo $bonus_plus; ?></div><?php } ?>
      </h3>
    </div>

    <div class="card-absolute__ctas bonus-pill__cta">
      <?php if ($code) { ?>
        <button class="bonus-pill__code bonus-code" type="button" aria-label="Copy bonus code to clipboard">
          <span class="bonus-code__code"><?php echo esc_html($code); ?></span>
          <span class="bonus-code__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
            </svg>
          </span>
        </button>
      <?php } ?>
      <a class="button button__primary" href="<?php echo esc_url($bonusLink); ?>" target="_blank" rel="sponsored noopener" aria-label="Visit <?php echo esc_attr($name); ?>">
        <i data-feather="external-link"></i>
      </a>
    </div>
  </div>
</div>