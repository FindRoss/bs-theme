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
 * Format Date
 */
function formatDate($date) {
  if ($date) {
    // Create a DateTime object from the string with the new format
    $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    
    // Check if the conversion was successful
    if ($dateTime) {
      // Format the date as "j F Y" (e.g., "12 January 2025")
      $formattedDate = $dateTime->format('j F Y');
      
      return $formattedDate;
    } else {
      // Handle invalid input date
      return "Invalid date format";
    }
  }
  // Handle case where no date is provided
  return null;
}

/**
 * Truncate Text
 */
function truncate_text($text, $max_length = 100) {
  if (strlen($text) > $max_length) {
    return substr($text, 0, $max_length) . '...';
  }
  return $text;
};

/**
 * Show Message Banner for Active/Expired Promotions or Bonuses
 */
function show_banner_message($post_id = null) {
  // Fall back to current post if no ID passed
  $post_id = $post_id ?: get_the_ID();

  $expiry_date = get_field('expiry_date', $post_id);
  $promo_marked_as_expired = get_field('bonus_expired', $post_id);

  if (empty($expiry_date) && !$promo_marked_as_expired) return;

  $args = array(); 
  
  if ($expiry_date) {
    $expiry_date_timestamp = DateTime::createFromFormat('Y-m-d H:i:s', $expiry_date)->getTimestamp();
    $expiry_ts_has_passed = ($expiry_date_timestamp < time()) ?? false;
    $args['timestamp'] = $expiry_date_timestamp;

    return get_template_part('template-parts/message/message', $expiry_ts_has_passed ? 'expired' : 'active', $args);
  }  
  
  if ($promo_marked_as_expired) {
     return get_template_part('template-parts/message/message', 'expired', $args);
  }
}

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