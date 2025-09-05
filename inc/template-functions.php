<?php 
function terms_to_box($terms, $title, $with_links = false, $current_page_url = ''): string  {

  if (!is_array($terms) || count($terms) === 0) return '';

  // Define a consistent threshold
  $threshold = 4;
  // Dont show count on taxonomy pages
  $show_nums = is_tax() ? false : true;
  // Set variable for tracking if is current page
  $is_active_page = false; 

  ob_start(); ?>

  <div class="box <?php echo (count($terms) > $threshold) ? 'show-more-list' : ''; ?>">
    <div class="box__content">

      <h3 class="title">
        <?php echo $title; ?> 
        <?php if ($show_nums) {  
            '(' . count($terms) . ')'; 
          };
        ?>   
      </h3>
      <ul>
        <?php foreach ($terms as $index => $term):
          $is_object = is_object($term);
          $term_name = $is_object ? $term->name : $term;
          $icon      = $is_object ? get_field('icon', $term) : null;
          $term_link = $is_object ? get_term_link($term) : null;

          // Check if we are on the page already
          $on_current_page = $term_link === $current_page_url;
          
          // Determine li classes
          $li_classes = [];
          if ($index >= $threshold) {
              $li_classes[] = 'list-item-hidden';
          };
          if ($on_current_page) {
            $li_classes[] = 'is-active';
          };
        ?>

          <li class="box-item <?php echo esc_attr(implode(' ', $li_classes)); ?>">
            <?php if (($with_links && $term_link)) : ?>
              <a <?php echo $on_current_page ? '' : 'href="' . esc_url($term_link) . '"'; ?>>
            <?php endif; ?>
            <?php if (!empty($icon['sizes']['thumbnail'])): ?>
              <img
                src="<?php echo esc_url($icon['sizes']['thumbnail']); ?>"
                width="40"
                height="auto"
                alt="<?php echo esc_attr($icon['alt'] ?? $term_name); ?>"
              >
            <?php endif; ?>
              <?php echo esc_html($term_name); ?>
              <?php if ($on_current_page) { ?>
                 <span class="dot">•</span>
              <?php } ?>
            <?php if (($with_links && $term_link)) : ?>
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
    
<?php 
  return ob_get_clean();  
} ?>