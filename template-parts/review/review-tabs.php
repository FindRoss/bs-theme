<?php
$review_id = $args['review_id'] ?? get_the_ID();

if (!function_exists('bs_chips_html')) {
  function bs_chips_html(array $items, int $visible = 8, string $singular = 'item', string $plural = ''): string {
    if (empty($items)) return '';
    if (!$plural) $plural = $singular . 's';

    $total        = count($items);
    $needs_toggle = $total > $visible;
    $html         = $needs_toggle ? '<div class="truncated" data-truncated>' : '';
    $html        .= '<div class="chips">';

    foreach ($items as $i => $item) {
      $hidden = ($needs_toggle && $i >= $visible) ? ' is-hidden' : '';
      $label  = esc_html($item['label']);
      if (!empty($item['url'])) {
        $html .= '<a class="chips__chip' . $hidden . '" href="' . esc_url($item['url']) . '">' . $label . '</a>';
      } else {
        $html .= '<span class="chips__chip' . $hidden . '">' . $label . '</span>';
      }
    }

    $html .= '</div>';

    if ($needs_toggle) {
      $noun       = $total === 1 ? $singular : $plural;
      $label_open = 'Show all ' . $total . ' ' . $noun . ' →';
      $html .= '<button type="button" class="truncated__toggle" aria-expanded="false"'
             . ' data-label-open="' . esc_attr($label_open) . '"'
             . ' data-label-close="Show fewer ↑">'
             . esc_html($label_open)
             . '</button></div>';
    }

    return $html;
  }
}

if (!function_exists('bs_terms_to_chip_items')) {
  function bs_terms_to_chip_items(array $terms): array {
    $items = [];
    foreach ($terms as $term) {
      $url     = get_term_link($term);
      $items[] = ['label' => $term->name, 'url' => is_wp_error($url) ? '' : $url];
    }
    return $items;
  }
}

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

$type_output    = bs_chips_html(bs_terms_to_chip_items($type_terms), 8, 'type', 'types');
$license_output = bs_chips_html(bs_terms_to_chip_items($license_terms), 8, 'license', 'licenses');
$lang_items     = array_map(fn($l) => ['label' => trim($l), 'url' => ''], (array) $languages);
$lang_output    = bs_chips_html($lang_items, 8, 'language', 'languages');

// Games
$games_group  = get_field('games_group', $review_id);
$num_games    = $games_group['num_games'] ?? null;
$game_terms   = get_the_terms($review_id, 'game') ?: [];
$prov_terms   = get_the_terms($review_id, 'provider') ?: [];

$game_output = bs_chips_html(bs_terms_to_chip_items($game_terms), 8, 'game type', 'game types');
$prov_output = bs_chips_html(bs_terms_to_chip_items($prov_terms), 8, 'provider', 'providers');

// Payments
$payment_group   = get_field('payment_group', $review_id);
$deposit_min     = $payment_group['deposit_min'] ?? null;
$withdrawal_min  = $payment_group['withdrawal_min'] ?? null;
$withdrawal_max  = $payment_group['withdrawal_max'] ?? null;
$withdrawal_time = $payment_group['withdrawal_time'] ?? null;
$withdrawal_fee  = $payment_group['withdrawal_fee'] ?? null;
$crypto_terms    = get_the_terms($review_id, 'cryptocurrency') ?: [];
$payment_terms   = get_the_terms($review_id, 'payment') ?: [];

$crypto_output   = bs_chips_html(bs_terms_to_chip_items($crypto_terms), 8, 'cryptocurrency', 'cryptocurrencies');
$pmethods_output = bs_chips_html(bs_terms_to_chip_items($payment_terms), 8, 'method', 'methods');

// Support
$support_group    = get_field('support_group', $review_id);
$support_channels = $support_group['channels'] ?? [];
$country_terms    = get_the_terms($review_id, 'country') ?: [];

$channel_items   = array_map(fn($c) => ['label' => trim($c), 'url' => ''], (array) $support_channels);
$channels_output = bs_chips_html($channel_items, 8, 'channel', 'channels');
$country_output  = bs_chips_html(bs_terms_to_chip_items($country_terms), 8, 'country', 'countries');

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
        <div class="review-details">
          <?php foreach ($tab['rows'] as $row) : ?>
            <div class="review-details__row<?php echo $row['type'] === 'taxonomy' ? ' review-details__row--taxonomy' : ''; ?>">
              <span class="review-details__icon"><i data-feather="<?php echo esc_attr($row['icon']); ?>"></i></span>
              <div class="review-details__key"><?php echo esc_html($row['label']); ?></div>
              <div class="review-details__val"><?php echo $row['value']; ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
