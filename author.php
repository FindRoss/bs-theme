<?php get_header();

$paged              = get_query_var('paged') ? get_query_var('paged') : 1;

$author             = get_queried_object();
$author_id          = $author->ID;
$author_name        = get_the_author_meta('display_name', $author_id);
$author_description = get_the_author_meta('description', $author_id);
// $author_avatar      = get_avatar_url($author_id, ['size' => 120]);
// $author_posts_url   = get_author_posts_url($author_id);

$query = new WP_Query(array(
  'post_type'  => 'post',
  'paged'      => $paged,
  'author'     => $author_id,
));

?>

<div class="container">

  <h1 class="author-page__heading"><?php echo $author_name; ?></h1>

  <?php if ($author_description) : ?>
    <div class="author-page__bio main--content mb-4"><?php echo wp_kses_post( wpautop( $author_description ) ); ?></div>
  <?php endif; ?>

  <?php if ($query->have_posts()) : ?>

    <section class="author-posts">
      <div class="author-posts__layout">
        <h2 class="author-page__articles-heading">Articles by <?php echo $author_name; ?></h2>
        <?php while ($query->have_posts()) : $query->the_post(); 
          get_template_part('template-parts/card/card', 'chengdu'); 
        endwhile; ?>
      </div>
    <?php
      get_template_part('template-parts/content/content', 'pagination', [
        'query' => $query
      ]); ?>
    </section>

  <?php else : ?>
    <div>
      <h2 class="h4">There are no articles by this author currently available.</h2>
    </div>
  <?php endif; ?>

</div>

 <!--  -->

<?php get_footer();