<?php 
// Final output for any case
$link_output = "";

if (is_singular('post')) {
  $link_output = get_post_breadcrumbs();
} else if (is_singular('review')) {
  $link_output = get_review_breadcrumbs();
} else if (is_category()) {
  $link_output = get_category_breadcrumbs();
} else if (is_tax( ['cryptocurrency', 'game', 'provider', 'payment', 'country'] )) {
  $link_output = get_taxonomy_breadcrumbs(get_queried_object());
} else if (is_tax('review_type')) { 
  $link_output = get_review_type_breadcrumbs(get_queried_object());
} else if (is_tax('bonus_type')) { 
  $link_output = get_bonus_type_breadcrumbs(get_queried_object());
} else if (is_singular('bonus')) { 
  $link_output = get_bonus_breadcrumbs();
} else if (is_page_template( 'templates/taxonomy-index.php' )) {
  $link_output = get_taxonomy_index_breadcrumbs();
}; ?>


<?php if ($link_output !== "") : ?>
  <nav class="breadcrumbs container" aria-label="Breadcrumb">
    <div class="breadcrumbs__layout">
      <?php echo $link_output; ?>      
    </div>
  </nav>
<?php else : ?>
  <div style="padding-block: 1rem"></div>
<?php endif; ?>