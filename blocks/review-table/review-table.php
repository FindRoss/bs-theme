<?php 
$extra_classes = isset($block['className']) ? (string) $block['className'] : '';
$count = 1; 
$review_table_rows = get_field('review_table_rows') ?: [];
$selected_columns = get_field('review_table_cols') ?: ['site', 'crypto', 'bonus', 'cta'];
// $selected_columns = ['logo', 'bonus', 'crypto', 'cta'];
$show_rank = get_field('review_table_rank');
// $selected_columns = ['site', 'bonus', 'cta'];

$columns = [
  'site' => [
    'label' => 'Site',
    'class' => 'col-site',
    'render' => function($review_id) {
        $name = get_the_title($review_id);
        $url  = get_the_permalink($review_id);
        return $url ? '<a href="' . esc_url($url) . '" rel="noopener" target="_blank">' . esc_html($name) . '</a>' : esc_html($name);
    },
  ],
  'founded' => [
    'label' => 'Founded',
    'class' => '',
    'render' => function($review_id) {
        $founded = get_field('details_group', $review_id)['year_founded'] ?? null;
        return $founded ? esc_html($founded) : 'Unknown';
    },
  ],
  'owner' => [
    'label' => 'Owner',
    'class' => '',
    'render' => function($review_id) {
        $owner = get_field('details_group', $review_id)['owner'] ?? null;
        return $owner ? esc_html($owner) : 'Unknown';
    },
  ],
  'crypto' => [
    'label' => 'Crypto',
    'class' => 'col-crypto',
    'render' => function($review_id) {
      $crypto_terms = get_the_terms($review_id, 'cryptocurrency');
      $crypto_output = display_review_crypto($crypto_terms, 3); 
      return '<div class="crypto-icons">' . $crypto_output . '</div>';
    }
  ],
  'type' => [
    'label' => 'Type', 
    'class' => 'col-type',
    'render' => function($review_id) {
      $type_terms = get_the_terms($review_id, 'review_type');
      $type_output = display_review_type($type_terms);
      return '<div class="info-pills">' . $type_output . '</div>';
    }
  ],
  'num_games' => [
    'label' => 'Number of Games', 
    'class' => '',
    'render' => function($review_id) {
        $games = get_field('games_group', $review_id)['num_games'] ?? null;
        return $games ? esc_html($games) : '';
    }
  ],
  'features' => [
    'label' => 'Features', 
    'class' => '', 
    'render' => function($review_id) {
      $excerpt = get_the_excerpt($review_id);
      return $excerpt ? esc_html($excerpt) : '';
    }
  ],
  'cta' => [
    'label' => '',
    'class' => '',
    'render' => function($review_id) {
      $link = get_field('details_group', $review_id)['affiliate_link'] ?? null;
      return $link ? '<a target="_blank" href="' . $link . '" class="button button__primary">Visit</a>' : '';
    }
  ],
  'blockchain' => [
    'label' => 'Blockchain', 
    'class' => '',
    'render' => function($review_id) {
      $blockchain = get_field('blockchain_group', $review_id)['blockchain'] ?? null;
      return $blockchain ? $blockchain : 'N/A';
    }
  ],
  'token' => [
    'label' => 'Token', 
    'class' => '',
    'render' => function($review_id) {
      $token = get_field('blockchain_group', $review_id)['token'] ?? null;
      return $token ? $token : 'N/A';
    }
  ],
  'vip_program' => [
    'label' => 'VIP Program', 
    'class' => '',
    'render' => function($review_id) {
      $truefalse = get_field('vip_group', $review_id)['has_vip_program'];
      return $truefalse ? '<i data-feather="check"></i>' : '<i data-feather="slash"></i>';
    }
  ],
  'vip_transfer' => [
    'label' => 'VIP Transfer', 
    'class' => '',
    'render' => function($review_id) {
      $truefalse = get_field('vip_group', $review_id)['has_vip_transfer'];
      return $truefalse ? '<i data-feather="check"></i>' : '<i data-feather="slash"></i>';
    }
  ],
  'vip_guide' => [
    'label' => 'VIP Guide', 
    'class' => '',
    'render' => function($review_id) {
      $post_id = get_field('vip_group', $review_id)['vip_guide'];
      return $post_id ? '<a href="' . get_the_permalink($post_id) . '">' . get_the_title($post_id) . '</a>' : '-';
    }
  ],
  'withdrawal_time' => [
    'label' => 'Withdrawal Time', 
    'class' => '',
    'render' => function($review_id) {
      $time = get_field('payment_group', $review_id)['withdrawal_time'];
      return $time ? $time : '';
    }
  ],
  'withdrawal_fee' => [
    'label' => 'Withdrawal Fee', 
    'class' => '',
    'render' => function($review_id) {
      $fee = get_field('payment_group', $review_id)['withdrawal_fee'];
      return $fee ? $fee : '';
    }
  ],
  'bonus' => [
    'label' => 'Bonus',
    'class' => '',
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
    'label' => 'Site',
    'class' => 'col-logo',
    'render' => function($review_id) {
      $logo = get_the_post_thumbnail_url($review_id, 'site-small-logo'); 
      $link = get_the_permalink($review_id);
      $title = get_the_title($review_id);
      return '<a class="img-link" href="' . $link . '"><img width="120" height="60" class="logo" src="' . $logo . '" alt="' . $title . '" title="' . $title . '"></a>';
    }
  ]
]
?>

<div class="main--table review--table <?php echo esc_attr($extra_classes); ?>">
  <table>
    <thead>
      <tr>
        <?php if ($show_rank) { ?><th>#</th><?php } ?>
        <?php foreach ($selected_columns as $key): ?>
          <?php if (isset($columns[$key])): ?>
            <th><?php echo $columns[$key]['label']; ?></th>
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
        <?php if ($show_rank) { ?><td class="col-rank"><?php echo $count; ?></td><?php } ?>
        <?php foreach ($selected_columns as $key): ?>
          <td <?php echo isset($key['class']) ? 'class="' . $key['class'] . '"' : ''; ?>>
            <?php 
              if (isset($columns[$key])) {
                echo $columns[$key]['render']($review_id);
              }
            ?>
          </td>
        <?php endforeach; ?>
      </tr>
      <?php $count++; endforeach; ?>
    </tbody>
  </table>
</div>
