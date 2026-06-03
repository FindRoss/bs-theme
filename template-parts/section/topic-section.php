<?php
$heading        = $args['heading'] ?? '';
$link           = $args['link'] ?? null;
$rows           = array_slice( $args['rows'] ?? [], 0, 4 );
$posts          = $args['posts'] ?? [];
$pill_post_type = $args['pill_post_type'] ?? 'review';
$pill_template  = $args['pill_template'] ?? 'template-parts/card/review-pill';

// Normalise link: accept plain string or array with url/title/target
if ( is_string( $link ) && $link ) {
  $link = [ 'url' => $link, 'title' => 'View all', 'target' => '' ];
}

$aff_link_map = [];
foreach ( $rows as $row ) {
  if ( ! empty( $row['review'] ) ) {
    $aff_link_map[ $row['review'] ] = $row['affiliate_link'] ?? '';
  }
}
$post_ids = array_column( $rows, 'review' );

if ( empty( $post_ids ) && empty( $posts ) ) return;
?>

<section class="topic-section">

  <div class="section-heading">
    <h2 class="section-heading__title h4">
      <?php if ( ! empty( $link['url'] ) ) : ?>
        <a href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ?: '_self' ); ?>">
          <?php echo esc_html( $heading ); ?> <?php echo get_svg_icon( 'chevron-right' ); ?>
        </a>
      <?php else : ?>
        <?php echo esc_html( $heading ); ?>
      <?php endif; ?>
    </h2>
  </div>

  <div class="topic-section__body mt-3">

    <!-- Pills -->
    <?php if ( ! empty( $post_ids ) ) : ?>
      <div class="topic-section__pills">
        <?php
        $pills_query = new WP_Query( [
          'post_type'      => $pill_post_type,
          'post__in'       => $post_ids,
          'orderby'        => 'post__in',
          'posts_per_page' => 4,
        ] );
        $rank = 0;
        while ( $pills_query->have_posts() ) :
          $pills_query->the_post();
          $rank++;
          get_template_part( $pill_template, null, [
            'rank'     => $rank,
            'is_top'   => $rank === 1,
            'aff_link' => $aff_link_map[ get_the_ID() ] ?? '',
          ] );
        endwhile;
        wp_reset_postdata();
        ?>
      </div>
    <?php endif; ?>

    <!-- Articles -->
    <?php if ( ! empty( $posts ) ) : ?>
      <div class="topic-section__articles">
        <?php
        $articles_query = new WP_Query( [
          'post_type'      => 'post',
          'post__in'       => $posts,
          'orderby'        => 'post__in',
          'posts_per_page' => 3,
        ] );
        while ( $articles_query->have_posts() ) :
          $articles_query->the_post();
          get_template_part( 'template-parts/card/card-beijing' );
        endwhile;
        wp_reset_postdata();
        ?>
      </div>
    <?php endif; ?>

  </div>
</section>
