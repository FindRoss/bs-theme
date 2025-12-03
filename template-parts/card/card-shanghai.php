<?php 
  $bonus_id = $args['id'] ?? get_the_ID();
  if (!$bonus_id) return;

  $title       = get_field('bonus_title', $bonus_id);
  $bonus       = get_field('bonus', $bonus_id);
  $plus        = get_field('bonus_plus', $bonus_id);
  $code        = get_field('code', $bonus_id);
  $bonusLink   = get_field('bonus_link', $bonus_id);
  $exclusive   = get_field('exclusive', $bonus_id);
  
  $site        = get_field('single_bonus_casino', $bonus_id)[0] ?? null;
  if (!$site) return;
  
  $expiry_date = get_field('expiry_date', $bonus_id);
  $expiry_timestamp = $expiry_date ? strtotime($expiry_date) * 1000 : 'Expired';
  $marked_expired = get_field('bonus_expired', $bonus_id); 
  
  $detailsGroup = get_field('details_group', $site);
  $siteName = $detailsGroup['name'];
  $siteLink = $detailsGroup['affiliate_link'];
  
  $outputLink = $bonusLink ? $bonusLink : $siteLink;
  ?>


  <div class="card card-absolute card-shanghai">

    <a class="card-absolute__link" href="<?php the_permalink($bonus_id); ?>" aria-label="Read <?php echo $name; ?> review"></a>
    
    <div class="card-shanghai__media">
      <span class="img-wrapper"><img src="<?php echo get_the_post_thumbnail_url($site, 'site-small-logo'); ?>" width="34" height="17" alt="<?php echo $siteName . ' logo'; ?>" aria-hidden="true"></span>

      <?php if ($expiry_date || $exclusive || $marked_expired) { ?>
        <div class="card-shanghai-pills">      
          
          <?php if ($expiry_date || $marked_expired) : ?>
          <span class="info-pill info-pill-expiry timer" data-expiry="<?php echo $expiry_timestamp; ?>">
            <?php echo get_svg_icon('stopwatch'); ?>
            <span class="ends-in-text"></span>
          </span>
          <?php endif; ?>
          
          <?php if ($exclusive) : ?>
            <span class="info-pill exclusive">
              <?php echo get_svg_icon('star'); ?>
              <span>Exclusive</span>
            </span>
          <?php endif; ?>
          
        </div>
      <?php }; ?>
    </div>

    <div class="card-shanghai__content">
      <h3>        
        <?php if ($title) { ?><div class="title"><?php echo $title; ?></div><?php }; ?>
        <?php if ($bonus) { ?><div class="bonus"><?php echo $bonus; ?></div><?php }; ?>
        <?php if ($plus) { ?><div class="subtitle"><?php echo $plus; ?></div><?php }; ?>
      </h3>
    </div>
      
    <div class="card-absolute__ctas card-shanghai__ctas">
       
      <?php if ($code) { ?>
        <a class="button button--small button__outline bonus-code" type="button" aria-label="Copy bonus code to clipboard">
          <span class="bonus-code__code"><?php echo $code; ?></span>
          <span class="bonus-code__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
            </svg>
          </span>
        </a>
      <?php }; ?>

      <a href="<?php echo $outputLink; ?>" class="button button--small button__primary" target="_blank" aria-label="Claim bonus at <?php echo $name; ?>">Get Bonus</a>

    </div>
  </div>



