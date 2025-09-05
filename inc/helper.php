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


function truncate_text($text, $max_length = 100) {
  if (strlen($text) > $max_length) {
    return substr($text, 0, $max_length) . '...';
  }
  return $text;
};
