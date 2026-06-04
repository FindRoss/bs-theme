<?php
$post_ids = $args['post_ids'] ?? [];
if ( empty( $post_ids ) ) return;

$posts = get_posts( [
  'post_type'      => 'post',
  'post__in'       => $post_ids,
  'orderby'        => 'post__in',
  'posts_per_page' => 5,
] );

if ( empty( $posts ) ) return;

$lead       = array_shift( $posts );
$list_posts = $posts;

$category_label = function( $post ) {
  $cats = get_the_category( $post->ID );
  return ! empty( $cats ) ? $cats[0]->name : '';
};
?>

<section class="editors-pick hp-section">

  <div class="sec-head">
    <div class="sec-head__l">
      <span class="sec-head__bar"></span>
      <div class="sec-head__titles">
        <h2 class="sec-head__title">Editor's Pick</h2>
      </div>
    </div>
  </div>

  <div class="ep">

    <!-- Lead story -->
    <a class="ep-lead" href="<?php echo esc_url( get_permalink( $lead ) ); ?>">
      <?php if ( has_post_thumbnail( $lead ) ) : ?>
        <div class="ep-lead__media">
          <?php echo get_the_post_thumbnail( $lead, 'large', [ 'loading' => 'lazy' ] ); ?>
        </div>
      <?php endif; ?>
      <?php $cat = $category_label( $lead ); if ( $cat ) : ?>
        <span class="ep-lead__cat"><?php echo esc_html( $cat ); ?></span>
      <?php endif; ?>
      <h3 class="ep-lead__title"><?php echo esc_html( get_the_title( $lead ) ); ?></h3>
      <?php $excerpt = get_the_excerpt( $lead ); if ( $excerpt ) : ?>
        <p class="ep-lead__excerpt"><?php echo esc_html( wp_trim_words( $excerpt, 30 ) ); ?></p>
      <?php endif; ?>
      <div class="ep-lead__meta"><?php echo get_the_date( 'F Y', $lead ); ?></div>
    </a>

    <!-- Supporting list -->
    <?php if ( ! empty( $list_posts ) ) : ?>
      <div class="ep-list">
        <?php foreach ( $list_posts as $item ) : ?>
          <a class="ep-item" href="<?php echo esc_url( get_permalink( $item ) ); ?>">
            <?php if ( has_post_thumbnail( $item ) ) : ?>
              <div class="ep-item__thumb">
                <?php echo get_the_post_thumbnail( $item, 'thumbnail', [ 'loading' => 'lazy' ] ); ?>
              </div>
            <?php endif; ?>
            <div>
              <h4 class="ep-item__title"><?php echo esc_html( get_the_title( $item ) ); ?></h4>
              <div class="ep-item__meta">
                <?php $cat = $category_label( $item ); if ( $cat ) echo esc_html( $cat ); ?>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>

</section>
