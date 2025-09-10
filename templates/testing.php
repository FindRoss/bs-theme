<?php 
/* 
Template Name: Testing
Template Post Type: page
*/ 
?>

<?php get_header(); ?>

<div class="container py-5">
  <h1>Testing</h1>

<?php 
  $terms_to_use = [
    'cryptocurrency',
    'provider',
    'payment',
    'game',
    'country',
    'review_type',
  ];

  foreach ( $terms_to_use as $taxonomy ) {
    $terms = get_terms([
      'taxonomy'   => $taxonomy,
      'hide_empty' => false, // include all terms
    ]);

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
      foreach ( $terms as $term ) {
        $term_key = $taxonomy . '_' . $term->term_id;

        $heading          = get_field( 'heading', $term_key );
        $faqs_description = get_field( 'faqs_description', $term_key );
        $faqs             = get_field( 'faqs', $term_key );
        $casinos          = get_field( 'casinos', $term_key ); // relationship

        // Only output if at least one of them has a value
        if ( ! empty( $heading ) || ! empty( $faqs_description ) || ! empty( $faqs ) || ! empty( $casinos ) ) {
          $edit_link = get_edit_term_link( $term->term_id, $taxonomy );

          echo '<p><a href="' . esc_url( $edit_link ) . '" target="_blank">'
            . esc_html( $term->name ) . ' (' . esc_html( $taxonomy ) . ')</a>';

          if ( ! empty( $heading ) ) {
            echo ' – Heading: ' . esc_html( $heading );
          }
          if ( ! empty( $faqs_description ) ) {
            echo ' – FAQs Description: ' . esc_html( wp_trim_words( $faqs_description, 15 ) );
          }
          if ( ! empty( $faqs ) && is_array( $faqs ) ) {
            echo ' – FAQs Count: ' . count( $faqs );
          }

          if ( ! empty( $casinos ) && is_array( $casinos ) ) {
            echo ' – Casinos Linked: ' . count( $casinos );
          }

          echo '</p>';
        }
      }
    }
  }
?>

</div><!-- .container --> 

<?php get_footer(); ?>