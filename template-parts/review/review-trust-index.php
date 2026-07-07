<?php
$review_id = $args['review_id'] ?? get_the_ID();

$categories = [
  'fairness'         => ['label' => 'Transparency',            'weight' => 25, 'tooltip' => 'Assesses site ownership, launch date, licensing, and crypto foundation membership..'],
  'track_record'     => ['label' => 'Track Record',            'weight' => 15, 'tooltip' => 'Assesses operational history, past incidents, and long-term reputation.'],
  'security'         => ['label' => 'Account Security',        'weight' => 10, 'tooltip' => 'Reviews encryption standards, two-factor authentication, and data protection practices.'],
  'responsible'      => ['label' => 'Responsible',             'weight' => 10, 'tooltip' => 'Examines responsible gambling tools, self-exclusion options, and harm reduction measures.'],
  'community'        => ['label' => 'Community',               'weight' => 15, 'tooltip' => 'Gauges user trust, community sentiment, and peer-reviewed ratings.'],
  'customer_service' => ['label' => 'Customer Service',        'weight' => 25, 'tooltip' => 'Rates support availability, response times, and issue resolution quality.'],
];

foreach ($categories as $key => $cat) {
  $categories[$key]['value'] = (int) get_field("trust_index_{$key}", $review_id);
}

$total = get_review_trust_score($review_id);

if ($total === null) return;

$modifier = 'low';
if ($total >= 80)     $modifier = 'high';
elseif ($total >= 50) $modifier = 'mid';
?>

<div class="review-trust-index review-trust-index--<?php echo esc_attr($modifier); ?>">

  <div class="review-trust-index__head">
    <h3 class="review-trust-index__title">Trust Score</h3>
    <div class="review-trust-index__total"><strong><?php echo esc_html($total); ?></strong> / 100</div>
  </div>

  <div class="flex flex-col gap-[var(--size-100)]">
    <?php foreach ($categories as $key => $cat) :
      $bar_pct    = ($cat['value'] / 5) * 100;
      $score_val  = round(($cat['value'] / 5) * 100);
      $tooltip_id = 'trust-tip-' . esc_attr($key);
    ?>
      <div class="grid grid-cols-2 md:grid-cols-[200px_1fr] items-center gap-3">

        <div class="flex items-center gap-[5px] relative">
          <span class="text-[13px] font-semibold text-[var(--color-muted-700)] whitespace-nowrap"><?php echo esc_html($cat['label']); ?></span>
          <span class="text-[13px] text-[var(--color-muted-400)]">&middot; <?php echo esc_html($cat['weight']); ?>%</span>
          <button
            class="review-trust-index__info-btn w-[14px] h-[14px] rounded-full border border-[var(--color-muted-300)] bg-transparent text-[var(--color-muted-400)] text-[9px] italic cursor-pointer inline-flex items-center justify-center shrink-0 hover:border-[var(--color-primary-500)] hover:text-[var(--color-primary-500)] focus:outline-none"
            type="button"
            aria-label="About <?php echo esc_attr($cat['label']); ?>"
            aria-expanded="false"
            aria-controls="<?php echo $tooltip_id; ?>"
          ><i>i</i></button>
          <span
            class="review-trust-index__tooltip hidden absolute top-[calc(100%+6px)] left-0 bg-[var(--color-muted-100)] text-[var(--color-muted-700)] border border-[var(--color-muted-200)] text-[12px] leading-relaxed px-[10px] py-2 rounded-[var(--border-radius)] w-[260px] z-[100] pointer-events-none"
            id="<?php echo $tooltip_id; ?>"
            role="tooltip"
          ><?php echo esc_html($cat['tooltip']); ?></span>
        </div>

        <div class="h-[7px] bg-[var(--color-muted-200)] rounded overflow-hidden min-w-[60px]">
          <div class="h-full bg-[var(--trust-color)] rounded" style="width:<?php echo esc_attr($bar_pct); ?>%"></div>
        </div>

      </div>
    <?php endforeach; ?>
  </div>

  <div class="mt-3 pt-2 border-t border-[var(--color-muted-200)] flex items-center justify-between">
    <p class="m-0 text-[12.5px] text-[var(--color-muted-400)] italic"><em>Score reflects additional qualitative review</em></p>
    <a href="<?php echo esc_url( home_url('/trust-index/') ); ?>" class="text-[13px] font-semibold text-[var(--color-primary-500)] no-underline hover:text-[var(--color-primary-700)] whitespace-nowrap">View methodology &rarr;</a>
  </div>

</div>
