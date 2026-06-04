<?php
  $review_id = get_the_ID();
  $exclude_lazyload = $args['exclude_lazyload'] ?? false;
  $is_top           = $args['is_top'] ?? false;

  $details_group = get_field('details_group');
  $name          = $details_group['name'];
  $link          = $details_group['affiliate_link'];

  $bonus_group  = get_field('bonus_group');
  $bonus_title  = $bonus_group['bonus_title'] ?? null;
  $bonus        = $bonus_group['bonus'] ?? null;
  $bonus_plus   = $bonus_group['bonus_plus'] ?? null;

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
  if (!empty(trim($info_boxes_html))) : ?>
  <div class="card-kunming__info-boxes">
    <button class="card-kunming__details-toggle" aria-expanded="false" aria-label="Toggle details">
      Details
      <span class="toggle-icon"><?php echo get_svg_icon('chevron-down'); ?></span>
    </button>
    <div class="card-kunming__details-content">
      <?php echo $info_boxes_html; ?>
    </div>
  </div>
  <?php endif; ?>

</div>
