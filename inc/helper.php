<?php 
/**
 * Get Review Faqs from ACF Field and return as Q and A array 
 */
function get_review_faqs($id = null) {
    if (!$id) return;

    $faq_group  = get_field('review_faqs', $id);
    
    $details_group = get_field('details_group', $id);
    $site_name = $details_group['name'];
    
 
    $faq_owner_q    = 'Who is the owner of the ' . $site_name . '?'; 
    $faq_bitcoin_q  = 'Does the ' . $site_name . ' accept Bitcoin?';
    $faq_legit_q    = 'Is ' . $site_name . ' legit?';
    $faq_licensed_q = 'Is ' . $site_name . ' licensed?';

    $faqs = array();
    
    $faqs[] = array(
      'question' => $faq_owner_q,
      'answer'   => $faq_group['owner'],
    );
    
    $faqs[] = array(
      'question' => $faq_bitcoin_q,
      'answer'   => $faq_group['bitcoin'],
    );
    
    $faqs[] = array(
      'question' => $faq_legit_q,
      'answer'   => $faq_group['legit'],
    );
    
    $faqs[] = array(
      'question' => $faq_licensed_q,
      'answer'   => $faq_group['licensed'],
    );
    

    return $faqs;
};

/**
 * Truncate Text
 */
function truncate_text($text, $max_length = 100) {
  if (strlen($text) > $max_length) {
    return substr($text, 0, $max_length) . '...';
  }
  return $text;
};

function display_review_crypto($crypto_terms, $num_icons = 5) {
  if (is_wp_error($crypto_terms) OR empty($crypto_terms)) return;

  $total_terms_count = count($crypto_terms); // Total number of terms tagged to the post

  usort($crypto_terms, function ($a, $b) {
      return $b->count - $a->count;
  });

  $top_crypto_terms = array_slice($crypto_terms, 0, $num_icons);

  $crypto_output = ''; 

  foreach ($top_crypto_terms as $term) {
    $icon = get_field('icon', $term);
    if (isset($icon['sizes']['thumbnail']) && !empty($icon['sizes']['thumbnail'])) {
      $thumbnail = $icon['sizes']['thumbnail'];
      $crypto_output .= '<img src="' . $thumbnail . '" alt="' . $term->name . ' icon" class="icon" width="28" height="28">';
    }
  }

  if ($total_terms_count > $num_icons) {
    $crypto_output .= '<span class="icon count-icon"><span class="plus">+</span>' . ($total_terms_count - $num_icons) . '</span>'; 
  }

  return $crypto_output;
}

function display_review_type($types) { 
    $output = '';

    // if (!$types OR empty($types)) return;

    foreach ($types as $type) {

      switch($type->name) {
        case 'Casinos':
          $name = 'Casino';
          break;
        case 'Sports Betting':
          $name = 'Sports'; 
          break; 
        case 'Esports Betting': 
          $name = 'Esports';
          break; 
        default:
          $name = $type->name;
      } 

      $output .= '<span class="info-pill"><span>' . $name . '</span></span>';
    }

    return $output;
}

/**
 * Build args for template-parts/section/topic-section.php from
 * topic_section_* ACF fields, given the already-fetched raw field values.
 *
 * @param string $heading
 * @param string $kicker
 * @param string $taxonomy        One of: cryptocurrency, game, category
 * @param mixed  $term_field_value Raw value of the matching topic_section_term_* field (term ID, array, or WP_Term)
 * @return array|null
 */
function bc_topic_section_args_from_term_fields($heading, $kicker, $taxonomy, $term_field_value) {
  if (empty($term_field_value)) return null;

  if ($term_field_value instanceof WP_Term) {
    $term = $term_field_value;
  } elseif (is_array($term_field_value)) {
    $term = get_term($term_field_value['term_id'] ?? 0);
  } elseif (is_numeric($term_field_value)) {
    $term = get_term($term_field_value);
  } else {
    $term = get_term_by('slug', $term_field_value, $taxonomy);
  }

  if (!$term || is_wp_error($term)) return null;

  $review_ids = get_field('featured_reviews', $term) ?: [];
  $rows       = array_map(fn($id) => ['review' => $id, 'affiliate_link' => ''], $review_ids);

  $posts = get_field('featured_posts', $term) ?: [];

  if (empty($posts)) {
    $posts_query = new WP_Query([
      'post_type'      => 'post',
      'post_status'    => 'publish',
      'posts_per_page' => 2,
      'tax_query'      => [[
        'taxonomy' => $term->taxonomy,
        'field'    => 'term_id',
        'terms'    => $term->term_id,
      ]],
    ]);
    $posts = wp_list_pluck($posts_query->posts, 'ID');
  }

  if (empty($rows) && empty($posts)) return null;

  return [
    'heading' => $heading,
    'kicker'  => $kicker,
    'link'    => ['url' => get_term_link($term), 'title' => 'View all', 'target' => ''],
    'rows'    => $rows,
    'posts'   => $posts,
  ];
}

/**
 * Fetch the four raw topic_section_* field values, picking the right
 * topic_section_term_* field based on topic_section_taxonomy.
 *
 * @param callable $get_field_fn fn(string $key) -> mixed — get_field or get_sub_field
 * @return array{heading: string, kicker: string, taxonomy: string, term: mixed}
 */
function bc_get_topic_section_fields($get_field_fn) {
  $taxonomy = $get_field_fn('topic_section_taxonomy');

  $term_field_map = [
    'cryptocurrency' => 'topic_section_term_cryptocurrency',
    'game'           => 'topic_section_term_game',
    'category'       => 'topic_section_term_category',
  ];

  $term_field = $term_field_map[$taxonomy] ?? null;

  return [
    'heading'  => $get_field_fn('topic_section_heading'),
    'kicker'   => $get_field_fn('topic_section_kicker'),
    'taxonomy' => $taxonomy,
    'term'     => $term_field ? $get_field_fn($term_field) : null,
  ];
}

function display_licenses($terms) {
  if (empty($terms)) return;   
  
  $output = '';

    foreach ($terms as $term) {

      // switch($term->name) {
      //   case 'Casinos':
      //     $name = 'Casino';
      //     break;
      //   case 'Sports Betting':
      //     $name = 'Sports'; 
      //     break; 
      //   case 'Esports Betting': 
      //     $name = 'Esports';
      //     break; 
      //   default:
      //     $name = $type->name;
      // } 

      $output .= '<span class="info-pill"><span>' . $term->name . '</span></span>';
    }

    return $output;
}