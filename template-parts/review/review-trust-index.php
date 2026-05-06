<?php
$review_id = $args['review_id'] ?? get_the_ID();

$scores = [
  'Ownership'   => (int) get_field('trust_index_ownership',   $review_id),
  'License'     => (int) get_field('trust_index_license',     $review_id),
  'Terms'       => (int) get_field('trust_index_terms',       $review_id),
  'Support'     => (int) get_field('trust_index_support',     $review_id),
  'Social'      => (int) get_field('trust_index_social',      $review_id),
  'Responsible' => (int) get_field('trust_index_responsible', $review_id),
];

$total    = array_sum($scores);
$comments = get_field('trust_index_comments', $review_id);

if ($total <= 0) return;

$circumference = 263.89;
$offset        = round($circumference * (1 - $total / 60), 2);

$modifier = 'low';
if ($total >= 48)      $modifier = 'high';
elseif ($total >= 36)  $modifier = 'mid';
?>

<div class="review-trust-index review-trust-index--<?php echo esc_attr($modifier); ?>">

  <div class="review-trust-index__scores">

    <div class="review-trust-index__circle-wrap">
      <span class="review-trust-index__circle-label">Trust Index</span>
      <div class="review-trust-index__circle-container">
        <svg class="review-trust-index__svg" viewBox="0 0 100 100" aria-hidden="true">
          <circle class="bg-track" cx="50" cy="50" r="42" />
          <circle
            class="score-arc"
            cx="50" cy="50" r="42"
            stroke-dasharray="<?php echo $circumference; ?>"
            stroke-dashoffset="<?php echo $offset; ?>"
          />
        </svg>
        <div class="review-trust-index__score">
          <strong class="review-trust-index__score-num"><?php echo esc_html($total); ?></strong>
          <span class="review-trust-index__score-denom">/60</span>
        </div>
      </div>
    </div>

    <div class="review-trust-index__grid">
      <?php foreach ($scores as $label => $value) : ?>
        <div class="review-trust-index__row">
          <span class="review-trust-index__label"><?php echo esc_html($label); ?></span>
          <span class="review-trust-index__dots" aria-hidden="true"></span>
          <span class="review-trust-index__value"><?php echo esc_html($value); ?></span>
        </div>
      <?php endforeach; ?>
    </div>

  </div>

  <?php if ($comments) : ?>
    <div class="review-trust-index__comments">
      <p><strong>Verdict: </strong><?php echo esc_html($comments); ?></p>
    </div>
  <?php endif; ?>

</div>
