<?php
$review_id = $args['review_id'] ?? get_the_ID();
$size      = $args['size'] ?? 'small'; // 'small' | 'large'

$details      = get_field('details_group', $review_id);
$founded      = $details['year_founded'] ?? null;
$owner        = $details['owner'] ?? null;
$num_games    = get_field('games_group', $review_id)['num_games'] ?? null;
$vip_group    = get_field('vip_group', $review_id);
$has_vip      = is_array($vip_group) && !empty($vip_group['has_vip_program']);
$has_transfer = is_array($vip_group) && !empty($vip_group['has_vip_transfer']);
$payment         = get_field('payment_group', $review_id);
$deposit_min     = $payment['deposit_min'] ?? null;
$withdrawal_time = $payment['withdrawal_time'] ?? null;
$withdrawal_max  = $payment['withdrawal_max'] ?? null;

$license_terms  = get_the_terms($review_id, 'license');
$license_output = (!empty($license_terms) && !is_wp_error($license_terms))
  ? implode(', ', wp_list_pluck($license_terms, 'name'))
  : null;

$boxes = [];
if ($founded)        $boxes[] = ['label' => 'Founded',          'value' => esc_html($founded)];
if ($owner)          $boxes[] = ['label' => 'Owner',            'value' => esc_html($owner)];
if ($license_output) $boxes[] = ['label' => 'Licensed',         'value' => esc_html($license_output)];
if ($num_games)      $boxes[] = ['label' => 'Games',            'value' => esc_html($num_games)];
if ($has_vip)      $boxes[] = ['label' => 'VIP Club',     'value' => '<i data-feather="check"></i> Yes'];
if ($has_transfer) $boxes[] = ['label' => 'VIP Transfer', 'value' => '<i data-feather="check"></i> Yes'];
if ($deposit_min)    $boxes[] = ['label' => 'Min. Deposit',     'value' => esc_html($deposit_min)];
if ($withdrawal_max) $boxes[] = ['label' => 'Max. Withdrawal',  'value' => esc_html($withdrawal_max)];
if ($withdrawal_time) $boxes[] = ['label' => 'Withdrawal Time', 'value' => esc_html($withdrawal_time)];

if (empty($boxes)) return;
?>

<ul class="review-info-boxes review-info-boxes--<?php echo esc_attr($size); ?>">
  <?php foreach ($boxes as $box) : ?>
    <li>
      <span class="review-info-boxes__label"><?php echo $box['label']; ?></span>
      <span class="review-info-boxes__value"><?php echo $box['value']; ?></span>
    </li>
  <?php endforeach; ?>
</ul>
