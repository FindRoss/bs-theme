<?php 

function terms_to_box($terms, $title, $with_links = false): string  {
  if (!is_array($terms) || count($terms) === 0) return '';

  // Define a consistent threshold
  $threshold = 10;

  ob_start(); ?>

  <div class="box <?php echo (count($terms) > $threshold) ? 'show-more-list' : ''; ?>">
    <div class="box__content">
      <h3 class="title"><?php echo $title; ?> <?php echo '(' . count($terms) . ')'; ?></h3>
        <ul>
          <?php foreach ($terms as $index => $term): 
              $is_object = is_object($term);
              $term_name = $is_object ? $term->name : $term;
              $icon      = $is_object ? get_field('icon', $term) : null;
              $term_link = $is_object ? get_term_link($term) : null;

              // Determine li classes
              $li_classes = [];
              if ($index >= $threshold) {
                  $li_classes[] = 'list-item-hidden';
              }
            ?>

              <li class="<?php echo esc_attr(implode(' ', $li_classes)); ?>">
                <?php if ($with_links && $term_link): ?>
                  <a href="<?php echo esc_url($term_link); ?>">
                <?php endif; ?>
                <?php if (!empty($icon['sizes']['site-small-logo'])): ?>
                  <img 
                    src="<?php echo esc_url($icon['sizes']['site-small-logo']); ?>" 
                    width="50" 
                    height="50" 
                    alt="<?php echo esc_attr($icon['alt'] ?? $term_name); ?>"
                  >
                <?php endif; ?>
                  <?php echo esc_html($term_name); ?>
                <?php if ($with_links && $term_link): ?>
                  </a>
                <?php endif; ?>
              </li>
          <?php endforeach; ?>
      </ul>

    </div><!-- .box__content -->

    <?php if (count($terms) > $threshold) { ?>

      <div class="box__footer">
        <!-- <button id="expand-review-list">+</button> -->

        <button class="round-icon" id="expand-review-list"><?php echo get_svg_icon('chevron-down'); ?></button>
      </div>

    <?php } ?>
  </div>
<?php return ob_get_clean();
}


