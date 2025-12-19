<?php
$review_id = get_field('pros_cons_review');

$pros = get_field('pros', $review_id);
$cons = get_field('cons', $review_id);

if ( $pros || $cons ) : ?>
  <div class="pros-cons">

  <!-- 
  //pros 
  <i data-feather="check"></i>    
  <i data-feather="plus"></i>
  <i data-feather="thumbs-up"></i> 
  
  // cons
  <i data-feather="x"></i>
  <i data-feather="minus"></i>
  <i data-feather="thumbs-down"></i>
  -->


    <?php if ( $pros ) : ?>
      <ul class="pros-cons__list pros-cons__list--pros styled-pros-cons">
        <?php foreach ( $pros as $row ) : ?>
          <?php if ( ! empty( $row['item'] ) ) : ?>
            <li><i data-feather="check-circle"></i> <span class="text"><?php echo esc_html( $row['item'] ); ?></span></li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php if ( $cons ) : ?>
      <ul class="pros-cons__list pros-cons__list--cons styled-pros-cons">
        <?php foreach ( $cons as $row ) : ?>
          <?php if ( ! empty( $row['item'] ) ) : ?>
            <li><i data-feather="x-circle"></i> <span class="text"><?php echo esc_html( $row['item'] ); ?></span></li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

  </div>
<?php endif; ?>
