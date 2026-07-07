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

/**
* REVIEW RATING SCHEMA
*/
add_action('wp_head', 'reviewRatingSchema');

function reviewRatingSchema() {
  if ( ! ( is_single() && get_post_type() === 'review' ) ) {
    return;
  }

  $review_id = get_the_ID();
  $details_group = get_field('details_group', $review_id) ?: [];
  $name   = $details_group['name'] ?? '';
  $closed = $details_group['closed'] ?? false;

  if ( empty($name) || $closed ) {
    return;
  }

  $trust_score = get_review_trust_score($review_id);
  if ( $trust_score === null ) {
    return;
  }

  $author_id = get_post_field('post_author', $review_id);

  $schema = array(
    "@context" => "https://schema.org",
    "@type" => "Review",
    "itemReviewed" => array(
      "@type" => "Organization",
      "name" => $name,
      "url"  => get_permalink($review_id),
    ),
    "reviewRating" => array(
      "@type" => "Rating",
      "ratingValue" => (string) $trust_score,
      "bestRating"  => "100",
      "worstRating" => "1",
    ),
    "name" => $name . ' Review',
    "author" => array(
      "@type" => "Person",
      "name" => get_the_author_meta('display_name', $author_id),
      "url"  => get_author_posts_url($author_id),
    ),
    "publisher" => array(
      "@type" => "Organization",
      "name" => get_bloginfo('name'),
    ),
    "datePublished" => get_the_date('c', $review_id),
    "dateModified"  => get_the_modified_date('c', $review_id),
  );

  $thumb_url = get_the_post_thumbnail_url($review_id, 'large');
  if ( $thumb_url ) {
    $schema['itemReviewed']['image'] = $thumb_url;
  }

  echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>';
}