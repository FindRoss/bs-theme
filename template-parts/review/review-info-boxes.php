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
$payment          = get_field('payment_group', $review_id);
$deposit_min      = $payment['deposit_min'] ?? null;
$withdrawal_min   = $payment['withdrawal_min'] ?? null;
$withdrawal_max   = $payment['withdrawal_max'] ?? null;
$withdrawal_time  = $payment['withdrawal_time'] ?? null;
$withdrawal_fee   = $payment['withdrawal_fee'] ?? null;

$license_terms  = get_the_terms($review_id, 'license');
$license_output = (!empty($license_terms) && !is_wp_error($license_terms))
  ? implode(', ', wp_list_pluck($license_terms, 'name'))
  : null;

$boxes = [];
if ($founded)        $boxes[] = ['label' => 'Founded',         'icon' => 'calendar',    'value' => esc_html($founded)];
if ($owner)          $boxes[] = ['label' => 'Owner',           'icon' => 'user',        'value' => esc_html($owner)];
if ($license_output) $boxes[] = ['label' => 'Licensed',        'icon' => 'shield',      'value' => esc_html($license_output)];
if ($num_games)      $boxes[] = ['label' => 'Games',           'icon' => 'grid',        'value' => esc_html($num_games)];
if ($has_vip)        $boxes[] = ['label' => 'VIP Club',        'icon' => 'star',        'value' => '<i data-feather="check"></i> Yes'];
if ($has_transfer)   $boxes[] = ['label' => 'VIP Transfer',    'icon' => 'refresh-cw',  'value' => '<i data-feather="check"></i> Yes'];
if ($deposit_min)    $boxes[] = ['label' => 'Min. Deposit',    'icon' => 'credit-card', 'value' => esc_html($deposit_min)];
if ($withdrawal_min) $boxes[] = ['label' => 'Min. Withdrawal', 'icon' => 'arrow-down',  'value' => esc_html($withdrawal_min)];
if ($withdrawal_max) $boxes[] = ['label' => 'Max. Withdrawal', 'icon' => 'arrow-up',    'value' => esc_html($withdrawal_max)];
if ($withdrawal_time)$boxes[] = ['label' => 'Withdrawal Time', 'icon' => 'clock',       'value' => esc_html($withdrawal_time)];
if ($withdrawal_fee) $boxes[] = ['label' => 'Withdrawal Fee',  'icon' => 'percent',     'value' => esc_html($withdrawal_fee)];

if (empty($boxes)) return;
?>

<ul class="review-info-boxes review-info-boxes--<?php echo esc_attr($size); ?>">
  <?php foreach ($boxes as $box) : ?>
    <li>
      <span class="review-info-boxes__label"><span class="review-info-boxes__label-icon"><i data-feather="<?php echo esc_attr($box['icon']); ?>"></i></span><?php echo $box['label']; ?></span>
      <span class="review-info-boxes__value"><?php echo $box['value']; ?></span>
    </li>
  <?php endforeach; ?>
</ul>
