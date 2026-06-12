<?php
  $bid = get_the_ID();

  // Bonus Fields
  $bonus_title = get_field('bonus_title', $bid);
  $bonus       = get_field('bonus', $bid);
  $code        = get_field('code', $bid);
  $permalink   = get_permalink($bid);

  $siteArr = get_field('single_bonus_casino', $bid);
  $site    = $siteArr[0];

  // Review Fields
  $details_group = get_field('details_group', $site);
  $name          = $details_group['name'];
  $logo_url      = get_the_post_thumbnail_url($site, 'site-small-logo');

  // Args
  $is_top = $args['is_top'] ?? false;

  // Tag label: ACF bonus_title > taxonomy term name
  $bonus_types = get_the_terms($bid, 'bonus_type');
  $tag_label   = $bonus_title ?: ($bonus_types && !is_wp_error($bonus_types) ? $bonus_types[0]->name : '');

  $pill_class = 'nav-bonus-pill' . ($is_top ? ' nav-bonus-pill--top' : '');
?>

<a class="<?php echo esc_attr($pill_class); ?>"
   href="<?php echo esc_url($permalink); ?>"
   aria-label="<?php echo esc_attr($name . ($bonus ? ' — ' . $bonus : '')); ?>">

  <span class="nav-bonus-pill__logo">
    <?php if ($logo_url) : ?>
      <img src="<?php echo esc_url($logo_url); ?>"
           alt="<?php echo esc_attr($name . ' logo'); ?>"
           width="96" height="44">
    <?php endif; ?>
  </span>

  <div class="nav-bonus-pill__copy">
    <?php if ($tag_label) : ?>
      <span class="nav-bonus-pill__tag">
        <?php echo esc_html($tag_label); ?>
      </span>
    <?php endif; ?>
    <?php if ($bonus) : ?>
      <span class="nav-bonus-pill__amount"><?php echo esc_html($bonus); ?></span>
    <?php endif; ?>
  </div>

  <?php if ($code) : ?>
    <span class="nav-bonus-pill__code bonus-code">
      <span class="bonus-code__code"><?php echo esc_html($code); ?></span>
    </span>
  <?php endif; ?>
</a>
