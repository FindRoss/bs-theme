<?php
$id          = get_the_ID();
$details     = get_field('details_group', $id);
$name        = $details['name'] ?? get_the_title();
$aff_link    = ($args['aff_link'] ?? '') ?: ($details['affiliate_link'] ?? '');
$review_link = get_the_permalink($id);
$logo_url    = get_the_post_thumbnail_url($id, 'site-small-logo');
$rank        = $args['rank'] ?? null;
$is_top      = $args['is_top'] ?? false;
$show_bonus  = $args['show_bonus'] ?? false;
$bonus_group = $show_bonus ? get_field('bonus_group', $id) : null;
$bonus_text  = $bonus_group['bonus'] ?? '';
$pill_class  = 'review-pill'
  . ($rank !== null ? ' review-pill--ranked' : '')
  . ($is_top ? ' review-pill--top' : '');
?>

<div class="<?php echo esc_attr($pill_class); ?>">
  <?php if ($rank !== null) : ?>
    <span class="review-pill__num"><?php echo (int) $rank; ?></span>
  <?php endif; ?>
  <a class="review-pill__logo" href="<?php echo esc_url($review_link); ?>">
    <?php if ($logo_url) : ?>
      <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($name . ' logo'); ?>" width="96" height="44">
    <?php endif; ?>
  </a>
  <?php if ($bonus_text) : ?>
  <span class="review-pill__offer">
    <span class="review-pill__offer-icon"><?php echo get_svg_icon('present'); ?></span>
    <span class="review-pill__offer-text"><?php echo esc_html($bonus_text); ?></span>
  </span>
  <?php endif; ?>
  <span class="review-pill__actions">
    <a class="button button--small button__outline" href="<?php echo esc_url($review_link); ?>">Review</a>
    <?php if ($aff_link) : ?>
      <a class="button button--small button__primary" href="<?php echo esc_url($aff_link); ?>" target="_blank" rel="sponsored noopener">Visit</a>
    <?php else : ?>
      <span class="button button--small button__primary" aria-hidden="true">Visit</span>
    <?php endif; ?>
  </span>
</div>
