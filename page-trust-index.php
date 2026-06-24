<?php get_header(); ?>

<?php
$trust_metrics = ['fairness', 'track_record', 'security', 'responsible', 'community', 'customer_service'];
$trust_weights = ['fairness'=>25, 'track_record'=>15, 'security'=>10, 'responsible'=>10, 'community'=>15, 'customer_service'=>25];

// Query all published reviews
$reviews_query = new WP_Query([
  'post_type'      => 'review',
  'posts_per_page' => -1,
  'post_status'    => 'publish',
]);

// Build review data with trust scores
$reviews_data = [];
if ($reviews_query->have_posts()) {
  while ($reviews_query->have_posts()) {
    $reviews_query->the_post();
    $review_id = get_the_ID();

    $review_entry = [
      'id' => $review_id,
      'title' => get_the_title(),
      'url' => get_permalink(),
      'metrics' => []
    ];

    // Calculate weighted score for this review
    $weighted_sum = 0;
    $has_scores = false;
    foreach ($trust_metrics as $metric) {
      $value = (int) get_field("trust_index_{$metric}", $review_id);
      $review_entry['metrics'][$metric] = $value;
      if ($value > 0) {
        $has_scores = true;
      }
      $weighted_sum += (($value / 5) * $trust_weights[$metric]);
    }
    $review_entry['total'] = round($weighted_sum);

    // Only include if this review has at least one score assigned
    if ($has_scores) {
      $reviews_data[] = $review_entry;
    }
  }
}
wp_reset_postdata();

// Sort by total score (descending)
usort($reviews_data, function($a, $b) {
  return $b['total'] <=> $a['total'];
});

$review_count = count($reviews_data);

// Format metric names for display
$metric_labels = [
  'fairness' => 'Fairness',
  'track_record' => 'Track Record',
  'security' => 'Security',
  'responsible' => 'Responsible',
  'community' => 'Community',
  'customer_service' => 'Customer Service'
];
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<article>
  <div class="container mb-4">
    <div class="row mb-5 pb-4 justify-content-center">
      <div class="col-12 col-lg-8">

        <h1 class="main--title"><?php the_title(); ?></h1>

        <!-- Trust Index Comparison Table -->
        <?php if ($review_count > 0) : ?>
        <div class="trust-index-table mt-5 mb-5">
          <div class="overflow-x-auto">
            <table class="w-full border-collapse text-sm" style="border: 1px solid var(--color-muted-200);">
              <thead style="background-color: var(--color-muted-50, #fafafa);">
                <tr>
                  <th class="text-left p-3 border-b font-semibold" style="border-color: var(--color-muted-200); min-width: 180px;">Review</th>
                  <?php foreach ($trust_metrics as $metric) : ?>
                  <th class="text-center p-3 border-b border-l font-semibold" style="border-color: var(--color-muted-200);"><?php echo esc_html($metric_labels[$metric]); ?></th>
                  <?php endforeach; ?>
                  <th class="text-center p-3 border-b border-l font-semibold" style="border-color: var(--color-muted-200);">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($reviews_data as $review) : ?>
                <tr style="border-bottom: 1px solid var(--color-muted-200);">
                  <td class="p-3 text-left">
                    <a href="<?php echo esc_url($review['url']); ?>" style="color: var(--color-primary-500); text-decoration: none; font-weight: 500;">
                      <?php echo esc_html($review['title']); ?>
                    </a>
                  </td>
                  <?php foreach ($trust_metrics as $metric) : ?>
                  <td class="p-3 text-center border-l" style="border-color: var(--color-muted-200);">
                    <?php echo esc_html($review['metrics'][$metric]); ?> / 5
                  </td>
                  <?php endforeach; ?>
                  <td class="p-3 text-center border-l font-semibold" style="border-color: var(--color-muted-200); background-color: var(--color-primary-50, #f0f7ff);">
                    <?php echo esc_html($review['total']); ?> / 100
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php else : ?>
        <div class="alert alert-info mt-5 mb-5 p-4 border rounded" style="border-color: var(--color-info-300); background-color: var(--color-info-50, #f0f7ff);">
          <p class="m-0">No reviews available yet.</p>
        </div>
        <?php endif; ?>

        <div class="main--content mt-5">
          <?php the_content(); ?>
        </div>

      </div>
    </div><!-- .row -->
  </div><!-- .container -->
</article>

<?php endwhile; endif; ?>
<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>
