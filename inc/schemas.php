<?php
/**
* FAQ SCHEMA
*/

add_action('wp_head', 'productFaqSchema');

function productFaqSchema() {
	if(get_field('faqs')) { 

    $schema = array(
      "@context" => "https://schema.org",
      "@type" => "FAQPage",
      "mainEntity" => array()
    );

    $faqs = get_field('faqs');

    foreach($faqs as $faq) {

      $faq_item = array (
        "@type" => "Question",
        "name" => $faq['question'],
        "acceptedAnswer" => array(
          "@type" => "Answer",
          "text" => $faq['answer']
        )
      );
        
        $schema['mainEntity'][] = $faq_item;
      };

		echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
  }
};

/**
* REVIEW FAQ SCHEMA
*/
add_action('wp_head', 'reviewFaqSchema');

function reviewFaqSchema() {
	if(is_single() && get_post_type() === 'review' && get_field('review_faqs')) { 

    $schema = array(
      "@context" => "https://schema.org",
      "@type" => "FAQPage",
      "mainEntity" => array()
    );
    
    $name = get_field('details_group', get_the_ID())['name'];

    $review_faqs_col  = get_field('review_faqs'); 
 
    $faq_owner_q    = 'Who is the owner of the ' . $name; 
    $faq_bitcoin_q  = 'Does the ' . $name . ' accept Bitcoin?';
    $faq_legit_q    = 'Is ' . $name . ' legit?';
    $faq_licensed_q = 'Is ' . $name . ' licensed?';

    $faqs = array();
    
    $faqs[] = array(
      'question' => $faq_owner_q,
      'answer'   => $review_faqs_col['owner'],
    );
    
    $faqs[] = array(
      'question' => $faq_bitcoin_q,
      'answer'   => $review_faqs_col['bitcoin'],
    );
    
    $faqs[] = array(
      'question' => $faq_legit_q,
      'answer'   => $review_faqs_col['legit'],
    );
    
    $faqs[] = array(
      'question' => $faq_licensed_q,
      'answer'   => $review_faqs_col['licensed'],
    );

    $empty_fields = true;

    foreach($faqs as $faq) {

      if (!empty($faq['answer'])) {

        $empty_fields = false;

        $faq_item = array (
          "@type" => "Question",
          "name" => $faq['question'],
          "acceptedAnswer" => array(
            "@type" => "Answer",
            "text" => $faq['answer']
          )
        );
          
        $schema['mainEntity'][] = $faq_item;
      };
    };
    
    if (!$empty_fields) {
      echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
    };
  }
};