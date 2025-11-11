<?php get_header();

$author             = get_queried_object();
$author_id          = $author->ID;
$author_name        = get_the_author_meta('display_name', $author_id);
$author_description = get_the_author_meta('description', $author_id);
// $author_avatar      = get_avatar_url($author_id, ['size' => 120]);
// $author_posts_url   = get_author_posts_url($author_id);

?>

<div class="container">

  <h1><?php echo $author_name; ?></h1>
  <div class="fs-large"><?php echo $author_description; ?></div>
  
  <?php if (have_posts()) : ?>

    <section class="author-posts mt-5">
      <div class="author-posts__layout">
        <?php while (have_posts()) : the_post(); 
          get_template_part('template-parts/card/card', 'chengdu'); 
        endwhile; ?>
      </div>

    <?php
      global $wp_query;
      get_template_part('template-parts/content/content', 'pagination', [
        'query' => $wp_query
      ]); ?>
    </section>
  <?php endif; ?>

</div>

 <!--  -->

<?php get_footer();