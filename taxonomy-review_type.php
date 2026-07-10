<?php get_header();  


$term = get_queried_object(); 
$term_id  = $term->term_id; 
$taxonomy = $term->taxonomy;
$term_name = $term->name;

$icon = get_field('icon', $term);
// Check if the icon is an array
if ($icon && is_array($icon)) {
  // If it's an array, access the URL
  $hasIcon = true;
} else {
  // If it's a string, use it directly
  $hasIcon = false;
}

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$query = build_taxonomy_main_query( $term, $paged );
?>

<?php get_template_part('template-parts/breadcrumbs/breadcrumbs'); ?> 

<div class="container">
  <header class="taxonomy-header">
    <?php $acf_heading = trim((string) get_field('heading', $term)); ?>
    <h1><?php echo $acf_heading !== '' ? esc_html($acf_heading) : 'Crypto ' . esc_html($term_name); ?></h1>

    <?php
      if (term_description()) {
    ?>
      <div class="taxonomy-header__description main--content">
        <?php echo term_description(); ?>
      </div>

    <?php }; ?>

    <?php
    $icon_menu_items = get_field('icon_menu', $term);
    if ($icon_menu_items) :
    ?>
    <div class="taxonomy-header__icon-menu">
      <?php
        $icon_menu_labels = array(
          'sports'      => 'Browse by sport',
          'esports'     => 'Browse by esport',
          'casino'      => 'Browse',
          'sweepstakes' => 'Browse',
        );
        $icon_menu_label = isset($icon_menu_labels[$term->slug]) ? $icon_menu_labels[$term->slug] : 'Browse';
      ?>
      <p class="icon-menu__label"><?php echo esc_html($icon_menu_label); ?></p>
      <nav class="icon-menu" aria-label="<?php echo esc_attr($term_name); ?> categories">
        <?php foreach ($icon_menu_items as $item) :
          $img   = $item['image'];
          $label = $item['text'];
          $url   = $item['link'];
        ?>
          <a href="<?php echo esc_url($url); ?>" class="icon-menu__item">
            <?php if ($img) : ?>
              <img src="<?php echo esc_url($img['sizes']['thumbnail']); ?>"
                   alt="<?php echo esc_attr($label); ?>"
                   width="80" height="80" />
            <?php endif; ?>
            <span><?php echo esc_html($label); ?></span>
          </a>
        <?php endforeach; ?>
      </nav>
    </div>
    <?php endif; ?>
  </header>
</div>

<!-- MAIN QUERY -->
<?php taxonomy_main_query($query, $term); ?>


<!-- MAIN CONTENT -->
<?php if ($paged == 1) : ?>
  <div class="container">
    <section class="aberdeenshire-section">

      <div class="taxonomy-main-content">
        <!-- Flexible Content -->
        <?php get_template_part('template-parts/content/flexible-content', null, [
          'post_id' => $term_id,
          'type'    => 'term',
        ]); ?>

        <?php $main_content = get_field('main_content', $term); ?>

        <div class="main--content">
          <?php if ($main_content) : ?>
            <hr />
            <?php echo $main_content; ?>
          <?php endif; ?>
          <!-- FAQS -->
          <?php if (get_field('faqs', $term)) { get_template_part( 'template-parts/content/content', 'faqs' ); }; ?>
        </div>
      </div>


    </section>

    <?php get_template_part('template-parts/section/latest-posts-review', null, array(
      'exclude' => array()
    )); ?>
  </div>
<?php endif; ?>


 
<?php get_footer();