<?php
$review_id = $args['review_id'] ?? get_the_ID();

$categories = [
  'fairness'         => ['label' => 'Transparency & Fairness'],
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
    $comments = get_field("trust_index_{$key}_comments", $review_id);

    if (!$score && !$comments) continue;
  ?>
    <div class="trust-index-section">
      <div class="trust-index-section__header">
        <h4 class="trust-index-section__label"><?php echo esc_html($cat['label']); ?></h4>
        <span class="trust-index-section__score"><?php echo esc_html($score); ?></span>
      </div>
      <?php if ($comments) : ?>
        <div class="trust-index-section__comments">
          <?php echo wp_kses_post($comments); ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>
