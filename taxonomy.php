<?php
  get_header();

  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

  $term      = get_queried_object();
  $term_id   = $term->term_id;
  $taxonomy  = $term->taxonomy;
  $term_name = $term->name;

  $icon    = get_field('icon', $term);
  $hasIcon = $icon && is_array($icon);

  $query = build_taxonomy_main_query( $term, $paged );
  
  $title_output = $term_name . ' Casinos and Gambling Sites';
  if ($taxonomy == 'cryptocurrency') $title_output = 'Top ' . $term_name . ' Casinos of 2026';
  if ($taxonomy == 'payment') $title_output = 'Top Crypto ' . $term_name . ' Casinos of 2026';
  if ($taxonomy == 'provider') $title_output = 'Top ' . $term_name . ' Casinos of 2026';
  if ($taxonomy == 'country') $title_output = 'Bitcoin and Crypto Casinos in ' . $term_name . ' 2026';
  if ($taxonomy == 'license') $title_output = 'Top ' . $term_name . ' Licensed Crypto Casinos of 2026'; 
  if ($taxonomy == 'game') {
  $title_output = $term_name == 'Live Casino'
        ? 'Top ' . $term_name . ' Sites of 2026'
        : 'Top Crypto ' . $term_name . ' Casinos of 2026';
  }
  

?>

<?php get_template_part('template-parts/breadcrumbs/breadcrumbs'); ?> 

<div class="container">
  <header class="taxonomy-header">
    <h1><?php echo esc_html($title_output); ?></h1>

    <?php if (term_description()) { ?>
      <div class="taxonomy-header__description main--content">
        <?php echo term_description(); ?>
      </div>
    <?php }; ?>
  </header>
</div>

<!-- MAIN QUERY -->
<?php taxonomy_main_query($query, $term); ?>

<?php if (have_rows('flexible_content', $term)) : ?>
<div class="container">
  <div class="main--content">
    <?php while (have_rows('flexible_content', $term)) : the_row(); ?>
      <?php if (get_row_layout() === 'content') : ?>
        <?php echo wp_kses_post(get_sub_field('content')); ?>
      <?php endif; ?>

      <?php if (get_row_layout() === 'pros_and_cons') : ?>
        <?php
          $pac_heading = get_sub_field('pac_heading');
          $pac_content = get_sub_field('pac_content');
          $pac_pros    = get_sub_field('pac_pros') ?: [];
          $pac_cons    = get_sub_field('pac_cons') ?: [];
        ?>
        <?php get_template_part('template-parts/content/content', 'pros-and-cons', array(
          'pac_heading' => $pac_heading,
          'pac_content' => $pac_content,
          'pac_pros'    => $pac_pros,
          'pac_cons'    => $pac_cons,
        )); ?>
      <?php endif; ?>

      <?php if (get_row_layout() === 'steps') : ?>
        <?php
          $steps_heading  = get_sub_field('steps_heading');
          $steps_repeater = get_sub_field('steps_repeater') ?: [];
        ?>
        <?php get_template_part('template-parts/content/content', 'steps', array(
          'steps_heading'  => $steps_heading,
          'steps_repeater' => $steps_repeater,
        )); ?>
      <?php endif; ?>

      <?php if (get_row_layout() === 'check_list') : ?>
        <?php
          $check_list_heading  = get_sub_field('check_list_heading');
          $check_list_repeater = get_sub_field('check_list_repeater') ?: [];
          $check_list_layout   = get_sub_field('check_list_layout') ?: 'row';
        ?>
        <?php get_template_part('template-parts/content/content', 'check-list', array(
          'check_list_heading'  => $check_list_heading,
          'check_list_repeater' => $check_list_repeater,
          'check_list_layout'   => $check_list_layout,
        )); ?>
      <?php endif; ?>

      <?php if (get_row_layout() === 'topic_section') : ?>
        <?php
          $ts_fields = bc_get_topic_section_fields('get_sub_field');
          $ts_args   = bc_topic_section_args_from_term_fields(
            $ts_fields['heading'],
            $ts_fields['kicker'],
            $ts_fields['taxonomy'],
            $ts_fields['term']
          );
        ?>
        <?php if ($ts_args) : ?>
          <?php get_template_part('template-parts/section/topic-section', null, $ts_args); ?>
        <?php endif; ?>
      <?php endif; ?>

      <?php if (get_row_layout() === 'bonus_section') : ?>
        <?php
          $bs_term_obj = get_sub_field('bonus_section_type');
          if ($bs_term_obj) :
            $bs_heading = get_sub_field('bonus_section_heading') ?: $bs_term_obj->name . ' Bonuses';
            $bs_kicker  = get_sub_field('bonus_section_kicker') ?: '';
            $bs_link    = get_term_link($bs_term_obj);
        ?>
          <?php get_template_part('template-parts/section/bonus-section', null, [
            'term'    => $bs_term_obj,
            'heading' => $bs_heading,
            'kicker'  => $bs_kicker,
            'link'    => $bs_link,
          ]); ?>
        <?php endif; ?>
      <?php endif; ?>

      <?php if (get_row_layout() === 'post_section') : ?>
        <?php
          $ps_term_raw = get_sub_field('post_section_category');
          if (is_array($ps_term_raw)) $ps_term_raw = reset($ps_term_raw);
          $ps_term_obj = is_object($ps_term_raw) ? $ps_term_raw : (is_numeric($ps_term_raw) ? get_term($ps_term_raw) : null);
          $ps_heading      = get_sub_field('post_section_heading') ?: ($ps_term_obj ? $ps_term_obj->name : '');
          $ps_kicker       = get_sub_field('post_section_kicker') ?: '';
          $ps_manual_posts = get_sub_field('post_section_posts') ?: [];
          $ps_count        = intval(get_sub_field('post_section_count') ?: 4);

          if (!empty($ps_manual_posts)) {
            $ps_posts = $ps_manual_posts;
          } elseif ($ps_term_obj) {
            $ps_featured_ids = get_field('featured_posts', $ps_term_obj) ?: [];
            if (!empty($ps_featured_ids)) {
              $ps_q = new WP_Query([
                'post_type'      => 'post',
                'posts_per_page' => $ps_count,
                'post__in'       => $ps_featured_ids,
                'orderby'        => 'post__in',
              ]);
            } else {
              $ps_q = new WP_Query([
                'post_type'      => 'post',
                'posts_per_page' => $ps_count,
                'cat'            => $ps_term_obj->term_id,
              ]);
            }
            $ps_posts = $ps_q->posts;
            wp_reset_postdata();
          } else {
            $ps_posts = [];
          }

          $ps_link = $ps_term_obj ? get_term_link($ps_term_obj) : '';
        ?>
        <?php if (!empty($ps_posts)) : ?>
          <?php get_template_part('template-parts/section/posts-section', null, [
            'heading' => $ps_heading,
            'kicker'  => $ps_kicker,
            'link'    => $ps_link,
            'posts'   => $ps_posts,
            'count'   => $ps_count,
          ]); ?>
        <?php endif; ?>
      <?php endif; ?>

      <?php if (get_row_layout() === 'image') : ?>
        <?php $image = get_sub_field('image'); ?>
        <?php if ($image) : ?>
          <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" width="<?php echo esc_attr($image['width']); ?>" height="<?php echo esc_attr($image['height']); ?>">
        <?php endif; ?>
      <?php endif; ?>
    <?php endwhile; ?>
  </div>
</div>
<?php endif; ?>

<!--MAIN CONTENT-->
<div class="container">
  <?php if ($paged == 1) : ?>

    <?php $main_content = get_field('main_content', $term); ?>

    
    <section class="grid grid-cols-1 md:grid-cols-12 gap-4">
      <div class="col-span-1 md:col-span-9 main--content">
        <hr>
        <?php echo $main_content; ?>
        <?php if (get_field('faqs', $term)) {
          get_template_part('template-parts/content/content', 'faqs');
        } ?>
      </div>
    </section>

    <?php get_template_part('template-parts/section/latest-posts-review', null, array(
      'exclude' => array()
    )); ?>

  <?php endif; ?>
</div><!-- .container -->

<?php get_footer(); ?>