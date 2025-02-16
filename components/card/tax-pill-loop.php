<?php $terms = get_terms( array(
    'taxonomy'   => $tax,
    'hide_empty' => false,
    'orderby'    => 'count',
    'order'      => 'DESC',
    'number'     => 6
  ));
?>

<?php if ($terms) : ?>

    <div class="row mt-3">
      <?php foreach ($terms as $term) { ?>
        <div class="col-12 col-md-6">
          <?php require locate_template('components/card/tax-pill.php'); ?>
        </div>
      <?php } ?>  
    </div>

<?php endif; ?>
<?php wp_reset_postdata(); ?>
