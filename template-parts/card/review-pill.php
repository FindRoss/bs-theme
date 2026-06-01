<?php
$id          = get_the_ID();
$details     = get_field('details_group', $id);
$name        = $details['name'] ?? get_the_title();
$aff_link    = $args['aff_link'] ?: ($details['affiliate_link'] ?? '');
$review_link = get_the_permalink($id);
$logo_url    = get_the_post_thumbnail_url($id, 'site-small-logo');
$rank        = $args['rank'] ?? null;
$is_top      = $args['is_top'] ?? false;
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
  <span class="review-pill__actions">
    <a class="button button__outline" href="<?php echo esc_url($review_link); ?>">Review</a>
    <?php if ($aff_link) : ?>
      <a class="button button__primary" href="<?php echo esc_url($aff_link); ?>" target="_blank" rel="sponsored noopener">Visit</a>
    <?php else : ?>
      <span class="button button__primary" aria-hidden="true">Visit</span>
    <?php endif; ?>
  </span>
</div>
