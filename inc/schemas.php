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
    
    $faqs = get_review_faqs(get_the_ID());

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