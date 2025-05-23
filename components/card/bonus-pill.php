<?php 
  $bid = get_the_ID();

  // Bonus Fields
  $bonus      = get_field('bonus', $bid);
  $title      = get_the_title($bid);
  $code       = get_field('code', $bid);
  $blockLink  = get_field('bonus_link', $bid);

  $truncate_title = truncate_text($title, 55);


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
  <div class="bonus-pill sort-focus"> 

    <div class="bonus-pill__content">
      <img class="logo me-2" src="<?php echo get_the_post_thumbnail_url($site, 'site-small-logo'); ?>" alt="<?php echo $name . ' logo'; ?>" width="100" height="50" title="<?php echo $name; ?>"/>
      <h3 class="h6 m-0"><a href="<?php echo $permalink; ?>"><?php echo $truncate_title; ?></a></h2>
    </div>

    <div class="bonus-pill__cta">
      <a class="button button__primary" href="<?php echo $bonusLink; ?>" target="_blank" rel="nofollow" aria-label="Visit <?php echo $name; ?>">
       <?php echo get_svg_icon('external-link'); ?>
      </a>
    </div>
  </div>

  <?php if ($code) { ?>
    <div class="bonus-pill--bonus-code bonus-code">
        <span class="bonus-code__label me-1">Bonus code: </span>
        <span class="bonus-code__code"><?php echo $code; ?></span>
        <span class="bonus-code__icon ms-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
          </svg>
        </span>
    </div>
  <?php }; ?>
</div>





