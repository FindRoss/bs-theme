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