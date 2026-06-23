<?php
$id = $args['review_id'] ?? null;

if (!$id) return;

$details_group = get_field('details_group', $id);
if (!$details_group) return;

$closed    = $details_group['closed'];
if ($closed) return;

$goto_link = $details_group['affiliate_link'];
$name      = $details_group['name'];

if ($goto_link !== null) : ?>
  <div class="review-cta">
    <div class="review-cta__ctas">
      <a class="button button__outline" href="<?php echo get_the_permalink($id); ?>"><?php echo $name; ?> review</a>
      <a class="button button__primary" rel="sponsored noopener" href="<?php echo esc_url($goto_link); ?>" target="_blank">Goto <?php echo $name; ?></a>
    </div>
  </div>
<?php endif; ?>
