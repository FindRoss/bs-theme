<?php /* Template Name: Taxonomy Index */ ?>
<?php get_header(); ?>

<?php 
  // Country flags: https://www.figma.com/community/file/1295802738363022628

  $page_id = get_queried_object_id();

  $taxonomy_name = ''; 
  
  if (is_page_template('templates/taxonomy-index.php')) {
    if (is_page(95880)) $taxonomy_name = 'game'; 
    else if (is_page(95861)) $taxonomy_name = 'cryptocurrency'; 
    else if (is_page(95867)) $taxonomy_name = 'provider';
    else if (is_page(95863)) $taxonomy_name = 'country';
    else if (is_page(95859)) $taxonomy_name = 'payment';
  };
    

  // Will have to use an ACF text field for this
  // $taxonomy_name = get_the_title()

  if ($taxonomy_name) {
    $terms = get_terms([
      'taxonomy'   => $taxonomy_name,
      'hide_empty' => true,
      'orderby'    => 'count',
      'order'      => 'DESC',  
      'number'     => 24,
    ]);
  }


  // Get the current page ID
  $page_id = get_queried_object_id();

  // Retrieve the content of the current page
  $page_content = get_post_field('post_content', $page_id);

  // Retrieve the introduction of the current page
  $introduction = get_field('introduction');
?>

<?php get_template_part('template-parts/breadcrumbs/breadcrumbs'); ?>

<div class="container pt-4 pb-5">

  <h1><?php the_title(); ?></h1>

  <?php if ($introduction) { ?>
    <div class="main--content" style="max-width: 85ch;">
      <?php echo $introduction; ?>
    </div>
  <?php } ?>

  <?php if ($terms) : ?>
    <section class="angus-section mt-4">
      <div class="layout">

      <?php foreach($terms as $key => $term) { 
          include locate_template('template-parts/card/card-chongqing.php');
        }; ?>

      </div>
    </section>
  <?php endif; ?>

  <?php if (!empty($page_content)) { ?>
    <div class="main--content"  style="max-width: 85ch;">
      <?php echo apply_filters('the_content', $page_content); ?>
    </div>
  <?php } ?>

</div><!-- .container -->

<?php get_footer(); ?>