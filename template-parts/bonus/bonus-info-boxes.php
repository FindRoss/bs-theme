<?php
$bonus_id = $args['bonus_id'] ?? get_the_ID();

$expiry_date       = get_field('expiry_date', $bonus_id);
$turnover          = get_field('turnover', $bonus_id);
$min_deposit       = get_field('min_deposit', $bonus_id);
$max_bonus         = get_field('max_bonus', $bonus_id);
$max_cashout       = get_field('max_cashout', $bonus_id);
$players_eligible  = get_field('players_eligible', $bonus_id);
$game              = get_field('game', $bonus_id);

$boxes = [];

if ($expiry_date)      $boxes[] = ['label' => 'Expires',              'icon' => 'calendar',    'value' => esc_html(date('d M Y', strtotime($expiry_date)))];
if ($turnover)         $boxes[] = ['label' => 'Wagering Requirement',  'icon' => 'percent',     'value' => esc_html($turnover)];
if ($min_deposit)      $boxes[] = ['label' => 'Min. Deposit',          'icon' => 'credit-card', 'value' => esc_html($min_deposit)];
if ($max_bonus)        $boxes[] = ['label' => 'Max. Bonus',            'icon' => 'arrow-up',    'value' => esc_html($max_bonus)];
if ($max_cashout)      $boxes[] = ['label' => 'Max. Cashout',          'icon' => 'arrow-up',    'value' => esc_html($max_cashout)];
if ($players_eligible) $boxes[] = ['label' => 'Players Eligible',      'icon' => 'users',       'value' => esc_html($players_eligible)];
if ($game)             $boxes[] = ['label' => 'Game Eligible',         'icon' => 'grid',        'value' => esc_html(is_array($game) ? implode(', ', wp_list_pluck($game, 'name')) : $game)];

if (empty($boxes)) return;
?>

<ul class="review-info-boxes review-info-boxes--small">
  <?php foreach ($boxes as $box) : ?>
    <li>
      <span class="review-info-boxes__label">
        <span class="review-info-boxes__label-icon"><i data-feather="<?php echo esc_attr($box['icon']); ?>"></i></span>
        <?php echo $box['label']; ?>
      </span>
      <span class="review-info-boxes__value"><?php echo $box['value']; ?></span>
    </li>
  <?php endforeach; ?>
</ul>
