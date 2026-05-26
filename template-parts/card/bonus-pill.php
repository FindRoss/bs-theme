<?php
  $bid = get_the_ID();

  // Bonus Fields
  $bonus_title = get_field('bonus_title', $bid);
  $bonus       = get_field('bonus', $bid);
  $code        = get_field('code', $bid);
  $blockLink   = get_field('bonus_link', $bid);
  $permalink   = get_permalink($bid);

  $siteArr = get_field('single_bonus_casino', $bid);
  $site    = $siteArr[0];

  // Review Fields
  $details_group = get_field('details_group', $site);
  $name          = $details_group['name'];
  $link          = $details_group['affiliate_link'];
  $logo_url      = get_the_post_thumbnail_url($site, 'site-small-logo');

  $bonusLink = $link;
  if ($blockLink) $bonusLink = $blockLink;

  // Args
  $is_top = $args['is_top'] ?? false;

  // Derive category from bonus_type taxonomy for tag colouring
  $bonus_types  = get_the_terms($bid, 'bonus_type');
  $category     = 'default';
  $category_map = [
    'no-deposit' => 'nodeposit',
    'free-spins' => 'nodeposit',
    'exclusive'  => 'exclusive',
    'reload'     => 'reload',
    'cashback'   => 'cashback',
    'rakeback'   => 'cashback',
  ];
  if ($bonus_types && !is_wp_error($bonus_types)) {
    $category = $category_map[$bonus_types[0]->slug] ?? 'default';
  }

  // Tag label: ACF bonus_title > taxonomy term name
  $tag_label = $bonus_title ?: ($bonus_types && !is_wp_error($bonus_types) ? $bonus_types[0]->name : '');

  $pill_class = 'bonus-pill' . ($is_top ? ' bonus-pill--top' : '');
?>

<div class="<?php echo esc_attr($pill_class); ?>">
  <a class="bonus-pill__link"
     href="<?php echo esc_url($permalink); ?>"
     aria-label="<?php echo esc_attr($name . ($bonus ? ' — ' . $bonus : '')); ?>"></a>

  <span class="bonus-pill__logo">
    <?php if ($logo_url) : ?>
      <img src="<?php echo esc_url($logo_url); ?>"
           alt="<?php echo esc_attr($name . ' logo'); ?>"
           width="96" height="44">
    <?php endif; ?>
  </span>

  <div class="bonus-pill__copy">
    <?php if ($tag_label) : ?>
      <span class="bonus-pill__tag bonus-pill__tag--<?php echo esc_attr($category); ?>">
        <?php echo esc_html($tag_label); ?>
      </span>
    <?php endif; ?>
    <?php if ($bonus) : ?>
      <span class="bonus-pill__amount"><?php echo esc_html($bonus); ?></span>
    <?php endif; ?>
  </div>

  <?php if ($code) : ?>
    <button class="bonus-pill__code bonus-code" type="button"
            aria-label="Copy code <?php echo esc_attr($code); ?>">
      <span class="bonus-code__code"><?php echo esc_html($code); ?></span>
      <span class="bonus-code__icon" aria-hidden="true">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
          <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
        </svg>
      </span>
      <span class="sr-only" aria-live="polite"></span>
    </button>
  <?php else : ?>
    <span class="bonus-pill__code-none" aria-hidden="true">—</span>
  <?php endif; ?>

  <span class="bonus-pill__visit">
    <?php if ($bonusLink) : ?>
      <a href="<?php echo esc_url($bonusLink); ?>"
         target="_blank"
         rel="sponsored noopener"
         aria-label="Visit <?php echo esc_attr($name); ?>"
         tabindex="-1">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
          <polyline points="15 3 21 3 21 9"></polyline>
          <line x1="10" y1="14" x2="21" y2="3"></line>
        </svg>
      </a>
    <?php else : ?>
      <span aria-hidden="true">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
          <polyline points="15 3 21 3 21 9"></polyline>
          <line x1="10" y1="14" x2="21" y2="3"></line>
        </svg>
      </span>
    <?php endif; ?>
  </span>
</div>
