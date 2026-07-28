<?php
/*
Template Name: About Us
Template Post Type: page
*/
?>

<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article class="about-us">

  <!-- Title + intro -->
  <div class="container">
    <div class="about-us__title">
      <div class="about-us__eyebrow">BitcoinChaser</div>
      <h1 class="main--title"><?php the_title(); ?></h1>
      <div class="about-us__intro main--content">
        <?php the_content(); ?>
      </div>
    </div>
  </div>

  <?php if ( has_post_thumbnail() ) : ?>
    <!-- Featured image -->
    <div class="container">
      <div class="about-us__featured-image">
        <?php the_post_thumbnail( 'large', [ 'alt' => get_the_title() ] ); ?>
      </div>
    </div>
  <?php endif; ?>

  <!-- Mission pillars -->
  <div class="container">
    <div class="about-us__pillars">
      <h2 class="about-us__pillars-heading">Our Core Principles</h2>
      <div class="about-us__pillars-grid">
      <?php
      $about_us_pillars = [
        [
          'icon'  => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 12 2 2 4-4"></path></svg>',
          'title' => 'Independent reviews',
          'body'  => 'No casino pays for a good score. Every review reflects our own testing and editorial judgment.',
        ],
        [
          'icon'  => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
          'title' => 'Player-first research',
          'body'  => "We deposit real funds, cash out real winnings, and read the fine print so you don't have to.",
        ],
        [
          'icon'  => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>',
          'title' => 'Responsible gambling',
          'body'  => 'We flag risk, link to support resources, and never dress up gambling as a way to make money.',
        ],
        [
          'icon'  => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v18"></path><path d="M5 7h14"></path><path d="M5 7 2 13a3 3 0 0 0 6 0L5 7z"></path><path d="M19 7l-3 6a3 3 0 0 0 6 0l-3-6z"></path></svg>',
          'title' => 'Regulatory clarity',
          'body'  => 'Crypto gambling law shifts constantly. We track it market by market so our guidance stays current.',
        ],
        [
          'icon'  => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>',
          'title' => 'Crypto-first commitment',
          'body'  => 'We believe in the long-term future of Bitcoin and digital assets. We evaluate everything through a native crypto lens that prioritizes privacy, speed, and financial autonomy.',
        ],
        [
          'icon'  => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
          'title' => 'Decade of experience',
          'body'  => 'Operating continuously since 2013, we have witnessed every market cycle in crypto history. We cover the space with a grounded, long-term perspective rather than chasing short-term hype.',
        ],
      ];
      ?>
      <?php foreach ( $about_us_pillars as $pillar ) : ?>
        <div class="about-us__pillar">
          <div class="about-us__pillar-icon"><?php echo $pillar['icon']; ?></div>
          <h3 class="about-us__pillar-title"><?php echo esc_html( $pillar['title'] ); ?></h3>
          <p class="about-us__pillar-body"><?php echo esc_html( $pillar['body'] ); ?></p>
        </div>
      <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Stats -->
  <div class="about-us__stats">
    <div class="container">
      <div class="about-us__stats-grid">
        <?php
        $about_us_stats = [
          [ 'value' => '2013', 'label' => 'Founded' ],
          [ 'value' => '3,000+', 'label' => 'Articles published' ],
          [ 'value' => '1,000+', 'label' => 'Casinos reviewed' ],
          [ 'value' => '1,700+', 'label' => 'Bonuses tracked' ],
        ];
        ?>
        <?php foreach ( $about_us_stats as $stat ) : ?>
          <div class="about-us__stat">
            <div class="about-us__stat-value"><?php echo esc_html( $stat['value'] ); ?></div>
            <div class="about-us__stat-label"><?php echo esc_html( $stat['label'] ); ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Contributors -->
  <div class="container">
    <?php $about_us_authors = get_field( 'about_us_authors' ); ?>

    <?php if ( ! empty( $about_us_authors ) ) : ?>
      <div class="about-us__contributors">

        <h2 class="about-us__contributors-heading">Contributors</h2>

        <div class="about-us-authors">
          <?php foreach ( $about_us_authors as $author ) :
            $author_id          = $author->ID;
            $author_name        = get_the_author_meta( 'display_name', $author_id );
            $author_description = get_the_author_meta( 'description', $author_id );
            $author_link        = get_author_posts_url( $author_id );
            $author_avatar      = get_avatar_url( $author_id, [
              'size'    => 96,
              'default' => 'https://bitcoinchaser.com/wp-content/uploads/2026/07/generic-user-image__405x405.webp',
            ] );
          ?>
            <div class="about-us-authors__item">
              <div class="about-us-authors__media">
                <img src="<?php echo esc_url( $author_avatar ); ?>" width="96" height="96" alt="<?php echo esc_attr( $author_name ); ?> profile picture" />
              </div>
              <div class="about-us-authors__content">
                <h3 class="about-us-authors__name">
                  <a href="<?php echo esc_url( $author_link ); ?>"><?php echo esc_html( $author_name ); ?></a>
                </h3>
                <?php if ( $author_description ) : ?>
                  <div class="about-us-authors__bio"><?php echo wp_kses_post( wpautop( $author_description ) ); ?></div>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

      </div>
    <?php endif; ?>
  </div>

</article>

<?php endwhile; endif; ?>
<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>
