<?php
  $review_id = get_the_ID();
  $exclude_lazyload = $args['exclude_lazyload'] ?? false;
  $is_top           = $args['is_top'] ?? false;

  $details_group = get_field('details_group');
  $name          = $details_group['name'];
  $link          = $details_group['affiliate_link'];

  $bonus_group  = get_field('bonus_group');
  $bonus        = $bonus_group['bonus'] ?? null;
  $bonus_code   = $bonus_group['bonus_code'] ?? null;

  $mediaGroup = get_field('media_group');
  $siteColor  = $mediaGroup['theme_color'];

  $crypto_terms  = get_the_terms($review_id, 'cryptocurrency');
  $crypto_output = display_review_crypto($crypto_terms);

  $pros = $review_id ? get_field('pros', $review_id) : [];
?>

<div class="card card-kunming<?php echo $is_top ? ' card-kunming--top' : ''; ?>">

  <div class="card-kunming__main">

    <div class="card-kunming__media">
      <?php if ($link) : ?>
      <a href="<?php echo esc_url($link); ?>" target="_blank" rel="sponsored noopener" aria-label="Visit <?php echo esc_attr($name); ?>">
      <?php endif; ?>
        <div class="km-card-bg-color" style="background-color: <?php echo esc_attr($siteColor); ?>">
          <img
            src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'site-small-logo')); ?>"
            width="90" height="52"
            alt="<?php echo esc_attr($name . ' logo'); ?>"
            <?php echo $exclude_lazyload ? 'class="exclude-lazyload"' : ''; ?>
          >
        </div>
      <?php if ($link) : ?>
      </a>
      <?php endif; ?>
    </div>

    <div class="card-kunming__bonus">
      <h3><?php echo esc_html($name); ?></h3>
      <?php if ($bonus) : ?>
        <div class="card-kunming__bonus-pill">
          <span class="card-kunming__bonus-icon"><i data-feather="gift"></i></span>
          <div><span><?php echo esc_html($bonus); ?></span></div>
        </div>
      <?php endif; ?>
    </div>

    <div class="card-kunming__pros-cons">
      <?php if (!empty($pros)) : ?>
        <span class="card-kunming__section-label">Highlights</span>
        <ul class="card-kunming__pros">
          <?php foreach ($pros as $pro) : ?>
            <li><?php echo esc_html($pro['item']); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>

    <div class="card-kunming__crypto">
      <?php if (!empty($crypto_output)) : ?>
        <div class="crypto-icons"><?php echo $crypto_output; ?></div>
      <?php endif; ?>
    </div>

    <div class="card-kunming__ctas">
      <a href="<?php the_permalink(); ?>" class="button button__outline" aria-label="Read <?php echo esc_attr($name); ?> review">Review</a>
      <?php if ($link) : ?>
        <a href="<?php echo esc_url($link); ?>" class="button button__primary" target="_blank" rel="sponsored noopener" aria-label="Go to <?php echo esc_attr($name); ?>">Play Now</a>
      <?php endif; ?>
    </div>

  </div>

  <?php
  ob_start();
  get_template_part('template-parts/review/review-info-boxes', null, [
    'review_id' => $review_id,
    'size'      => 'small',
  ]);
  $info_boxes_html = ob_get_clean();
  $has_boxes = !empty(trim($info_boxes_html));

  if ($has_boxes || $bonus_code) : ?>
  <div class="card-kunming__info-boxes">

    <div class="card-kunming__info-boxes-header">
      <?php if ($has_boxes) : ?>
        <button class="card-kunming__details-toggle" aria-expanded="false" aria-label="Toggle details">
          Details
          <span class="toggle-icon"><?php echo get_svg_icon('chevron-down'); ?></span>
        </button>
      <?php else : ?>
        <span></span>
      <?php endif; ?>

      <?php if ($bonus_code) : ?>
        <button class="bonus-code bonus-code--bar" type="button" aria-label="Copy bonus code to clipboard">
          <span class="bonus-code__label">Bonus code</span>
          <span class="bonus-code__code"><?php echo esc_html($bonus_code); ?></span>
          <span class="bonus-code__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
            </svg>
          </span>
          <span class="sr-only" aria-live="polite"></span>
        </button>
      <?php endif; ?>
    </div>

    <?php if ($has_boxes) : ?>
      <div class="card-kunming__details-content">
        <?php echo $info_boxes_html; ?>
      </div>
    <?php endif; ?>

  </div>
  <?php endif; ?>

</div>
