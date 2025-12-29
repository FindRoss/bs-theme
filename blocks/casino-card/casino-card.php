<?php
// Load values and assign defaults.
$review_id   = get_field('casino'); 
$options     = get_field('options') ?? '';
$description = get_field('description') ?? ''; 
$unique_link = get_field('casino_card_link') ?? '';

// Review fields
$details_group = get_field('details_group', $review_id) ?? [];
$name          = $details_group['name'] ?? '';
$link          = $details_group['affiliate_link'] ?? '';
$bonus         = $details_group['bonus'] ?? '';
$image         = get_the_post_thumbnail_url($review_id, 'small-site-logo');

$permalink   = get_permalink($review_id);
$media_group = get_field('media_group', $review_id) ?? [];
$theme_color = $media_group['theme_color'] ?? '';

// Determine button text
$btn_output = "Play Now";
if ($options === "Excerpt") $btn_output = "Play";
elseif ($options === "Bonus") $btn_output = "Claim";
elseif ($options === "Description") $btn_output = "Play";

?>

<div class="casino-card">

    <?php if ($image) : ?>
      <div class="casino-card__media" style="background-color: <?php echo esc_attr($theme_color); ?>">
        <a href="<?php echo esc_url($permalink); ?>">
          <img class="mt-0" width="100" height="auto" alt="<?php echo esc_attr($name); ?>" src="<?php echo esc_url($image); ?>">
        </a>
      </div>
    <?php endif; ?>

    <div class="casino-card__content">
        <?php if ($options === "Excerpt") : ?>
          <p><?php echo get_the_excerpt($review_id); ?></p>
        <?php elseif ($options === "Bonus") : ?>
          <div class="fs-small font-bold text-muted text-uppercase ff-main">Bonus</div>
          <div class="casino-card__content-bonus"><?php echo esc_html($bonus); ?></div>
        <?php elseif ($options === "Description") : ?>
          <p><?php echo esc_html($description); ?></p>
        <?php endif; ?>
    </div>

    <?php if ($link) : ?>
      <div class="casino-card__cta">
        <a class="button button__primary" rel="nofollow" href="<?php echo esc_url($unique_link ?: $link); ?>" target="_blank"><?php echo esc_html($btn_output); ?></a>
      </div>
    <?php endif; ?>

</div><!-- .casino-card -->
