<?php
$review_id = $args['review_id'] ?? get_the_ID();

$categories = [
  'fairness'         => ['label' => 'Transparency'],
  'track_record'     => ['label' => 'Track Record'],
  'security'         => ['label' => 'Account Security'],
  'responsible'      => ['label' => 'Responsible Gambling'],
  'community'        => ['label' => 'Community'],
  'customer_service' => ['label' => 'Customer Service'],
];

?>

<div class="review-trust-index-details">
  <?php foreach ($categories as $key => $cat) :
    $score = (int) get_field("trust_index_{$key}", $review_id);
    $points = get_field("trust_index_{$key}_points", $review_id);

    if (!$score && !$points) continue;
  ?>
    <div class="trust-index-section">
      <div class="trust-index-section__header">
        <h4 class="trust-index-section__label"><?php echo esc_html($cat['label']); ?></h4>
        <span class="trust-index-section__score"><?php echo esc_html($score); ?><span class="trust-index-section__score-max">/5</span></span>
      </div>
      <?php if ($points) : ?>
        <ul class="trust-index-section__points">
          <?php foreach ($points as $row) :
            if (empty($row['point'])) continue;
            $is_positive = !empty($row['position_negative']);
          ?>
            <li class="trust-index-section__point trust-index-section__point--<?php echo $is_positive ? 'positive' : 'negative'; ?>">
              <?php echo esc_html($row['point']); ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>
