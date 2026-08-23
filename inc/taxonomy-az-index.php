<?php
/**
 * A-Z Index helpers
 * - Powers the "All [Taxonomy] A-Z" directory section on templates/taxonomy-index.php
 * - Reused across any taxonomy (provider, cryptocurrency, ...) via the $taxonomy param
 */

/**
 * Get all terms for a taxonomy, alphabetical, with more than 2 tagged reviews.
 *
 * @return array<int, array{term_id:int, name:string, slug:string, link:string, count:int}>
 */
function bs_get_az_index_terms( string $taxonomy ): array {
  $terms = get_terms([
    'taxonomy'   => $taxonomy,
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
    'number'     => 0,
  ]);

  if ( empty( $terms ) || is_wp_error( $terms ) ) {
    return [];
  }

  $terms = array_filter( $terms, fn( $term ) => $term->count > 2 );

  return array_values( array_map( fn( $term ) => [
    'term_id' => $term->term_id,
    'name'    => $term->name,
    'slug'    => $term->slug,
    'link'    => get_term_link( $term ),
    'count'   => $term->count,
  ], $terms ) );
}

/**
 * Which A-Z bucket a term name falls into.
 * Mirrors the design prototype's bucketing logic: strip a leading "The ",
 * take the first character, group non A-Z under '#'.
 */
function bs_az_bucket_letter( string $name ): string {
  $name   = preg_replace( '/^the\s+/i', '', $name );
  $letter = mb_strtoupper( mb_substr( $name, 0, 1 ) );

  return preg_match( '/^[A-Z]$/', $letter ) ? $letter : '#';
}

/**
 * Group terms into A-Z buckets, dropping any letters with no matches.
 *
 * @param array $terms From bs_get_az_index_terms().
 * @return array<string, array> Keyed by letter ('#', 'A'-'Z'), each value already alphabetical.
 */
function bs_group_az_terms_by_letter( array $terms ): array {
  $groups = [];

  foreach ( $terms as $term ) {
    $letter = bs_az_bucket_letter( $term['name'] );
    $groups[ $letter ][] = $term;
  }

  uksort( $groups, function ( $a, $b ) {
    if ( $a === '#' ) return -1;
    if ( $b === '#' ) return 1;
    return strcmp( $a, $b );
  } );

  return $groups;
}
