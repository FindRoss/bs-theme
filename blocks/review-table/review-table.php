<?php 

// site : Site - done
// type : Type - done
// cryoto : Crypto - done
// founded : Founded - done
// num_games : Number of Games - done
// features : Features - done
// token : Token - done
// blockchain : Blockchain - done

// VIP GROUP
// vip_program: VIP Program - done
// vip_transfer : VIP Transfer - done
// vip_guide : VIP Guide - done

// PAYMENTS GROUP
// withdrawal_time : Withdrawal Time - done
// withdrawal_fee: Withdrawal Fee - done
// bonus : Bonus - done

// bonus_title, bonus, bonus_plus, bonus_terms

$count = 1; 
$review_table_data = get_field('review_table_rows') ?: [];
$selected_columns = get_field('review_table_cols') ?: ['site', 'crypto', 'bonus', 'cta'];
// $selected_columns = ['logo', 'bonus', 'crypto', 'cta'];
$show_rank = get_field('review_table_rank');
// $selected_columns = ['site', 'bonus', 'cta'];

$extra_classes = isset($block['className']) ? (string) $block['className'] : '';



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
        return $founded ? esc_html($founded) : '-';
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
        $games = get_field('details_group', $review_id)['num_games'] ?? null;
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
      return $link ? '<a href="' . $link . '" class="button button__primary">Visit</a>' : '';
    }
  ],
  'blockchain' => [
    'label' => 'Blockchain', 
    'class' => '',
    'render' => function($review_id) {
      $blockchain = get_field('details_group', $review_id)['blockchain'] ?? null;
      return $blockchain ? $blockchain : '';
    }
  ],
  'token' => [
    'label' => 'Token', 
    'class' => '',
    'render' => function($review_id) {
      $token = get_field('details_group', $review_id)['token'] ?? null;
      return $token ? $token : '';
    }
  ],
  'vip_program' => [
    'label' => 'VIP Program', 
    'class' => '',
    'render' => function($review_id) {
      $truefalse = get_field('details_group', $review_id)['vip_program'];
      return $truefalse ? '<i data-feather="check"></i>' : '<i data-feather="slash"></i>';
    }
  ],
  'vip_transfer' => [
    'label' => 'VIP Transfer', 
    'class' => '',
    'render' => function($review_id) {
      $truefalse = get_field('details_group', $review_id)['vip_transfer'];
      return $truefalse ? '<i data-feather="check"></i>' : '<i data-feather="slash"></i>';
    }
  ],
  'vip_guide' => [
    'label' => 'VIP Guide', 
    'class' => '',
    'render' => function($review_id) {
      $post_id = get_field('details_group', $review_id)['vip_guide'];
      return $post_id ? '<a href="' . get_the_permalink($post_id) . '">' . get_the_title($post_id) . '</a>' : '';
    }
  ],
  'withdrawal_time' => [
    'label' => 'Withdrawal Time', 
    'class' => '',
    'render' => function($review_id) {
      $time = get_field('details_group', $review_id)['withdrawal_time'];
      return $time ? $time : '';
    }
  ],
  'withdrawal_fee' => [
    'label' => 'Withdrawal Fee', 
    'class' => '',
    'render' => function($review_id) {
      $fee = get_field('details_group', $review_id)['withdrawal_fee'];
      return $fee ? $fee : '';
    }
  ],
  'bonus' => [
    'label' => 'Bonus',
    'class' => '',
    'render' => function($review_id) {
      $bonus_title = get_field('details_group', $review_id)['bonus_title'];
      $bonus = get_field('details_group', $review_id)['bonus'];
      $bonus_plus = get_field('details_group', $review_id)['bonus_plus'];
      if ($bonus) {
        return 
          '<div class="bonus-cell">' . 
          '<div class="title">' .
          $bonus_title . 
          '</div>' .
          '<div class="bonus">' .
          $bonus .
          '</div>' .
          '<div class="plus">' .
          $bonus_plus . 
          '</div>' .
          '</div>';
      }
    }
  ],
  'logo' => [
    'label' => 'site',
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
      <?php foreach ($review_table_data as $review): 
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
