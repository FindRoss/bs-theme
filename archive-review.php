<?php get_header(); ?>

<?php 
  $query = new WP_Query(array(
    'post_type' => 'review',
    'posts_per_page' => 21, 
  )); 

  $review_filters = array(
    array(
      'tax'          => 'game',
      'display_name' => 'Games',
    ), 
    array(
      'tax'          => 'cryptocurrency',
      'display_name' => 'Cryptocurrency',
    ),
    array(
      'tax'          => 'payment',
      'display_name' => 'Payments',
    ),
    array(
      'tax'          => 'provider',
      'display_name' => 'Providers',
    )
  );
?>

  <section>
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-6">
          <h1 class="display-6">Reviews</h1>
          <p>Discover casino and gambling site reviews including information about bonuses, payments, and games.</p>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-3">
          <!-- Filters -->
          <?php 
            foreach($review_filters as $filter) {

              // Terms
              $terms = get_terms(array(
                'taxonomy'   => $filter['tax'],
                'hide_empty' => true,
                'orderby'    => 'count',
                'order'      => 'DESC'
                )
              ); ?>

              <!-- Toggle  -->
              <button class="terms-main-toggle d-block w-100 text-start fw-light mb-3 fw-b bg-white border-0 border-top border-bottom ff-main py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $filter['tax']; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $filter['tax']; ?>">
                <div class="d-flex w-100 justify-content-between">
                  <span class="h6 m-0"><?php echo $filter['display_name']; ?></span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                  </svg>
                </div>
              </button>
              
              <!-- Collapse -->
              <div class="collapse" id="collapse-<?php echo $filter['tax']; ?>">
                <div class="terms-container py-3" data-tax="<?php echo $filter['tax']; ?>">
                  <?php foreach($terms as $key => $term) { ?>
                    <?php if ($key < 13) { ?>
                    <!-- Select -->
                    <div class="form-check">
                      <input class="form-check-input term-select" type="checkbox" value="<?php echo $term->term_id; ?>" id="checkbox-<?php echo $term->term_id; ?>">
                      <label class="form-check-label ff-main" for="checkbox-<?php $term->term_id; ?>">
                        <?php echo $term->name . ' (' . $term->count . ')'; ?>
                      </label>
                    </div>
                    <?php }; ?>
                  <?php }?>
                </div>
              </div><!-- .collapse -->

          <?php } ?>
        </div>
        <div class="col-12 col-md-9">
          <!-- Query -->
          <?php if ($query->have_posts()) : ?>
            <div class="ff-main bg-cus-light px-3 py-2 rounded-corners" id="displayCount">Showing <strong>124</strong> out of <strong>300</strong> reviews.</div>
            <div class="row" id="review-container">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
              <div class="col-12 col-md-4 mt-3">
                <?php require locate_template('components/card/review-excerpt.php'); ?>  
              </div>
            <?php endwhile; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
      
    </div>
  </section>

<?php get_footer(); ?>