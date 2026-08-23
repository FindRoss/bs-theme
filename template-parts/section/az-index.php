<?php
/**
 * A-Z Index section
 * Usage: get_template_part('template-parts/section/az-index', null, ['taxonomy' => 'provider']);
 */

$taxonomy = $args['taxonomy'] ?? '';
if ( ! $taxonomy || ! taxonomy_exists( $taxonomy ) ) {
  return;
}

$terms = bs_get_az_index_terms( $taxonomy );
if ( empty( $terms ) ) {
  return;
}

$groups        = bs_group_az_terms_by_letter( $terms );
$ranked        = $terms;
usort( $ranked, fn( $a, $b ) => $b['count'] <=> $a['count'] );

$tax_object    = get_taxonomy( $taxonomy );
$plural_label  = $tax_object ? $tax_object->labels->name : ucfirst( $taxonomy );
$total         = count( $terms );

$alphabet      = array_merge( [ '#' ], range( 'A', 'Z' ) );
$section_id    = 'az-index-' . $taxonomy;
?>

<section id="<?php echo esc_attr( $section_id ); ?>" class="az-index" data-taxonomy="<?php echo esc_attr( $taxonomy ); ?>">

  <div class="az-index__header">
    <div class="az-index__heading-group">
      <h2 class="az-index__title">All <?php echo esc_html( $plural_label ); ?> A&ndash;Z</h2>
      <p class="az-index__subtitle">Every <?php echo esc_html( strtolower( $tax_object->labels->singular_name ?? $taxonomy ) ); ?> we track, with the number of crypto casinos reviewed for each. Search by name or jump to a letter.</p>
    </div>
    <span class="az-index__pill"><?php echo esc_html( $total ); ?> <?php echo esc_html( strtolower( $total === 1 ? ( $tax_object->labels->singular_name ?? $plural_label ) : $plural_label ) ); ?> listed</span>
  </div>

  <div class="az-index__controls">
    <div class="az-index__search-wrap">
      <span class="az-index__search-icon"><?php echo get_svg_icon( 'search' ); ?></span>
      <input
        type="search"
        class="az-index__search"
        placeholder="Search <?php echo esc_attr( strtolower( $plural_label ) ); ?>&hellip;"
        aria-label="Search <?php echo esc_attr( strtolower( $plural_label ) ); ?>"
      >
    </div>
    <div class="az-index__sort" role="group" aria-label="Sort order">
      <button type="button" class="az-index__sort-btn is-active" data-sort="alpha">A&ndash;Z</button>
      <button type="button" class="az-index__sort-btn" data-sort="popular">Most reviewed</button>
    </div>
  </div>

  <nav class="az-index__letter-nav" aria-label="Jump to letter">
    <?php foreach ( $alphabet as $letter ) :
      $anchor_id = 'az-' . $taxonomy . '-' . strtolower( $letter === '#' ? 'num' : $letter );
      $has_terms = ! empty( $groups[ $letter ] );
    ?>
      <?php if ( $has_terms ) : ?>
        <a href="#<?php echo esc_attr( $anchor_id ); ?>" class="az-index__letter" data-letter="<?php echo esc_attr( $letter ); ?>"><?php echo esc_html( $letter === '#' ? '#' : $letter ); ?></a>
      <?php else : ?>
        <span class="az-index__letter is-disabled" data-letter="<?php echo esc_attr( $letter ); ?>"><?php echo esc_html( $letter === '#' ? '#' : $letter ); ?></span>
      <?php endif; ?>
    <?php endforeach; ?>
  </nav>

  <div class="az-index__view az-index__view--alpha">
    <?php foreach ( $groups as $letter => $group_terms ) :
      $anchor_id = 'az-' . $taxonomy . '-' . strtolower( $letter === '#' ? 'num' : $letter );
    ?>
      <div class="az-index__group" id="<?php echo esc_attr( $anchor_id ); ?>">
        <div class="az-index__group-letter"><?php echo $letter === '#' ? '0&ndash;9' : esc_html( $letter ); ?></div>
        <div class="az-index__group-items">
          <?php foreach ( $group_terms as $term ) : ?>
            <a href="<?php echo esc_url( $term['link'] ); ?>" class="az-index__item" data-name="<?php echo esc_attr( strtolower( $term['name'] ) ); ?>">
              <span class="az-index__item-name"><?php echo esc_html( $term['name'] ); ?></span>
              <span class="az-index__item-count"><?php echo esc_html( $term['count'] ); ?> reviews</span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="az-index__view az-index__view--popular" hidden>
    <div class="az-index__group-items az-index__group-items--ranked">
      <?php foreach ( $ranked as $index => $term ) : ?>
        <a href="<?php echo esc_url( $term['link'] ); ?>" class="az-index__item" data-name="<?php echo esc_attr( strtolower( $term['name'] ) ); ?>">
          <span class="az-index__item-rank"><?php echo esc_html( $index + 1 ); ?></span>
          <span class="az-index__item-name"><?php echo esc_html( $term['name'] ); ?></span>
          <span class="az-index__item-count"><?php echo esc_html( $term['count'] ); ?> reviews</span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="az-index__empty" hidden>
    <p>No <?php echo esc_html( strtolower( $plural_label ) ); ?> match &ldquo;<span class="az-index__empty-query"></span>&rdquo;.</p>
    <a href="#<?php echo esc_attr( $section_id ); ?>" class="az-index__clear-search">Clear search</a>
  </div>

  <script type="application/ld+json">
    <?php echo wp_json_encode( [
      '@context'        => 'https://schema.org',
      '@type'           => 'ItemList',
      'itemListElement' => array_map( fn( $term, $index ) => [
        '@type'    => 'ListItem',
        'position' => $index + 1,
        'name'     => $term['name'],
        'url'      => $term['link'],
      ], $terms, array_keys( $terms ) ),
    ] ); ?>
  </script>

</section>
