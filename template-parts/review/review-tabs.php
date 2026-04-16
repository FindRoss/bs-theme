<?php
$review_id = $args['review_id'] ?? get_the_ID();

// Details
$details       = get_field('details_group', $review_id);
$founded       = $details['year_founded'] ?? null;
$owner         = $details['owner'] ?? null;
$vip_group     = get_field('vip_group', $review_id);
$has_vip       = is_array($vip_group) && !empty($vip_group['has_vip_program']);
$has_transfer  = is_array($vip_group) && !empty($vip_group['has_vip_transfer']);
$languages     = get_field('languages', $review_id) ?? [];

$type_terms    = get_the_terms($review_id, 'review_type') ?: [];
$license_terms = get_the_terms($review_id, 'license') ?: [];

$type_output    = implode(', ', wp_list_pluck($type_terms, 'name'));
$license_output = implode(', ', array_map(function($t) {
  return '<a href="' . esc_url(get_term_link($t)) . '">' . esc_html($t->name) . '</a>';
}, $license_terms));
$lang_output    = implode(', ', array_map('esc_html', $languages));

// Games
$games_group  = get_field('games_group', $review_id);
$num_games    = $games_group['num_games'] ?? null;
$game_terms   = get_the_terms($review_id, 'game') ?: [];
$prov_terms   = get_the_terms($review_id, 'provider') ?: [];

$game_output = implode(', ', array_map(function($t) {
  return '<a href="' . esc_url(get_term_link($t)) . '">' . esc_html($t->name) . '</a>';
}, $game_terms));
$prov_output = implode(', ', array_map(function($t) {
  return '<a href="' . esc_url(get_term_link($t)) . '">' . esc_html($t->name) . '</a>';
}, $prov_terms));

// Payments
$payment_group   = get_field('payment_group', $review_id);
$deposit_min     = $payment_group['deposit_min'] ?? null;
$withdrawal_min  = $payment_group['withdrawal_min'] ?? null;
$withdrawal_max  = $payment_group['withdrawal_max'] ?? null;
$withdrawal_time = $payment_group['withdrawal_time'] ?? null;
$withdrawal_fee  = $payment_group['withdrawal_fee'] ?? null;
$crypto_terms    = get_the_terms($review_id, 'cryptocurrency') ?: [];
$payment_terms   = get_the_terms($review_id, 'payment') ?: [];

$crypto_output   = implode(', ', array_map(function($t) {
  return '<a href="' . esc_url(get_term_link($t)) . '">' . esc_html($t->name) . '</a>';
}, $crypto_terms));
$pmethods_output = implode(', ', array_map(function($t) {
  return '<a href="' . esc_url(get_term_link($t)) . '">' . esc_html($t->name) . '</a>';
}, $payment_terms));

// Support
$support_group    = get_field('support_group', $review_id);
$support_channels = $support_group['channels'] ?? [];
$country_terms    = get_the_terms($review_id, 'country') ?: [];

$channels_output = implode(', ', array_map('esc_html', (array) $support_channels));
$country_output  = implode(', ', array_map(function($t) {
  return '<a href="' . esc_url(get_term_link($t)) . '">' . esc_html($t->name) . '</a>';
}, $country_terms));

// Row types: 'simple' = label left / value right; 'taxonomy' = label full-width header, values below
$tabs = [
  'details' => [
    'label' => 'Details',
    'rows'  => array_filter([
      // Simple rows first
      $founded      ? ['label' => 'Founded',     'icon' => 'calendar',   'value' => esc_html($founded),  'type' => 'simple'] : null,
      $owner        ? ['label' => 'Owner',        'icon' => 'user',       'value' => esc_html($owner),    'type' => 'simple'] : null,
      $has_vip      ? ['label' => 'VIP Club',     'icon' => 'star',       'value' => '<i data-feather="check"></i> Yes', 'type' => 'simple'] : null,
      $has_transfer ? ['label' => 'VIP Transfer', 'icon' => 'refresh-cw', 'value' => '<i data-feather="check"></i> Yes', 'type' => 'simple'] : null,
      // Taxonomy rows last — license first among them
      $license_output ? ['label' => 'License',   'icon' => 'shield', 'value' => $license_output, 'type' => 'taxonomy'] : null,
      $type_output    ? ['label' => 'Type',       'icon' => 'tag',    'value' => $type_output,    'type' => 'taxonomy'] : null,
      $lang_output    ? ['label' => 'Languages',  'icon' => 'globe',  'value' => $lang_output,    'type' => 'taxonomy'] : null,
    ]),
  ],
  'games' => [
    'label' => 'Games',
    'rows'  => array_filter([
      // Simple rows first
      $num_games   ? ['label' => 'No. of Games', 'icon' => 'grid',   'value' => esc_html($num_games), 'type' => 'simple']   : null,
      // Taxonomy rows last
      $game_output ? ['label' => 'Game Types',   'icon' => 'layers', 'value' => $game_output,         'type' => 'taxonomy'] : null,
      $prov_output ? ['label' => 'Providers',    'icon' => 'box',    'value' => $prov_output,         'type' => 'taxonomy'] : null,
    ]),
  ],
  'payments' => [
    'label' => 'Payments',
    'rows'  => array_filter([
      // Simple rows first
      $deposit_min     ? ['label' => 'Min. Deposit',     'icon' => 'credit-card', 'value' => esc_html($deposit_min),     'type' => 'simple'] : null,
      $withdrawal_min  ? ['label' => 'Min. Withdrawal',  'icon' => 'arrow-down',  'value' => esc_html($withdrawal_min),  'type' => 'simple'] : null,
      $withdrawal_max  ? ['label' => 'Max. Withdrawal',  'icon' => 'arrow-up',    'value' => esc_html($withdrawal_max),  'type' => 'simple'] : null,
      $withdrawal_time ? ['label' => 'Withdrawal Time',  'icon' => 'clock',       'value' => esc_html($withdrawal_time), 'type' => 'simple'] : null,
      $withdrawal_fee  ? ['label' => 'Withdrawal Fee',   'icon' => 'percent',     'value' => esc_html($withdrawal_fee),  'type' => 'simple'] : null,
      // Taxonomy rows last
      $crypto_output   ? ['label' => 'Cryptocurrencies', 'icon' => 'dollar-sign', 'value' => $crypto_output,   'type' => 'taxonomy'] : null,
      $pmethods_output ? ['label' => 'Payment Methods',  'icon' => 'credit-card', 'value' => $pmethods_output, 'type' => 'taxonomy'] : null,
    ]),
  ],
  'support' => [
    'label' => 'Support',
    'rows'  => array_filter([
      $channels_output ? ['label' => 'Channels',  'icon' => 'message-circle', 'value' => $channels_output, 'type' => 'taxonomy'] : null,
      $country_output  ? ['label' => 'Countries', 'icon' => 'map-pin',        'value' => $country_output,  'type' => 'taxonomy'] : null,
    ]),
  ],
];

$tabs = array_filter($tabs, fn($tab) => !empty($tab['rows']));

if (empty($tabs)) return;

$first_key = array_key_first($tabs);
?>

<div class="review-tabs">
  <nav class="review-tabs__nav" role="tablist">
    <?php foreach ($tabs as $key => $tab) : ?>
      <button
        class="review-tabs__btn<?php echo $key === $first_key ? ' active' : ''; ?>"
        role="tab"
        data-tab="tab-<?php echo esc_attr($key); ?>"
        aria-controls="tab-<?php echo esc_attr($key); ?>"
        aria-selected="<?php echo $key === $first_key ? 'true' : 'false'; ?>"
      >
        <?php echo esc_html($tab['label']); ?>
      </button>
    <?php endforeach; ?>
  </nav>

  <div class="review-tabs__panels">
    <?php foreach ($tabs as $key => $tab) : ?>
      <div
        id="tab-<?php echo esc_attr($key); ?>"
        class="review-tabs__panel<?php echo $key === $first_key ? ' active' : ''; ?>"
        role="tabpanel"
      >
        <table class="review-table">
          <tbody>
            <?php foreach ($tab['rows'] as $row) :
              if ($row['type'] === 'taxonomy') : ?>
                <tr class="review-table__row review-table__row--taxonomy">
                  <th colspan="2" scope="rowgroup">
                    <span class="review-info-boxes__label-icon"><i data-feather="<?php echo esc_attr($row['icon']); ?>"></i></span>
                    <?php echo esc_html($row['label']); ?>
                  </th>
                </tr>
                <tr class="review-table__row review-table__row--taxonomy-values">
                  <td colspan="2"><?php echo $row['value']; ?></td>
                </tr>
              <?php else : ?>
                <tr class="review-table__row">
                  <th scope="row">
                    <span class="review-info-boxes__label-icon"><i data-feather="<?php echo esc_attr($row['icon']); ?>"></i></span>
                    <?php echo esc_html($row['label']); ?>
                  </th>
                  <td><?php echo $row['value']; ?></td>
                </tr>
              <?php endif;
            endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endforeach; ?>
  </div>
</div>
