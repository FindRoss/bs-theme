<?php
  $bonus_id = $args['id'] ?? get_the_ID();
  if (!$bonus_id) return;

  $title     = get_field('bonus_title', $bonus_id);
  $bonus     = get_field('bonus', $bonus_id);
  $plus      = get_field('bonus_plus', $bonus_id);
  $code      = get_field('code', $bonus_id);
  $bonusLink = get_field('bonus_link', $bonus_id);

  $site = get_field('single_bonus_casino', $bonus_id)[0] ?? null;
  if (!$site) return;

  $detailsGroup = get_field('details_group', $site);
  $siteName     = $detailsGroup['name'];
  $siteLink     = $detailsGroup['affiliate_link'];
  $outputLink   = $bonusLink ?: $siteLink;

  $mediaGroup = get_field('media_group', $site);
  $siteColor  = $mediaGroup['theme_color'] ?? '#ffffff';

  $exclusive = get_field('exclusive', $bonus_id);
?>

<div class="card card-suzhou">

  <div class="card-suzhou__main">

  <div class="card-suzhou__media">
    <?php if ($outputLink) : ?>
    <a href="<?php echo esc_url($outputLink); ?>" target="_blank" rel="sponsored noopener" aria-label="Visit <?php echo esc_attr($siteName); ?>">
    <?php endif; ?>
      <div class="sz-card-bg-color" style="background-color: <?php echo esc_attr($siteColor); ?>">
        <img
          src="<?php echo esc_url(get_the_post_thumbnail_url($site, 'site-small-logo')); ?>"
          width="90" height="52"
          alt="<?php echo esc_attr($siteName . ' logo'); ?>"
        >
      </div>
    <?php if ($outputLink) : ?>
    </a>
    <?php endif; ?>
  </div>

  <div class="card-suzhou__site">
    <h3><?php echo esc_html($siteName); ?></h3>
    <?php if ($exclusive) : ?>
      <span class="card-suzhou__exclusive-pill">
        <i data-feather="star"></i>
        Exclusive
      </span>
    <?php endif; ?>
  </div>

  <div class="card-suzhou__bonus-info">
    <?php if ($title) : ?>
      <div class="card-suzhou__bonus-title"><?php echo esc_html($title); ?></div>
    <?php endif; ?>
    <?php if ($bonus) : ?>
      <div class="card-suzhou__bonus-amount"><?php echo esc_html($bonus); ?></div>
    <?php endif; ?>
    <?php if ($plus) : ?>
      <div class="card-suzhou__bonus-plus"><?php echo esc_html($plus); ?></div>
    <?php endif; ?>
  </div>

  <?php if ($code) : ?>
  <div class="card-suzhou__code">
    <button class="bonus-code" type="button" aria-label="Copy bonus code to clipboard">
      <span class="bonus-code__label">Code</span>
      <span class="bonus-code__code"><?php echo esc_html($code); ?></span>
      <span class="bonus-code__icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
        </svg>
      </span>
    </button>
  </div>
  <?php endif; ?>

  <div class="card-suzhou__ctas">
    <a href="<?php echo esc_url(get_permalink($bonus_id)); ?>" class="button button__outline" aria-label="View <?php echo esc_attr($siteName); ?> bonus">View Bonus</a>
    <?php if ($outputLink) : ?>
      <a href="<?php echo esc_url($outputLink); ?>" class="button button__primary" target="_blank" rel="sponsored noopener" aria-label="Claim bonus at <?php echo esc_attr($siteName); ?>">Get Bonus</a>
    <?php endif; ?>
  </div>

  </div><!-- .card-suzhou__main -->

  <?php
  ob_start();
  get_template_part('template-parts/bonus/bonus-info-boxes', null, ['bonus_id' => $bonus_id]);
  $info_boxes_html = ob_get_clean();
  if (!empty(trim($info_boxes_html))) : ?>
  <div class="card-suzhou__info-boxes">
    <button class="card-suzhou__details-toggle" aria-expanded="false" aria-label="Toggle bonus details">
      Details
      <span class="toggle-icon"><?php echo get_svg_icon('chevron-down'); ?></span>
    </button>
    <div class="card-suzhou__details-content">
      <?php echo $info_boxes_html; ?>
    </div>
  </div>
  <?php endif; ?>

</div>
