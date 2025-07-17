<?php 
// Field from block
$site_field = get_field('site');
$site = (is_array($site_field) && !empty($site_field)) ? $site_field[0] : null;
$type_field = get_field('type');
$type = $type_field ? $type_field : 'post';

$type_output = $type == 'post' ? 'Posts' : 'Bonuses';
$details_group = get_field('details_group', $site );
$site_name = $details_group['name'] ?? '';

// Checks for safety
// It should not show its own post



// if ($site && is_array($site) && !empty($site)) 

	if ($type == 'post') {

		print_r('we are here');

		$query = new WP_Query(array(
			'post_type'      => 'post',
			'posts_per_page' => 5,
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => 'post-review-relationship',
					'value'   => '"' . $site . '"',
					'compare' => 'LIKE',
				),
				array(
					'key'     => 'bonus_expired',
					'value'   => '1',
					'compare' => '!='
				)
			)
		));

	} elseif ($type == 'bonus') {

		$query = new WP_Query(array(
			'post_type'      => 'bonus',
			'posts_per_page' => 5,
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => 'single_bonus_casino',
					'value'   => '"' . $site . '"',
					'compare' => 'LIKE'
				),
				array(
					'key'     => 'bonus_expired',
					'value'   => '1',
					'compare' => '!='
				)
			)
		));

	}; 
	
	?>

    <aside class="site-latest-block">
			<h4 class="site-latest-block__title">Latest <?php echo $site_name; ?> <?php echo $type_output; ?></h4>
			<ul class="site-latest-block__list">
				<?php if ($query->have_posts()) : ?>
					<?php while ($query->have_posts()) : $query->the_post(); ?>
						<li class="site-latest-block__list-item">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</li>
					<?php endwhile; ?>
				<?php endif; ?>
			</ul>
			<?php wp_reset_postdata(); ?>
    </aside>

<!-- } -->
