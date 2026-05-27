<?php get_header(); ?>

<?php
$review_id = get_the_ID();

// Array to fill with content parts
$content = array();
$images = array();

// Post From Same Site Query
$site_posts_query = new WP_Query(
   array(
    'post_type'      => 'post',
    'posts_per_page' => 5,
    'meta_query'     => array(
      array(
        'key'     => 'post-review-relationship',
        'value'   => '"' . $review_id . '"',
        'compare' => 'LIKE'
      ),
    ),
  ),
);

// More Sites Query
$topSites = get_field('sites', 'option');
$filteredTopSites = array_diff($topSites, array($review_id));

$more_sites_args = array(
  'post_type'      => 'review',
  'post__in'       => $filteredTopSites,
  'posts_per_page' => 8,
  'orderby'        => 'post__in'
);
$more_sites = new WP_Query($more_sites_args);


// ACF FIELDS
/* Details Group */
$fields = get_fields();
$details_group = $fields['details_group'];
$name             = $details_group['name'];
$link             = $details_group['affiliate_link'];
$review_thumb_alt = get_post_meta(get_post_thumbnail_id($review_id), '_wp_attachment_image_alt', true) ?: $name . ' logo';
$bonus         = $details_group['bonus'];
$closed        = $details_group['closed']; // nothing or 1



// Bonus Group
$bonus_group = $fields['bonus_group'] ?? null;
$bonus_title = $bonus_group['bonus_title'] ?? null;
$bonus_info  = $bonus_group['bonus'] ?? null;
$bonus_plus  = $bonus_group['bonus_plus'] ?? null;

/* Media Group */
$media        = $fields['media_group'];
$homepageImg  = $media['homepage'];
$theme_color       = $media['theme_color'] ?? null;
$transparent_logo  = $media['transparent_logo'] ?? null;

if ($homepageImg) {
  $homepageImg_url = $homepageImg['sizes']['large'];
  $homepageImg_alt = $homepageImg['alt'];
  $homepageImg_cap = $homepageImg['caption'];
  $homepageImg_name = $homepageImg['name'];
}

if ($homepageImg) $images[] = $homepageImg;


/* Introduction */
$introduction = $fields['introduction'] ?? '';

/* Sign Up */
$sign_up_content = $fields['sign_up'] ?? '';
if ($sign_up_content) $content["How to register on $name"] = $sign_up_content;

/* KYC */
$kyc_content = $fields['kyc'] ?? '';
if ($kyc_content) $content["Verification and KYC requirements at $name"] = $kyc_content;

/* Games Group */
$games_group       = $fields['games_group'];
$games_content     = $games_group['games'];
$providers_content = $games_group['providers'];
if ($games_content) $content["Casino games available at $name"] = $games_content;
if ($providers_content) $content["Software providers at $name"] = $providers_content;

/* Sports Betting */
$betting_content = $fields['betting'] ?? '';
if ($betting_content) $content["Sports betting on $name"] = $betting_content;

/* Poker Group */
$poker_content = $fields['poker'] ?? '';
if ($poker_content) $content['Poker'] = $poker_content;

/* Bonuses */
$bonus_content = $fields['bonuses'] ?? '';
if ($bonus_content) $content["Bonuses and promotions at $name"] = $bonus_content;

/* Payments Group */
$payments_content = $fields['payments'] ?? '';
if ($payments_content) $content["$name payment methods and limits"] = $payments_content;

/* VIP Program */
$vip_content = $fields['vip_program'] ?? '';
if ($vip_content) $content["$name VIP program"] = $vip_content;

/* Support Group */
$support_group    = $fields['support_group'];
$support_content  = $support_group['content'];
if ($support_content) $content["Customer support at $name"] = $support_content;

/* Mobile */
$mobile_content = $fields['mobile'] ?? '';
if ($mobile_content) $content["The $name mobile experience"] = $mobile_content;

/* Conclusion */
$conclusion = $fields['conclusion'] ?? '';
if ($conclusion) $content["Should you play on $name?"] = $conclusion;

// TAXONOMIES
$taxonomies = ['cryptocurrency', 'game', 'provider', 'payment', 'country'];
$all_terms = wp_get_object_terms($review_id, $taxonomies);

if ( !empty($all_terms) && !is_wp_error($all_terms) ) {
  usort($all_terms, function($a, $b) {
      return $b->count <=> $a->count; // DESC
  });
}

$terms_by_tax = [];
foreach ($all_terms as $term) {
  $terms_by_tax[$term->taxonomy][] = $term;
}

// And array of terms by taxonomy: An array of WP_Term Object
$crypto_terms   = $terms_by_tax['cryptocurrency'] ?? [];
$game_terms     = $terms_by_tax['game'] ?? [];
$provider_terms = $terms_by_tax['provider'] ?? [];
$payment_terms  = $terms_by_tax['payment'] ?? [];

// ACF Fields (simple arrays eg Array ( [0] => English [1] => Français [2] => Deutsch [3] => Español [4]);
$languages = $fields['languages'] ?? [];
$support_channels = $support_group['channels'];

// Pros & Cons
$pros = get_field('pros', $review_id) ?: [];
$cons = get_field('cons', $review_id) ?: [];
$has_pros_cons = !empty($pros) || !empty($cons);

// Faqs
$faqs = get_review_faqs($review_id);
$faqs_has_answers = false;

foreach ($faqs as $faq) {
  if (!empty($faq['answer'])) {
    $faqs_has_answers = true;
    break;
  }
};

// Trust score total (for rail CTA display)
$_trust_weights = ['fairness'=>25,'track_record'=>15,'security'=>10,'responsible'=>10,'community'=>15,'customer_service'=>25];
$_trust_sum = 0;
foreach ($_trust_weights as $_k => $_w) {
  $_trust_sum += ((int) get_field("trust_index_{$_k}", $review_id) / 5) * $_w;
}
$trust_total = round($_trust_sum);

// Build Table of Contents
$toc = [];
$toc[] = ['id' => 'section-tabs', 'label' => 'Overview'];
if (has_excerpt()) $toc[] = ['id' => 'section-why', 'label' => "Why play at $name"];
if ($has_pros_cons) $toc[] = ['id' => 'section-pros-cons', 'label' => 'Pros & Cons'];
$toc[] = ['id' => 'section-trust', 'label' => 'Trust Score'];
$toc[] = ['id' => 'section-review', 'label' => 'Review'];
foreach ($content as $key => $value) {
  $toc[] = ['id' => 'section-' . sanitize_title($key), 'label' => $key];
}
if ($faqs_has_answers) $toc[] = ['id' => 'section-faqs', 'label' => 'FAQs'];

?>

<?php get_template_part('template-parts/breadcrumbs/breadcrumbs'); ?>

<div class="container">

  <!-- CLOSED -->
  <?php if ($closed) { ?>
    <section class="section-closed">
      <div>
        <h2>🚩<?php echo $name; ?> is now closed</h2>
        <p>Explore our reviews of <a href="https://bitcoinchaser.com/sites/casino/">popular crypto casinos</a> or <a href="https://bitcoinchaser.com/sites/sports/">sports betting sites</a> you might enjoy.</p>
        <?php if ($more_sites->have_posts()) :
          outputNewSlideHTML(array('query' => $more_sites));
        endif; ?>
      </div>
    </section>
  <?php } ?>

  <!-- Review layout: main content (left) + sticky CTA (right) -->
  <div class="review-layout">

    <div class="review-layout__main">

      <!-- Header -->
      <header class="review-header">
        <div class="review-header__logo"<?php if ($theme_color) echo ' style="background-color: ' . esc_attr($theme_color) . '"'; ?>>
          <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="exclude-lazyload" alt="<?php echo esc_attr($review_thumb_alt); ?>" width="500" height="250" fetchpriority="high">
        </div>
        <div class="review-header__info">
          <h1><?php echo $name; ?> Review</h1>
          <?php get_template_part('template-parts/content/content-author'); ?>
        </div>
        <?php if (!$closed && $link) : ?>
        <aside class="review-header__hero-cta" id="hero-cta">
          <?php if ($bonus_title) : ?>
            <div class="hero-cta__kicker"><?php echo esc_html($bonus_title); ?></div>
          <?php endif; ?>
          <?php if ($bonus_info) : ?>
            <div class="hero-cta__line"><?php echo esc_html($bonus_info); ?><?php echo $bonus_plus ? ' ' . esc_html($bonus_plus) : ''; ?></div>
          <?php endif; ?>
          <a href="<?php echo esc_url($link); ?>" class="button button__primary" target="_blank" rel="sponsored noopener" aria-label="Visit <?php echo esc_attr($name); ?>">Visit <?php echo esc_attr($name); ?></a>
        </aside>
        <?php endif; ?>
      </header>

      <!-- Mobile CTA — shown below header on mobile, hidden on desktop -->
      <?php if (!$closed && $link) { ?>
      <div class="review-layout__cta-mobile">
        <div class="cta-box">
          <?php if ($bonus_title) { ?>
            <p class="cta-box__title"><span><?php echo esc_html($bonus_title); ?></span></p>
          <?php } ?>
          <?php if ($bonus_info || $bonus_plus) { ?>
            <p class="cta-box__offer">
              <?php if ($bonus_info) { ?><span class="cta-box__info"><?php echo esc_html($bonus_info); ?></span><?php } ?>
              <?php if ($bonus_plus) { ?><span class="cta-box__plus"><?php echo esc_html($bonus_plus); ?></span><?php } ?>
            </p>
          <?php } ?>
          <a href="<?php echo esc_url($link); ?>" class="button button__primary" target="_blank" rel="sponsored noopener" aria-label="Visit <?php echo esc_attr($name); ?>">Visit <?php echo esc_attr($name); ?></a>
        </div>
      </div>
      <?php } ?>

      <div id="section-tabs">
        <?php get_template_part('template-parts/review/review-tabs', null, [
          'review_id' => $review_id,
        ]); ?>
      </div>

      <?php if (has_excerpt()) { ?>
      <div class="review-why" id="section-why">
        <h2 class="review-why__title">Why play at <?php echo esc_html($name); ?></h2>
        <p class="review-why__excerpt"><?php echo get_the_excerpt(); ?></p>
      </div>
      <?php } ?>

      <?php if ($has_pros_cons) { ?>
      <div class="review-pros-cons" id="section-pros-cons">
        <?php if (!empty($pros)) { ?>
        <div class="review-pros-cons__col">
          <h3 class="review-pros-cons__title">Pros</h3>
          <ul class="review-pros-cons__list review-pros-cons__list--pros">
            <?php foreach ($pros as $pro) { ?>
              <li><?php echo esc_html($pro['item']); ?></li>
            <?php } ?>
          </ul>
        </div>
        <?php } ?>
        <?php if (!empty($cons)) { ?>
        <div class="review-pros-cons__col">
          <h3 class="review-pros-cons__title">Cons</h3>
          <ul class="review-pros-cons__list review-pros-cons__list--cons">
            <?php foreach ($cons as $con) { ?>
              <li><?php echo esc_html($con['item']); ?></li>
            <?php } ?>
          </ul>
        </div>
        <?php } ?>
      </div>
      <?php } ?>

      <div id="section-trust">
        <?php get_template_part('template-parts/review/review-trust-index', null, [
          'review_id' => $review_id,
        ]); ?>
      </div>

      <?php if ($homepageImg) : ?>
        <figure class="homepage-image">
          <a href="<?php echo esc_url($link); ?>" target="_blank" rel="sponsored noopener" aria-label="<?php echo esc_attr('Visit ' . $name . ($bonus ? ' - ' . $bonus : '')); ?>">
            <img src="<?php echo $homepageImg_url; ?>" alt="<?php echo $homepageImg_alt; ?>" width="1000" height="600" loading="lazy">
          </a>
          <?php if ($homepageImg_cap): ?>
            <figcaption><?php echo $homepageImg_cap; ?></figcaption>
          <?php endif; ?>
        </figure>
      <?php endif; ?>

      <section class="skye-section">
        <main class="skye-section__content">

        <section class="content main--content mt-5" id="section-review">
          <?php if ($introduction) echo '<div class="introduction">' . $introduction . '</div>';
          the_content();
          foreach ($content as $key => $value) { ?>
            <h2 id="<?php echo esc_attr('section-' . sanitize_title($key)); ?>"><?php echo $key; ?></h2>
            <?php echo $value; ?>
          <?php } ?>

        </section>


        <?php if ($faqs_has_answers) { ?>
        <section class="content main--content mt-5" id="section-faqs">
            <h2>FAQs</h2>
            <?php foreach ($faqs as $faq) { ?>
              <?php if ($faq['answer']) : ?>
                <div>
                  <h3><?php echo $faq['question']; ?></h3>
                  <div><?php echo wpautop($faq['answer']); ?></div>
                </div>
              <?php endif; ?>
            <?php } ?>
        </section>
        <?php } ?>


        </main>
      </section>


    </div><!-- .review-layout__main -->

    <!-- Desktop sticky CTA column — hidden on mobile -->
    <aside class="review-layout__cta" id="rail-cta">
      <?php if (!$closed && $link) : ?>
      <div class="rail-cta">
        <div class="rail-cta__name"><?php echo esc_html($name); ?></div>
        <?php if ($bonus_title) : ?>
          <div class="rail-cta__kicker"><?php echo esc_html($bonus_title); ?></div>
        <?php endif; ?>
        <?php if ($bonus_info || $bonus_plus) : ?>
          <div class="rail-cta__line"><?php echo esc_html($bonus_info); ?><?php echo $bonus_plus ? ' ' . esc_html($bonus_plus) : ''; ?></div>
        <?php endif; ?>
        <a href="<?php echo esc_url($link); ?>" class="button button__primary" target="_blank" rel="sponsored noopener" aria-label="Visit <?php echo esc_attr($name); ?>">Visit <?php echo esc_attr($name); ?> &rarr;</a>
        <div class="rail-cta__micro">T&amp;Cs apply</div>
        <?php if ($trust_total > 0) : ?>
        <div class="rail-cta__score">
          <span>Trust Score</span>
          <b><?php echo esc_html($trust_total); ?> / 100</b>
        </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      <!-- <?php get_template_part('template-parts/review/review-toc', null, ['toc' => $toc]); ?> -->
    </aside>

  </div><!-- .review-layout -->

  <?php if ($site_posts_query->have_posts()) : ?>
  <section class="review-read-more" id="review-end-sentinel">
    <h2 class="review-read-more__heading">Read more about <?php echo esc_html($name); ?></h2>
    <div class="review-read-more__grid">
      <?php while ($site_posts_query->have_posts()) : $site_posts_query->the_post(); ?>
        <?php get_template_part('template-parts/card/card', 'review-article'); ?>
      <?php endwhile; ?>
    </div>
  </section>
  <?php endif; ?>
  
  <!-- MORE SITES -->
  <?php
    if ($more_sites->have_posts()) : ?>
      <section class="section">
        <?php
        outputNewSlideHTML(array(
          'query'   => $more_sites,
          'heading' => 'Top Sites'
        ));
        ?>
      </section>
  <?php endif; ?>

  <?php get_template_part('template-parts/section/latest-posts-review', null, array(
    'exclude' => array($review_id)
  )); ?>

</div><!-- .container -->

<?php if (!$closed && $link) { ?>
<div class="sticky-cta" aria-hidden="true">
  <div class="sticky-cta__inner container">
    <div class="sticky-cta__info">
      <?php if ($bonus_info) echo '<span>' . esc_html($bonus_info) . '</span>'; ?>
    </div>
    <a href="<?php echo esc_url($link); ?>" class="button button__primary" target="_blank" rel="sponsored noopener" aria-label="Visit <?php echo esc_attr($name); ?>">
      Visit <?php echo esc_attr($name); ?>
    </a>
  </div>
</div>
<?php } ?>

<?php get_footer(); ?>