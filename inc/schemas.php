<?php
/**
* FAQ SCHEMA
*/

add_action('wp_head', 'productFaqSchema');

function productFaqSchema() {
  if ( ! ( is_singular() || is_tax() ) ) {
    return;
  }

  $faqs = get_field('faqs');

  if ( ! is_array( $faqs ) || empty( $faqs ) ) {
    return;
  }

  $schema = array(
    "@context" => "https://schema.org",
    "@type" => "FAQPage",
    "mainEntity" => array()
  );

  foreach( $faqs as $faq ) {
    if ( ! empty( $faq['question'] ) && ! empty( $faq['answer'] ) ) {
      $faq_item = array(
        "@type" => "Question",
        "name" => $faq['question'],
        "acceptedAnswer" => array(
          "@type" => "Answer",
          "text" => wp_strip_all_tags( $faq['answer'] )
        )
      );
      $schema['mainEntity'][] = $faq_item;
    }
  }

  if ( ! empty( $schema['mainEntity'] ) ) {
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>';
  }
}

/**
* REVIEW FAQ SCHEMA
*/
add_action('wp_head', 'reviewFaqSchema');

function reviewFaqSchema() {
  if ( ! ( is_single() && get_post_type() === 'review' && get_field('review_faqs') ) ) {
    return;
  }

  $schema = array(
    "@context" => "https://schema.org",
    "@type" => "FAQPage",
    "mainEntity" => array()
  );

  $faqs = get_review_faqs( get_the_ID() );

  foreach( $faqs as $faq ) {
    if ( ! empty( $faq['question'] ) && ! empty( $faq['answer'] ) ) {
      $faq_item = array(
        "@type" => "Question",
        "name" => $faq['question'],
        "acceptedAnswer" => array(
          "@type" => "Answer",
          "text" => wp_strip_all_tags( $faq['answer'] )
        )
      );
      $schema['mainEntity'][] = $faq_item;
    }
  }

  if ( ! empty( $schema['mainEntity'] ) ) {
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>';
  }
}