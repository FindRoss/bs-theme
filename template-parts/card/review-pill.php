<?php
$id          = get_the_ID();
$details     = get_field('details_group', $id);
$name        = $details['name'] ?? get_the_title();
$aff_link    = $details['affiliate_link'] ?? '';
$bonus_group = get_field('bonus_group', $id);
$bonus_text  = $bonus_group['bonus'] ?? '';
$review_link = get_the_permalink($id);
$logo_url    = get_the_post_thumbnail_url($id, 'site-small-logo');
$rank        = $args['rank'] ?? null;
$is_top      = $args['is_top'] ?? false;
$pill_class  = 'review-pill'
  . ($rank !== null ? ' review-pill--ranked' : '')
  . ($is_top ? ' review-pill--top' : '');
?>

<div class="<?php echo esc_attr($pill_class); ?>">
  <a class="review-pill__link" href="<?php echo esc_url($review_link); ?>" aria-label="Read <?php echo esc_attr($name); ?> review"></a>
  <?php if ($rank !== null) : ?>
    <span class="review-pill__num"><?php echo (int) $rank; ?></span>
  <?php endif; ?>
  <span class="review-pill__logo">
    <?php if ($logo_url) : ?>
      <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($name . ' logo'); ?>" width="96" height="44">
    <?php endif; ?>
  </span>
  <?php if ($bonus_text) : ?>
  <span class="review-pill__offer">
    <span class="review-pill__offer-icon"><i data-feather="gift" aria-hidden="true"></i></span>
    <span class="review-pill__offer-text"><?php echo esc_html($bonus_text); ?></span>
  </span>
  <?php endif; ?>
  <span class="review-pill__visit">
    <?php if ($aff_link) : ?>
      <a href="<?php echo esc_url($aff_link); ?>" target="_blank" rel="sponsored noopener" aria-label="Visit <?php echo esc_attr($name); ?>">
        <i data-feather="external-link"></i>
      </a>
    <?php else : ?>
      <span aria-hidden="true"><i data-feather="external-link"></i></span>
    <?php endif; ?>
  </span>
</div>
