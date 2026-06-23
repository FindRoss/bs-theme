<?php
$review_id = $args['review_id'] ?? null;

if (!$review_id) return;

$pros = get_field('pros', $review_id);
$cons = get_field('cons', $review_id);

if (!$pros && !$cons) return;
?>

<div class="pros-cons">

  <?php if ($pros) : ?>
    <ul class="pros-cons__list pros-cons__list--pros">
      <?php foreach ($pros as $row) : ?>
        <?php if (!empty($row['item'])) : ?>
          <li><i data-feather="check-circle"></i> <span class="text"><?php echo esc_html($row['item']); ?></span></li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ($cons) : ?>
    <ul class="pros-cons__list pros-cons__list--cons">
      <?php foreach ($cons as $row) : ?>
        <?php if (!empty($row['item'])) : ?>
          <li><i data-feather="x-circle"></i> <span class="text"><?php echo esc_html($row['item']); ?></span></li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

</div>
