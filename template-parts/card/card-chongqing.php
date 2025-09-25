 <?php 
    $term_icon = get_field('icon', $term->taxonomy . '_' . $term->term_id); 
    $term_icon_thumb = $term_icon['sizes']['thumbnail'] ?? '';
  ?>
 
 <div class="card-chongqing h-100">
  <a href="<?php echo esc_url(get_term_link($term)); ?>">
    <div class="content">
      <?php echo $term_icon_thumb ? '<img src="' . esc_url($term_icon_thumb) . '" alt="" width="50" height="50" class="">' : ''; ?>
      <h2 class="mt-4 h5"><?php echo $term->name; ?></h2>
      <p><?php echo $term->count; ?> reviews</p>
    </div>
  </a>
</div>