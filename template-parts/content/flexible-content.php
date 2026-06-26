<?php
/**
 * Flexible Content Renderer
 *
 * Renders flexible content field for posts, pages, or terms.
 * Pass 'post_id' and 'type' in $args:
 * - type: 'page' (for posts/pages) or 'term' (for taxonomy terms)
 * - post_id: The post ID or term ID
 */

$post_id = $args['post_id'] ?? null;
$type = $args['type'] ?? 'page';

// Determine the context for ACF field retrieval
$acf_context = ($type === 'term') ? get_term($post_id) : $post_id;

if (!$acf_context) return;

if (!have_rows('flexible_content', $acf_context)) return;
?>

<section class="main--content">

<hr>

<?php while (have_rows('flexible_content', $acf_context)) : the_row(); ?>

  <?php if (get_row_layout() === 'heading') : ?>
    <?php
      $heading_text  = get_sub_field('heading');
      $heading_level = get_sub_field('heading_level') ?: 'h2';
    ?>
    <?php if ($heading_text) : ?>
      <<?php echo esc_attr($heading_level); ?>><?php echo esc_html($heading_text); ?></<?php echo esc_attr($heading_level); ?>>
    <?php endif; ?>
  <?php endif; ?>

  <?php if (get_row_layout() === 'content') : ?>
    <?php echo wp_kses_post(get_sub_field('content')); ?>
  <?php endif; ?>

  <?php if (get_row_layout() === 'pros_and_cons') : ?>
    <?php
      $pac_pros = get_sub_field('pac_pros') ?: [];
      $pac_cons = get_sub_field('pac_cons') ?: [];
    ?>
    <?php get_template_part('template-parts/content/content', 'pros-and-cons', array(
      'pac_pros' => $pac_pros,
      'pac_cons' => $pac_cons,
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

  <?php if (get_row_layout() === 'content_list') : ?>
    <?php
      $list_repeater = get_sub_field('bc_list') ?: [];
      $list_type     = get_sub_field('bc_list_type') ?: 'arrow';
    ?>
    <?php get_template_part('template-parts/content/content', 'list', array(
      'list_repeater' => $list_repeater,
      'list_type'     => $list_type,
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

  <?php if (get_row_layout() === 'review_info') : ?>
    <?php get_template_part('template-parts/review/review-info', null, [
      'review_id'        => get_sub_field('review_info'),
      'review_info_type' => get_sub_field('review_info_type') ?? 0,
    ]); ?>
  <?php endif; ?>

  <?php if (get_row_layout() === 'review_pros_cons') : ?>
    <?php get_template_part('template-parts/review/review-pros-cons', null, [
      'review_id' => get_sub_field('pros_cons_review'),
    ]); ?>
  <?php endif; ?>

  <?php if (get_row_layout() === 'review_cta') : ?>
    <?php get_template_part('template-parts/review/review-cta', null, [
      'review_id' => get_sub_field('review'),
    ]); ?>
  <?php endif; ?>

  <?php if (get_row_layout() === 'review_bonus') : ?>
    <?php get_template_part('template-parts/review/review-bonus', null, [
      'review_ids'        => get_sub_field('review_bonus') ?: [],
      'review_bonus_type' => get_sub_field('review_bonus_type') ?? 0,
    ]); ?>
  <?php endif; ?>

<?php endwhile; ?>

</section>