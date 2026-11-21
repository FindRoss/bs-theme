<?php
/**
* FAQ SCHEMA
*/

add_action('wp_head', 'pageFaqSchema');

function pageFaqSchema() {
  if ( ! ( is_singular() || is_tax() ) ) {
    return;
  }

  // Taxonomy archives need the term passed explicitly (same as content-faqs.php),
  // otherwise ACF can't resolve the field in wp_head.
  $faqs = is_tax() ? get_field('faqs', get_queried_object()) : get_field('faqs');

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
        "name" => wp_strip_all_tags( $faq['question'] ),
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

  $closed = get_field('details_group')['closed'];
  if ($closed) return;

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

/**
* COLLECTION PAGE ITEMLIST
*
* Adds an ItemList (position, name, url only) to Yoast's CollectionPage on
* taxonomy archives. Uses build_taxonomy_main_query() so it matches the visible
* casino listing, and links to the /review/ permalink (never /go/ affiliate URLs).
*/
add_filter('wpseo_schema_webpage', 'taxonomyItemListSchema');

function taxonomyItemListSchema( $data ) {
  if ( ! is_tax() ) {
    return $data;
  }

  $types = (array) ( $data['@type'] ?? array() );
  if ( ! in_array( 'CollectionPage', $types, true ) ) {
    return $data;
  }

  $term = get_queried_object();
  if ( ! $term instanceof WP_Term ) {
    return $data;
  }

  $paged    = max( 1, (int) get_query_var( 'paged' ) );
  $per_page = 5;

  if ( 'bonus_type' === $term->taxonomy ) {
    // Bonus type pages list bonus posts (card-suzhou). Same IDs and page size as the template.
    $per_page = 6;
    $post_ids = array_slice( get_bonus_type_ids( $term ), ( $paged - 1 ) * $per_page, $per_page );
    // card-suzhou skips bonuses with no linked casino, so do the same here.
    $post_ids = array_filter( $post_ids, fn( $id ) => ! empty( get_field( 'single_bonus_casino', $id ) ) );
  } else {
    $query    = build_taxonomy_main_query( $term, $paged );
    $post_ids = array_map( fn( $p ) => is_object( $p ) ? $p->ID : (int) $p, $query->posts );
  }

  $items    = array();
  $position = ( $paged - 1 ) * $per_page;

  foreach ( $post_ids as $post_id ) {
    if ( ! $post_id ) {
      continue;
    }
    // get_permalink() gives the on-site /review/ or /bonus/ page, never the external/affiliate link.
    $items[] = array(
      '@type'    => 'ListItem',
      'position' => ++$position,
      'name'     => html_entity_decode( wp_strip_all_tags( get_the_title( $post_id ) ), ENT_QUOTES, 'UTF-8' ),
      'url'      => get_permalink( $post_id ),
    );
  }

  if ( ! empty( $items ) ) {
    $data['mainEntity'] = array(
      '@type'           => 'ItemList',
      'itemListElement' => $items,
    );
  }

  return $data;
}
