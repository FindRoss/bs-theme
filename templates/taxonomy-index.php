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


<div class="container pt-4 pb-5">

  <h1><?php the_title(); ?></h1>

  <?php if ($introduction) { ?>
    <div class="main--content" style="max-width: 85ch;">
      <?php echo $introduction; ?>
    </div>
  <?php } ?>

  <?php if ($terms) : ?>
    <div class="row">

      <?php foreach($terms as $key => $term) { 

          $term_icon = get_field('icon', $term->taxonomy . '_' . $term->term_id); 
          $term_icon_thumb = $term_icon['sizes']['thumbnail'] ?? '';
        ?>

        <div class="col-6 col-md-4 col-lg-3 mt-4">
          <div class="card h-100">
            <div class="card-body text-center">
              <?php echo $term_icon_thumb ? '<img src="' . esc_url($term_icon_thumb) . '" alt="" width="50" height="50" class="">' : ''; ?>
              <h2 class="mt-4 h5"><?php echo $term->name; ?></h2>
              <p><?php echo $term->count; ?> Reviews</p>
              <a href="<?php echo esc_url(get_term_link($term)); ?>">See all reviews</a>
            </div>
          </div>
        </div>
      <?php }; ?>

    </div><!-- .row -->
  <?php endif; ?>

  <?php if (!empty($page_content)) { ?>
    <div class="main--content"  style="max-width: 85ch;">
      <?php echo apply_filters('the_content', $page_content); ?>
    </div>
  <?php } ?>

</div><!-- .container -->

<?php get_footer(); ?>