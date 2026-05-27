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
  
  $detailsGroup = get_field('details_group', $site);
  $siteName = $detailsGroup['name'];
  $siteLink = $detailsGroup['affiliate_link'];

  $mediaGroup = get_field('media_group', $site);
  $siteColor  = $mediaGroup['theme_color'] ?? '#f0f0f0';

  $outputLink = $bonusLink ? $bonusLink : $siteLink;

  // Derive category from bonus_type taxonomy for the title tag
  $bonus_types  = get_the_terms($bonus_id, 'bonus_type');
  $category_map = [
    'no-deposit' => 'nodeposit',
    'free-spins' => 'nodeposit',
    'exclusive'  => 'exclusive',
    'reload'     => 'reload',
    'cashback'   => 'cashback',
    'rakeback'   => 'cashback',
  ];
  $category = 'default';
  if ($bonus_types && !is_wp_error($bonus_types)) {
    $category = $category_map[$bonus_types[0]->slug] ?? 'default';
  }
  $tag_label = $title ?: ($bonus_types && !is_wp_error($bonus_types) ? $bonus_types[0]->name : '');
  ?>


  <div class="card card-shanghai">

    <div class="card-shanghai__body">

      <a href="<?php echo esc_url($outputLink); ?>" target="_blank" rel="sponsored noopener" aria-label="Visit <?php echo esc_attr($siteName); ?>">
        <div class="card-shanghai__logo" style="background-color: <?php echo esc_attr($siteColor); ?>">
          <img src="<?php echo get_the_post_thumbnail_url($site, 'site-small-logo'); ?>" alt="<?php echo esc_attr($siteName . ' logo'); ?>" aria-hidden="true">
        </div>
      </a>

      <a href="<?php echo esc_url(get_permalink($bonus_id)); ?>" class="card-shanghai__content">
        <h3>
          <?php if ($tag_label) { ?><span class="bonus-pill__tag bonus-pill__tag--<?php echo esc_attr($category); ?>"><?php echo esc_html($tag_label); ?></span><?php } ?>
          <?php if ($bonus) { ?><div class="bonus"><?php echo $bonus; ?></div><?php } ?>
          <?php if ($plus)  { ?><div class="subtitle"><?php echo $plus; ?></div><?php } ?>
        </h3>

        <?php if ($exclusive) { ?>
          <div class="card-shanghai__pills">
            <span class="info-pill exclusive">
              <i data-feather="award"></i>
              <span>Exclusive</span>
            </span>
          </div>
        <?php } ?>
      </a>

    </div>

    <div class="card-shanghai__ctas">
       
      <?php if ($code) { ?>
        <button class="button button--small button__outline bonus-code" type="button" aria-label="Copy bonus code to clipboard">
          <span class="bonus-code__code"><?php echo $code; ?></span>
          <span class="bonus-code__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
            </svg>
          </span>
        </button>
      <?php }; ?>

      <a href="<?php echo esc_url($outputLink); ?>" class="button button--small button__primary" target="_blank" rel="sponsored noopener" aria-label="Claim bonus at <?php echo esc_attr($siteName); ?>">Claim Bonus</a>

    </div>
  </div>



