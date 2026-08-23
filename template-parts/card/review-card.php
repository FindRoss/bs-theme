<?php
$id          = get_the_ID();
$details     = get_field('details_group', $id);
$name        = $details['name'] ?? get_the_title();
$aff_link    = ($args['aff_link'] ?? '') ?: ($details['affiliate_link'] ?? '');
$review_link = get_the_permalink($id);
$logo_url    = get_the_post_thumbnail_url($id, 'site-small-logo');
$bonus_group = get_field('bonus_group', $id);
$bonus_text  = $bonus_group['bonus'] ?? '';
$media_group = get_field('media_group', $id);
$theme_color = $media_group['theme_color'] ?? '';
?>

<div class="review-card">
  <div class="review-card__media" style="background-color: <?php echo esc_attr($theme_color); ?>">
    <a href="<?php echo esc_url($review_link); ?>">
      <?php if ($logo_url) : ?>
        <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($name . ' logo'); ?>" width="200" height="100">
      <?php endif; ?>
    </a>
  </div>
  <div class="review-card__body">
    <h3 class="review-card__name"><a href="<?php echo esc_url($review_link); ?>"><?php echo esc_html($name); ?></a></h3>
    <?php if ($bonus_text) : ?>
      <span class="review-card__bonus">
        <span class="review-card__bonus-icon"><?php echo get_svg_icon('present'); ?></span>
        <span class="review-card__bonus-text"><?php echo esc_html($bonus_text); ?></span>
      </span>
    <?php endif; ?>
  </div>
  <div class="review-card__ctas">
    <a class="button button__outline" href="<?php echo esc_url($review_link); ?>">Review</a>
    <?php if ($aff_link) : ?>
      <a class="button button__primary" href="<?php echo esc_url($aff_link); ?>" target="_blank" rel="sponsored noopener">Visit</a>
    <?php else : ?>
      <span class="button button__primary" aria-hidden="true">Visit</span>
    <?php endif; ?>
  </div>
</div>
