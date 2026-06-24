<?php get_header(); ?>

<?php
// Safety check for ACF - required for this page template
if (!function_exists('get_field')) {
  wp_die('Advanced Custom Fields Pro is required for this page.');
}

$trust_metrics = ['fairness', 'track_record', 'security', 'responsible', 'community', 'customer_service'];
$trust_weights = ['fairness'=>25, 'track_record'=>15, 'security'=>10, 'responsible'=>10, 'community'=>15, 'customer_service'=>25];

// Initialize reviews data
$reviews_data = array();
$review_count = 0;

// Safely query reviews - only ones with at least one trust index score
try {
  $reviews_query = new WP_Query(array(
    'post_type'      => 'review',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => array(
      'relation' => 'OR',
      array(
        'key'     => 'trust_index_fairness',
        'value'   => 0,
        'compare' => '>',
        'type'    => 'NUMERIC',
      ),
      array(
        'key'     => 'trust_index_track_record',
        'value'   => 0,
        'compare' => '>',
        'type'    => 'NUMERIC',
      ),
      array(
        'key'     => 'trust_index_security',
        'value'   => 0,
        'compare' => '>',
        'type'    => 'NUMERIC',
      ),
      array(
        'key'     => 'trust_index_responsible',
        'value'   => 0,
        'compare' => '>',
        'type'    => 'NUMERIC',
      ),
      array(
        'key'     => 'trust_index_community',
        'value'   => 0,
        'compare' => '>',
        'type'    => 'NUMERIC',
      ),
      array(
        'key'     => 'trust_index_customer_service',
        'value'   => 0,
        'compare' => '>',
        'type'    => 'NUMERIC',
      ),
    ),
  ));

  // Build review data with trust scores
  if ($reviews_query->have_posts()) {
    while ($reviews_query->have_posts()) {
      $reviews_query->the_post();
      $review_id = get_the_ID();

      $review_entry = array(
        'id' => $review_id,
        'title' => get_the_title(),
        'url' => get_permalink(),
        'metrics' => array()
      );

      // Calculate weighted score for this review
      $weighted_sum = 0;
      foreach ($trust_metrics as $metric) {
        $value = (int) get_field("trust_index_{$metric}", $review_id);
        $review_entry['metrics'][$metric] = $value;
        $weighted_sum += (($value / 5) * $trust_weights[$metric]);
      }
      $review_entry['total'] = round($weighted_sum);

      // Add to results (all results already have scores from the query)
      $reviews_data[] = $review_entry;
    }
  }
  wp_reset_postdata();

  // Sort by total score (descending)
  if (!empty($reviews_data)) {
    usort($reviews_data, function($a, $b) {
      return $b['total'] <=> $a['total'];
    });
  }

  $review_count = count($reviews_data);
} catch (Exception $e) {
  // Silent fail - page will show "No reviews available yet"
  $reviews_data = array();
  $review_count = 0;
}

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

        <?php if (has_post_thumbnail()) : ?>
        <div style="margin: 20px -12px 0 -12px;">
          <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>" width="900" height="600" style="width: 100%; height: auto; display: block;">
        </div>
        <?php endif; ?>

        <div class="main--content mt-5">
          <?php the_content(); ?>
        </div>

        <!-- Trust Index Comparison Table -->
        <?php if ($review_count > 0) : ?>
        <div class="trust-index-table chaser-table mt-5 mb-5">
          <table class="sortable-table" style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
              <tr style="border-bottom: 2px solid var(--color-muted-300); background-color: var(--color-muted-50);">
                <th style="text-align: left; padding: 10px 12px; font-weight: 600; color: var(--color-muted-700); cursor: pointer;">Review</th>
                <?php foreach ($trust_metrics as $metric) : ?>
                <th style="text-align: center; padding: 10px 8px; font-weight: 600; color: var(--color-muted-700); cursor: pointer;"><?php echo esc_html($metric_labels[$metric]); ?></th>
                <?php endforeach; ?>
                <th class="sortable-default" style="text-align: center; padding: 10px 12px; font-weight: 600; color: var(--color-muted-700); cursor: pointer;">Score <span class="sort-indicator">↓</span></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($reviews_data as $review) : ?>
              <tr style="border-bottom: 1px solid var(--color-muted-200);">
                <td style="padding: 10px 12px;" data-sort-value="<?php echo esc_attr($review['title']); ?>">
                  <a href="<?php echo esc_url($review['url']); ?>" style="color: var(--color-primary-500); text-decoration: none; font-weight: 500;">
                    <?php echo esc_html($review['title']); ?>
                  </a>
                </td>
                <?php foreach ($trust_metrics as $metric) : ?>
                <td style="text-align: center; padding: 10px 8px; color: var(--color-muted-700);" data-sort-value="<?php echo esc_attr($review['metrics'][$metric]); ?>"><?php echo esc_html($review['metrics'][$metric]); ?></td>
                <?php endforeach; ?>
                <td style="text-align: center; padding: 10px 12px; font-weight: 600; color: var(--color-muted-800);" data-sort-value="<?php echo esc_attr($review['total']); ?>"><?php echo esc_html($review['total']); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
          const table = document.querySelector('.sortable-table');
          if (!table) return;

          const headers = table.querySelectorAll('thead th');
          let currentSort = { col: null, dir: 'asc' };

          headers.forEach((header, index) => {
            header.addEventListener('click', function() {
              const tbody = table.querySelector('tbody');
              const rows = Array.from(tbody.querySelectorAll('tr'));

              // Reset all sort indicators
              headers.forEach(h => {
                h.querySelector('.sort-indicator')?.remove();
              });

              // Determine sort direction
              if (currentSort.col === index) {
                currentSort.dir = currentSort.dir === 'asc' ? 'desc' : 'asc';
              } else {
                currentSort.col = index;
                currentSort.dir = 'asc';
              }

              // Sort rows
              rows.sort((a, b) => {
                const aVal = a.children[index].getAttribute('data-sort-value') || a.children[index].textContent.trim();
                const bVal = b.children[index].getAttribute('data-sort-value') || b.children[index].textContent.trim();

                // Try numeric sort first
                const aNum = parseFloat(aVal);
                const bNum = parseFloat(bVal);

                if (!isNaN(aNum) && !isNaN(bNum)) {
                  return currentSort.dir === 'asc' ? aNum - bNum : bNum - aNum;
                }

                // Fall back to string sort
                return currentSort.dir === 'asc'
                  ? aVal.localeCompare(bVal)
                  : bVal.localeCompare(aVal);
              });

              // Re-attach sorted rows
              rows.forEach(row => tbody.appendChild(row));

              // Add sort indicator to current header
              const indicator = document.createElement('span');
              indicator.className = 'sort-indicator';
              indicator.textContent = currentSort.dir === 'asc' ? '↑' : '↓';
              this.appendChild(indicator);
            });
          });

          // Trigger default sort on page load (last column - Score)
          headers[headers.length - 1].click();
        });
        </script>
        <?php else : ?>
        <div class="alert alert-info mt-5 mb-5 p-4 border rounded" style="border-color: var(--color-info-300); background-color: var(--color-info-50, #f0f7ff);">
          <p class="m-0">No reviews available yet.</p>
        </div>
        <?php endif; ?>

        <!-- Flexible Content -->
        <?php get_template_part('template-parts/content/flexible-content', null, [
          'post_id' => get_the_ID(),
          'type'    => 'page',
        ]); ?>

      </div>
    </div><!-- .row -->
  </div><!-- .container -->
</article>

<?php endwhile; endif; ?>
<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>
