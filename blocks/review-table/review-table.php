<?php 
$extra_classes = isset($block['className']) ? (string) $block['className'] : '';
$count = 1; 
$review_table_rows = get_field('review_table_rows') ?: [];
$selected_columns = get_field('review_table_cols') ?: ['site', 'crypto', 'bonus', 'cta'];
// $selected_columns = ['logo', 'bonus', 'crypto', 'cta'];
$show_rank = get_field('review_table_rank');
// $stack_on_mobile = get_field('stack_mobile');
$overflow_scroll = get_field('overflow_scroll');

$overflow_class = $overflow_scroll ? 'custom-table-scroll' : '';
// $mobile_class = $stack_on_mobile ? 'stacked-table' : '';


$columns = [
  'site' => [
    'label' => 'Site',
    'mobile_label' => false,
    'class' => 'column-site full-cell',
    'icon' => 'globe',
    'render' => function($review_id) {
        $name = get_the_title($review_id);
        $url  = get_the_permalink($review_id);
        return $url ? '<a href="' . esc_url($url) . '" rel="noopener" target="_blank">' . esc_html($name) . '</a>' : esc_html($name);
    },
  ],
  'founded' => [
    'label' => 'Founded',
    'mobile_label' => true,
    'class' => 'half-cell',
    'icon' => 'calendar',
    'render' => function($review_id) {
        $founded = get_field('details_group', $review_id)['year_founded'] ?? null;
        return $founded ? esc_html($founded) : '';
    },
  ],
  'owner' => [
    'label' => 'Owner',
    'mobile_label' => true,
    'class' => 'half-cell',
    'icon' => 'user',
    'render' => function($review_id) {
        $owner = get_field('details_group', $review_id)['owner'] ?? null;
        return $owner ? esc_html($owner) : '';
    },
  ],
  'crypto' => [
    'label' => 'Crypto',
    'mobile_label' => true,
    'class' => 'column-crypto',
    'icon' => 'dollar-sign',
    'render' => function($review_id) {
      $crypto_terms = get_the_terms($review_id, 'cryptocurrency');
      $crypto_output = display_review_crypto($crypto_terms, 3); 
      return '<div class="crypto-icons">' . $crypto_output . '</div>';
    }
  ],
  'type' => [
    'label' => 'Type', 
    'mobile_label' => true,
    'class' => 'column-type',
    'icon' => 'tag',
    'render' => function($review_id) {
      $type_terms = get_the_terms($review_id, 'review_type');
      $type_output = display_review_type($type_terms);
      return '<div class="info-pills">' . $type_output . '</div>';
    }
  ],
  'num_games' => [
    'label' => 'Games', 
    'mobile_label' => true,
    'class' => '',
    'icon' => 'grid',
    'render' => function($review_id) {
        $games = get_field('games_group', $review_id)['num_games'] ?? null;
        return $games ? esc_html($games) : '';
    }
  ],
  'features' => [
    'label' => 'Features', 
    'mobile_label' => true,
    'class' => '', 
    'icon' => 'layers',
    'render' => function($review_id) {
      $excerpt = get_the_excerpt($review_id);
      return $excerpt ? esc_html($excerpt) : '';
    }
  ],
  'cta' => [
    'label' => '',
    'mobile_label' => false,
    'class' => 'column-cta ',
    'icon' => '',
    'render' => function($review_id) {
      $link = get_field('details_group', $review_id)['affiliate_link'] ?? null;
      return $link ? '<a target="_blank" href="' . $link . '" class="button button__primary">Visit</a>' : '';
    }
  ],
  'blockchain' => [
    'label' => 'Blockchain',
    'mobile_label' => true, 
    'class' => '',
    'icon' => 'hash',
    'render' => function($review_id) {
      $blockchain_group = get_field('blockchain_group', $review_id);
      return is_array($blockchain_group) ? ($blockchain_group['blockchain'] ?? 'N/A') : 'N/A';
    }
  ],
  'token' => [
    'label' => 'Token ', 
    'mobile_label' => true,
    'class' => '',
    'icon' => 'shield',
    'render' => function($review_id) {
      $blockchain_group = get_field('blockchain_group', $review_id);
      $token = is_array($blockchain_group) ? ($blockchain_group['token'] ?? null) : null;
      return $token ?: 'N/A';
    }
  ],
  'vip_program' => [
    'label' => 'VIP Club', 
    'mobile_label' => true,
    'class' => '',
    'icon' => 'star',
    'render' => function($review_id) {
      $vip_group = get_field('vip_group', $review_id);
      $has_vip = is_array($vip_group) && !empty($vip_group['has_vip_program']);
      return $has_vip ? '<i data-feather="check"></i>' : '<i data-feather="slash"></i>';
    }
  ],
  'vip_transfer' => [
    'label' => 'VIP Transfer', 
    'mobile_label' => true,
    'class' => 'half-cell',
    'icon' => 'repeat',
    'render' => function($review_id) {
      $vip_group = get_field('vip_group', $review_id);
      $truefalse = is_array($vip_group) && !empty($vip_group['has_vip_transfer']);
      return $truefalse ? '<i data-feather="check"></i>' : '<i data-feather="slash"></i>';
    }
  ],
  'vip_guide' => [
    'label' => 'VIP Guide', 
    'mobile_label' => true,
    'class' => '',
    'icon' => 'book-open',
    'render' => function($review_id) {
      $vip_group = get_field('vip_group', $review_id);
      $post_id = is_array($vip_group) ? ($vip_group['vip_guide'] ?? null) : null;
      return $post_id ? '<a href="' . get_the_permalink($post_id) . '">' . get_the_title($post_id) . '</a>' : '-';
    }
  ],
  'withdrawal_time' => [
    'label' => 'Withdrawal Time', 
    'mobile_label' => true,
    'class' => 'half-cell',
    'icon' => 'clock',
    'render' => function($review_id) {
      $time = get_field('payment_group', $review_id)['withdrawal_time'] ?? null;
      return $time ?: '';
    }
  ],
  'withdrawal_fee' => [
    'label' => 'Withdrawal Fee',  
    'mobile_label' => true,
    'class' => 'half-cell',
    'icon' => 'dollar-sign',
    'render' => function($review_id) {
      $fee = get_field('payment_group', $review_id)['withdrawal_fee'] ?? null;
      return $fee ?: '';
    }
  ],
  'bonus' => [
    'label' => 'Bonus',
    'mobile_label' => true,
    'class' => 'column-bonus half-cell',
    'icon' => 'gift',
    'render' => function($review_id) {
      $bonus_title = get_field('bonus_group', $review_id)['bonus_title'] ?? null;
      $bonus = get_field('bonus_group', $review_id)['bonus'] ?? null;
      $bonus_plus = get_field('bonus_group', $review_id)['bonus_plus'] ?? null;
      
      if (!$bonus) return null;

      $html  = '<div class="bonus-cell">';
      if ($bonus_title) {
        $html .= '<div class="title">' . esc_html($bonus_title) . '</div>';
      }
      $html .= '<div class="bonus">' . esc_html($bonus) . '</div>';
      if ($bonus_plus) {
        $html .= '<div class="plus">' . esc_html($bonus_plus) . '</div>';
      }
      $html .= '</div>';

      return $html;
    }
  ],
  'logo' => [
    'label' => '',
    'mobile_label' => false,
    'class' => 'column-logo full-cell',
    'icon' => '',
    'render' => function($review_id) {
      $logo = get_the_post_thumbnail_url($review_id, 'site-small-logo'); 
      $link = get_the_permalink($review_id);
      $title = get_the_title($review_id);
      return '<a class="img-link" href="' . $link . '"><img width="120" height="60" class="logo" src="' . $logo . '" alt="' . $title . '" title="' . $title . '"></a>';
    }
  ]
];

?>

<div class="main--table review--table <?php 
    echo esc_attr($extra_classes . ' ' . $overflow_class); 
  ?>">
  <table>
    <thead>
      <tr>
        <?php if ($show_rank) { ?><th>#</th><?php } ?>
        <?php foreach ($selected_columns as $key): ?>
          <?php if (isset($columns[$key])): ?>
            <th>
              <!-- <span class="icon"><i data-feather="<?php echo $columns[$key]['icon']; ?>"></i></span> -->
              <span class="label"><?php echo $columns[$key]['label']; ?></span>
            </th>
          <?php endif; ?>
        <?php endforeach; ?>
      </tr>
    </thead>

    <tbody> 
      <?php foreach ($review_table_rows as $review): 
        $review_id = (int)$review;
        if ($review_id <= 0) continue;
      ?>
      <tr>
        <?php if ($show_rank) { ?><td class="column-rank"><?php echo $count; ?></td><?php } ?>
        <?php foreach ($selected_columns as $key): ?>
          
          <?php 
          $td_col_class = !empty($columns[$key]['class'])
            ? esc_attr($columns[$key]['class'])
            : '';
          ?>

          <td data-label="<?php echo $columns[$key]['label']?>" class="<?php echo $td_col_class; ?>">

             
            <!--  if (isset($columns[$key]['icon']) && !empty($columns[$key]['icon'])) { ?>
                <div class="mobile-label">
                  <span class="icon-wrapper">
                    <i data-feather="echo $columns[$key]['icon']" ?>></i>
                  </span>
                  <span class="label">echo $columns[$key]['label']; ?></span>
                </div>
              } ?> -->

            <?php 
              if (isset($columns[$key])) echo $columns[$key]['render']($review_id);
            ?>
          </td>
        <?php endforeach; ?>
      </tr>
      <?php $count++; endforeach; ?>
    </tbody>
  </table>
</div>
