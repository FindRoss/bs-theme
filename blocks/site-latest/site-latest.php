<?php 
$post_id = get_the_ID();
$site_field = get_field('site');
$site = (is_array($site_field) && !empty($site_field)) ? $site_field[0] : null;
$details_group = get_field('details_group', $site);
$site_name = $details_group['name'] ?? '';

$type = get_field('type');
$type_values = array_column($type, 'value');
$type_keys = array_column($type, 'label');
$type_output = '';

if (is_array($type_keys) && !empty($type_keys)) {
	$length = count($type_keys);
	$type_output = $length > 1 ? 'Articles and Bonuses' : $type_keys[0]; 
}

if ((is_array($type) && !empty($type)) AND $site) {

	$query = new WP_Query(array(
		'post_type'      => $type_values,
		'posts_per_page' => 5,
		'post__not_in'   => array($post_id),
		'meta_query'     => array(
			'relation'   => 'AND',
			array(
				'relation' => 'OR',
				array(
					'key'     => 'post-review-relationship',
					'value'   => '"' . $site . '"',
					'compare' => 'LIKE',
				),
				array(
					'key'     => 'single_bonus_casino',
					'value'   => '"' . $site . '"',
					'compare' => 'LIKE',
				),
			),
			array(
				'key'     => 'bonus_expired',
				'value'   => '1',
				'compare' => '!='
			)
		)
	)); ?>

	<aside class="site-latest-block">
		<h4 class="site-latest-block__title">
			<span class="icon"><i data-feather="arrow-right-circle"></i></span>
			<span class="title">Latest <?php echo $type_output; ?> From <?php echo $site_name; ?></span>
		</h4>
		<ul class="site-latest-block__list">
			<?php if ($query->have_posts()) : ?>
				<?php while ($query->have_posts()) : $query->the_post(); ?>
					<li class="site-latest-block__list-item">
						<a  class="img-link" href="<?php the_permalink(); ?>">
							<div class="item">
            		<img width="45" height="45" src="<?php echo esc_url( get_the_post_thumbnail_url( null, 'thumbnail' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
								<?php the_title(); ?>
							</div>
						</a>
					</li>
				<?php endwhile; ?>
			<?php endif; ?>
		</ul>
	</aside>
	<?php wp_reset_postdata(); ?>
	<?php }; ?>