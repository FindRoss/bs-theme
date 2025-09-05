<?php 
$term_logo = get_field('icon', $term);  
if (is_array($term_logo) && isset($term_logo['sizes']['thumbnail'])) {
  $term_logo_thumbnail = $term_logo['sizes']['thumbnail'];
} else {
  // Handle the case where $term_logo is not an array or doesn't have the expected structure
  $term_logo_thumbnail = null; // or provide a default value or an error message
}
?>

<div class="tax-pill ">
  <?php if ($term_logo) : ?>
    <div class="tax-pill__media">
      <img src="<?php echo $term_logo_thumbnail; ?>" width="45" height="45" alt="<?php $term->name . ' icon'; ?>" aria-hidden="true">
    </div>
  <?php endif; ?>
  <div class="tax-pill__content">
    <h3 class="h6 m-0">
      <a class="tax-pill__link" href="<?php echo get_term_link($term->term_id); ?>">
        <?php echo $term->name; ?>
      </a>
    </h3>
  </div>
</div>