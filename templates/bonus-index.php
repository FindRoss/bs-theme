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
  $bonus_types = array(
    array(
      'id' => 25693,
      'title' => 'Bitcoin',
      'permalink' => site_url('/bonuses/bitcoin/')
    ),
    array(
      'id' => 25488,
      'title' => 'Welcome',
      'permalink' => site_url('/bonuses/welcome/')
    ),
    array(
      'id' => 25491,
      'title' => 'No Deposit',
      'permalink' => site_url('/bonuses/no-deposit/')
    ),
    array(
      'id' => 25490,
      'title' => 'Wager-Free',
      'permalink' => site_url('/bonuses/wager-free/')
    ),
    array(
      'id' => 25489,
      'title' => 'Cashback',
      'permalink' => site_url('/bonuses/cashback/')
    ),
    array(
      'id' => 25486,
      'title' => 'Free Spins',
      'permalink' => site_url('/bonuses/free-spins/')
    ),
    array(
      'id' => 25501,
      'title' => 'Crypto',
      'permalink' => site_url('/bonuses/crypto/')
    ),
    array(
      'id' => 25487,
      'title' => 'Deposit',
      'permalink' => site_url('/bonuses/deposit/')
    ),
    array(
      'id' => 25496,
      'title' => 'Reload',
      'permalink' => site_url('/bonuses/reload/')
    ),
    array(
      'id' => 25494,
      'title' => 'Sports Betting',
      'permalink' => site_url('/bonuses/sports/')
    ),
    array(
      'id' => 25494,
      'title' => 'Esports Betting',
      'permalink' => site_url('/bonuses/esports/')
    ),
    array(
      'id' => 25492,
      'title' => 'VIP',
      'permalink' => site_url('/bonuses/vip/')
    )
  );
  ?>

  <div class="container mt-5">
    <section>
      <div class="sec-head">
        <div class="sec-head__l">
          <span class="sec-head__bar"></span>
          <div class="sec-head__titles">
            <h2 class="sec-head__title">Browse All Bonus Types</h2>
          </div>
        </div>
      </div>
      <div class="bonus-type-links mt-4">
        <?php foreach ($bonus_types as $type) :
          $term  = get_term($type['id'], 'bonus_type');
          $icon  = $term ? get_field('icon', $term) : null;
          $count = $term ? (int) $term->count : 0;
        ?>
          <a class="bonus-type-links__item" href="<?php echo esc_url($type['permalink']); ?>">
            <div class="bonus-type-links__top">
              <?php if ($icon && is_array($icon)) : ?>
                <div class="bonus-type-links__icon-wrap">
                  <img class="bonus-type-links__icon" src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt'] ?: $type['title']); ?>" width="28" height="28">
                </div>
              <?php endif; ?>
              <svg class="bonus-type-links__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
            </div>
            <div class="bonus-type-links__body">
              <span class="bonus-type-links__label"><?php echo esc_html($type['title']); ?> Bonuses</span>
              <?php if ($count) : ?>
                <span class="bonus-type-links__count"><?php echo $count; ?> bonuses</span>
              <?php endif; ?>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </section>
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
    <div class="container mt-5">
      <section>
        <div class="sec-head">
          <div class="sec-head__l">
            <span class="sec-head__bar"></span>
            <div class="sec-head__titles">
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