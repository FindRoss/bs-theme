<?php
/**
 * Data source for the US Map block.
 *
 * !! PLACEHOLDER DATA !!
 * The 'status' values below are dummy placeholders so the map has something
 * to render and can be visually tested. They are NOT researched and must not
 * be treated as real information. Replace each 'status' value in
 * bs_theme_us_map_states() with sourced data before this is used on a live page.
 */

/**
 * The 3 colour-coded rules/categories used by the map + legend.
 * Colours are set in blocks/us-map/us-map-main.css, keyed by these same slugs.
 * Rename the keys/labels to whatever the real 3 rules should be.
 */
function bs_theme_us_map_statuses() {
  return array(
    'status-a' => __( 'Legal', 'bs-theme' ),
    'status-b' => __( 'Unregulated / Partial', 'bs-theme' ),
    'status-c' => __( 'Illegal', 'bs-theme' ),
  );
}

/**
 * Per-state data: status must be one of the keys from bs_theme_us_map_statuses().
 * States left out of this array fall back to a neutral "no data" colour.
 *
 * url  - set automatically below when a matching child term exists under the
 *        "united-states" country term; leave unset here, don't hardcode it.
 * note - optional, shown in the hover/focus tooltip under the state name.
 */
function bs_theme_us_map_states() {
  $states = array(
    // Illegal / No Commercial Online Betting (Status C)
    'AL' => array( 'name' => 'Alabama', 'status' => 'status-c', 'note' => 'No online commercial betting.' ),
    'AK' => array( 'name' => 'Alaska', 'status' => 'status-c', 'note' => 'No online commercial betting.' ),
    'CA' => array( 'name' => 'California', 'status' => 'status-c', 'note' => 'Sweepstakes banned in 2026; no regulated online casinos or sportsbooks.' ),
    'GA' => array( 'name' => 'Georgia', 'status' => 'status-c', 'note' => 'No online commercial betting.' ),
    'HI' => array( 'name' => 'Hawaii', 'status' => 'status-c', 'note' => 'All forms of gambling are illegal.' ),
    'ID' => array( 'name' => 'Idaho', 'status' => 'status-c', 'note' => 'No online commercial betting.' ),
    'MN' => array( 'name' => 'Minnesota', 'status' => 'status-c', 'note' => 'No online commercial betting.' ),
    'MS' => array( 'name' => 'Mississippi', 'status' => 'status-c', 'note' => 'In-person sports betting only; no statewide online betting.' ),
    'MO' => array( 'name' => 'Missouri', 'status' => 'status-c', 'note' => 'No online commercial betting.' ),
    'MT' => array( 'name' => 'Montana', 'status' => 'status-c', 'note' => 'In-person retail sports betting only.' ),
    'NE' => array( 'name' => 'Nebraska', 'status' => 'status-c', 'note' => 'In-person retail sports betting only.' ),
    'NM' => array( 'name' => 'New Mexico', 'status' => 'status-c', 'note' => 'No regulated online commercial betting.' ),
    'ND' => array( 'name' => 'North Dakota', 'status' => 'status-c', 'note' => 'In-person retail sports betting only.' ),
    'OK' => array( 'name' => 'Oklahoma', 'status' => 'status-c', 'note' => 'No online commercial betting.' ),
    'SC' => array( 'name' => 'South Carolina', 'status' => 'status-c', 'note' => 'No online commercial betting.' ),
    'SD' => array( 'name' => 'South Dakota', 'status' => 'status-c', 'note' => 'In-person retail sports betting only.' ),
    'TX' => array( 'name' => 'Texas', 'status' => 'status-c', 'note' => 'No online commercial betting.' ),
    'UT' => array( 'name' => 'Utah', 'status' => 'status-c', 'note' => 'All forms of gambling are illegal.' ),
    'WA' => array( 'name' => 'Washington', 'status' => 'status-c', 'note' => 'In-person retail sports betting only; strict bans on online gaming.' ),
    'WI' => array( 'name' => 'Wisconsin', 'status' => 'status-c', 'note' => 'In-person retail sports betting only.' ),

    // Legal (Fully Regulated Online Casinos & Sports Betting) (Status A)
    'CT' => array( 'name' => 'Connecticut', 'status' => 'status-a', 'note' => 'Fully regulated online casinos and sports betting.' ),
    'DE' => array( 'name' => 'Delaware', 'status' => 'status-a', 'note' => 'Fully regulated online casinos and sports betting.' ),
    'MI' => array( 'name' => 'Michigan', 'status' => 'status-a', 'note' => 'Fully regulated online casinos and sports betting.' ),
    'NJ' => array( 'name' => 'New Jersey', 'status' => 'status-a', 'note' => 'Fully regulated online casinos and sports betting.' ),
    'PA' => array( 'name' => 'Pennsylvania', 'status' => 'status-a', 'note' => 'Fully regulated online casinos and sports betting.' ),
    'RI' => array( 'name' => 'Rhode Island', 'status' => 'status-a', 'note' => 'Fully regulated online casinos and sports betting.' ),
    'WV' => array( 'name' => 'West Virginia', 'status' => 'status-a', 'note' => 'Fully regulated online casinos and sports betting.' ),

    // Unregulated / Partial / Sports Only (Status B)
    'AZ' => array( 'name' => 'Arizona', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'AR' => array( 'name' => 'Arkansas', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'CO' => array( 'name' => 'Colorado', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'DC' => array( 'name' => 'District of Columbia', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'FL' => array( 'name' => 'Florida', 'status' => 'status-b', 'note' => 'Online sports betting legal (Hard Rock Bet monopoly); online casinos illegal.' ),
    'IL' => array( 'name' => 'Illinois', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'IN' => array( 'name' => 'Indiana', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'IA' => array( 'name' => 'Iowa', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'KS' => array( 'name' => 'Kansas', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'KY' => array( 'name' => 'Kentucky', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'LA' => array( 'name' => 'Louisiana', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'ME' => array( 'name' => 'Maine', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos pending/illegal.' ),
    'MD' => array( 'name' => 'Maryland', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'MA' => array( 'name' => 'Massachusetts', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'NV' => array( 'name' => 'Nevada', 'status' => 'status-b', 'note' => 'Online sports betting & poker legal; real-money online slots/casino banned.' ),
    'NH' => array( 'name' => 'New Hampshire', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'NY' => array( 'name' => 'New York', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'NC' => array( 'name' => 'North Carolina', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'OH' => array( 'name' => 'Ohio', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'OR' => array( 'name' => 'Oregon', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'TN' => array( 'name' => 'Tennessee', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'VT' => array( 'name' => 'Vermont', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'VA' => array( 'name' => 'Virginia', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
    'WY' => array( 'name' => 'Wyoming', 'status' => 'status-b', 'note' => 'Online sports betting legal; online casinos illegal.' ),
  );

  // Link a state to its page automatically once that state exists as a
  // child term of "united-states" in the country taxonomy - no manual
  // per-state URL to maintain as more states get added in wp-admin.
  $us_term = get_term_by( 'slug', 'united-states', 'country' );
  if ( ! $us_term || is_wp_error( $us_term ) ) return $states;

  $children = get_terms( array(
    'taxonomy'   => 'country',
    'parent'     => $us_term->term_id,
    'hide_empty' => false,
  ) );
  if ( is_wp_error( $children ) ) return $states;

  $child_by_slug = array();
  foreach ( $children as $child ) {
    $child_by_slug[ $child->slug ] = $child;
  }

  foreach ( $states as $code => &$state ) {
    $slug = sanitize_title( $state['name'] );
    if ( isset( $child_by_slug[ $slug ] ) ) {
      $state['url'] = get_term_link( $child_by_slug[ $slug ] );
    }
  }
  unset( $state );

  return $states;
}

/**
 * True when $term is the "united-states" country term, or any descendant of
 * it at any depth (a state, or a city under a state, etc).
 */
function bs_theme_is_us_map_term( $term ) {
  if ( ! $term || $term->taxonomy !== 'country' ) return false;

  $us_term = get_term_by( 'slug', 'united-states', 'country' );
  if ( ! $us_term || is_wp_error( $us_term ) ) return false;

  if ( (int) $term->term_id === (int) $us_term->term_id ) return true;

  return in_array( $us_term->term_id, get_ancestors( $term->term_id, 'country', 'taxonomy' ), true );
}
