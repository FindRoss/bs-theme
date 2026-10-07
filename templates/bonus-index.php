<?php 
/* 
Template Name: Bonus Index
Template Post Type: page
*/ 
?>

<?php get_header(); ?>
<div class="pb-5">

  <div class="container">
    <h1 class="mt-4">Bonuses</h1>
    <div class="main--content">
      <?php $introduction = get_field('introduction'); ?>
      <?php echo $introduction; ?>
    </div>
  </div><!-- .container --> 

  <?php
  $bonus_types = bs_get_bonus_types();
  ?>

  <div class="container mt-5">
    <?php get_template_part('template-parts/section/bonus-type-links'); ?>
  </div>

  <?php foreach ($bonus_types as $type) :
    $args = array(
      'post_type' => 'bonus',
      'posts_per_page' => 3,
      'tax_query' => array(
        array(
          'taxonomy' => 'bonus_type',
          'field'    => 'id',
          'terms'    => $type['id']
        ),
      ),
    );
    $bonus_query = new WP_Query($args);
    if ( ! $bonus_query->have_posts() ) { wp_reset_postdata(); continue; }
  ?>
    <div class="container mt-5 pt-4">
      <section>
        <div class="sec-head">
          <div class="sec-head__l">
            <span class="sec-head__bar"></span>
            <div class="sec-head__titles">
              <?php if (!empty($type['kicker'])) : ?><span class="sec-head__kicker"><?php echo esc_html($type['kicker']); ?></span><?php endif; ?>
              <h2 class="sec-head__title"><?php echo esc_html($type['title']); ?> Bonuses</h2>
            </div>
          </div>
          <a class="sec-head__link" href="<?php echo esc_url($type['permalink']); ?>">
            <span>View all</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
          </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
          <?php while ($bonus_query->have_posts()) : $bonus_query->the_post(); ?>
            <?php get_template_part('template-parts/card/card', 'shanghai'); ?>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </section>
    </div>
  <?php endforeach; ?>

    <!-- Main content -->
    <div class="container mt-5">
      <div class="row main--content">
        <div class="col-12 col-lg-8">
          <?php the_content(); ?>
          <!-- FAQS -->
          <?php get_template_part( 'template-parts/content/content-faqs' ); ?>
        </div><!-- .col --> 
      </div>
    </div>

    


</div><!-- padding --> 
<?php get_footer(); ?>