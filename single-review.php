
<?php get_header(); ?>

<?php 
$review_id = get_the_ID();

// TAXONOMIES
$crypto_terms   = get_the_terms( $review_id, 'cryptocurrency' );
$game_terms     = get_the_terms( $review_id, 'game' );
$provider_terms = get_the_terms( $review_id, 'provider' );
$payment_terms  = get_the_terms( $review_id, 'payment' ); 
$country_terms  = get_the_terms( $review_id, 'country' );

// ACF FIELDS
/* Details Group */
$details_group = get_field('details_group');
$name          = $details_group['name']; 
$link          = $details_group['affiliate_link']; 
$bonus         = $details_group['bonus']; 
$closed        = $details_group['closed']; // nothing or 1 

/* Media Group */
$media        = get_field('media_group');
$theme_color  = $media['theme_color'];
$homepageImg  = $media['homepage'];
$gamesImg     = $media['games'];
$bettingImg   = $media['betting'];

/* Introduction */
$introduction = get_field('introduction');

/* Sign Up */
$sign_up_content = get_field('sign_up');

/* KYC */
$kyc_content = get_field('kyc'); 

/* Games Group */
$games_group       = get_field('games_group');
$games_content     = $games_group['games'];
$providers_content = $games_group['providers']; 

/* Sports Betting */
$betting_content = get_field('betting'); 

/* Bonuses */
$bonus_content = get_field('bonuses');

/* Payments Group */
$payments_content = get_field('payments'); 

/* VIP Program */
$vip_content = get_field('vip_program');

/* Support Group */
$support_group    = get_field('support_group');
$support_content  = $support_group['content'];
$support_channels = $support_group['channels'];

/* Languages */
$languages = get_field('languages'); 

/* Mobile */
$mobile_content = get_field('mobile');

/* Conclusion */
$conclusion = get_field('conclusion');

// Array and there will always be something here.
$faqsGroup = get_field('review_faqs'); 
// Check if this is actually empty
$reviewFaqs = array();

// Set up the FAQs
if (!empty($faqsGroup['owner'])) {
  $reviewFaqs[] = array(
    'question' => 'Who is the owner of ' . $name,
    'answer'   => $faqsGroup['owner'],
  );
}
if (!empty($faqsGroup['bitcoin'])) {   
    $reviewFaqs[] = array(
    'question' => 'Does ' . $name . ' accept Bitcoin?',
    'answer'   => $faqsGroup['bitcoin'],
  );
}        
if (!empty($faqsGroup['legit'])) {
    $reviewFaqs[] = array(
    'question' => 'Is ' . $name . ' legit?',
    'answer'   => $faqsGroup['legit'],
    );
}   
if (!empty($faqsGroup['licensed'])) {
  $reviewFaqs[] = array(
    'question' => 'Is ' . $name . ' licensed?',
    'answer'   => $faqsGroup['licensed'],
  );
}

// Post rel query
$postRelQuery = new WP_Query(array(
  'post_type'      => 'post', 
  'posts_per_page' => 6, 
  'meta_query'     => array(
    array(
        'key'     => 'post-review-relationship', 
        'value'   => '"' . $id . '"', 
        'compare' => 'LIKE'
      )
    )
  )
); 

// More Sites
$topSites = get_field('sites', 'option');
$filteredTopSites = array_diff($topSites, array($review_id)); 

$more_sites_args = array(
  'post_type'      => 'review',
  'post__in'       => $filteredTopSites,
  'posts_per_page' => 8, 
  'orderby'        => 'post__in'  
);     
$more_sites = new WP_Query($more_sites_args); 

// FUNCTIONS
function addCommas($arr) {
  $output = "";
  $counter = 1; 
  foreach ($arr as $val => $key ) {
    $output .= $key;
    $output .= ($counter < count($arr)) ? ", " : "";
    $counter++;
  };
  return $output;
};

function terms_icon_list($arr) { 
  if (empty($arr)) return;
  // reduce the array to max 16 and order by 
  $limited_terms = array_slice($arr, 0, 12); ?>

  <div class="row py-3 mt-2">
    <?php foreach($limited_terms as $term) { ?>
      <div class="col-12 col-sm-6 col-lg-4">
        <?php require locate_template('components/card/tax-pill.php'); ?>
      </div>
    <?php }; ?>
  </div>

<?php 
};

function terms_list($arr) { 
  if (empty($arr)) return;

  $output = "";
  
  $total_count = count($arr);
  $count = 0; 
  $num_shown = 8;

  if (count($arr) > $num_shown)  {
    $my_class = "show-more-list";
  } else {
    $my_class = "";
  }

  $output .= '<div class="mt-3' . ' ' . $my_class . '">';
  $output .= '<div class="row border rounded-corners mx-0">';
  
  foreach($arr as $f) {

    $output .= '<div class="col-6 col-md-4 col-lg-3 my-1 term-list-item';
    $output .= ($count >= $num_shown) ? ' visually-hidden"' : '';
    $output .= '">';

    if (!is_string($f)) {
      $output .= $f->name;
    } else {
      $output .= $f;
    }; 
    
    $output .= '</div>';
    $count++;
  };

  if ($total_count > $num_shown) {
    $output .= '<div class="col-12 text-center border-top bg-cus-light" id="expand-review-list"><span style="cursor: pointer; text-decoration: none; color: #0074b3;">Show more <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
    </svg></span></div>';
  }

  $output .= '</div>'; 
  $output .= '</div>'; 
  return $output;
};

// TOC Navigation
$reviewNavItems = array();

if ($sign_up_content) {
  $reviewNavItems[] = array(
    'anchor'  => 'sign-up',
    'label'   => 'Sign up process'
  );
}
if ($kyc_content) {
  $reviewNavItems[] = array(
    'anchor'  => 'kyc',
    'label'   => 'KYC Requirements'
  );
}
if ($games_content) {
  $reviewNavItems[] = array(
    'anchor'  => 'games',
    'label'   => 'Games'
  );
}
if ($providers_content) {
  $reviewNavItems[] = array(
    'anchor'  => 'providers',
    'label'   => 'Providers'
  );
}
if ($betting_content) {
  $reviewNavItems[] = array(
    'anchor'  => 'betting',
    'label'   => 'Sports and esport betting'
  );
}
if ($payments_content) {
  $reviewNavItems[] = array(
    'anchor'  => 'payments',
    'label'   => 'Payments'
  );
}
if ($bonus_content) {
  $reviewNavItems[] = array(
    'anchor'  => 'bonuses',
    'label'   => 'Bonuses'
  ); 
}
if ($vip_content) {
  $reviewNavItems[] = array(
    'anchor'  => 'vip-program',
    'label'   => 'VIP Program'
  );
}
if ($mobile_content) {
  $reviewNavItems[] = array(
    'anchor'  => 'mobile',
    'label'   => 'Mobile'
  );
}
if ($support_content) {
  $reviewNavItems[] = array(
    'anchor'  => 'support',
    'label'   => 'Support'
  );
}
if ($languages) {
  $reviewNavItems[] = array(
    'anchor'  => 'languages',
    'label'   => 'Supported Languages'
  );
}
if ($conclusion) {
  $reviewNavItems[] = array(
    'anchor'  => 'why-play-at',
    'label'   => 'Why play at ' . $name . '?'
  );
}
if (!empty($reviewFaqs)) {
  $reviewNavItems[] = array(
    'anchor'  => 'faqs',
    'label'   => 'FAQs'
  );
}  
?>

<div class="container">

  <!-- CLOSED --> 
  <?php if ($closed) { ?>
    <div class="my-4">
      <div class="p-2 rounded-corners" style="background: #FAFAFA">
        <h2 class="h2"><?php echo $name; ?> is now closed</h2>
        <p class="fs-large">Explore our reviews of <a href="https://bitcoinchaser.com/sites/casino/"> popular crypto casinos</a> or <a href="https://bitcoinchaser.com/sites/sports/">sports betting sites</a> you might enjoy.</p>
        <?php if ($more_sites->have_posts()) :
           outputNewSlideHTML(array('query' => $more_sites)); 
          endif; ?>
      </div>
    </div>
  <?php } ?>
  <!-- .closed -->


  <!-- REVIEW HEADER -->
  <div class="review-header mt-5">
    <div class="review-header__media" style="background: <?php echo $theme_color; ?>">
      <img src="<?php echo get_the_post_thumbnail_url(); ?>"  width="500" height="250"  alt="<?php the_title(); ?>">
    </div>
    <div class="review-header__title">
      <h1 class="main--title title"><?php the_title(); ?> Review</h1>
      <?php require locate_template('components/article/meta.php'); ?>
    </div>

    <!-- BUTTON -->  
    <?php if (!$closed) { ?> 
      <div class="review-header__cta"> 
        <?php if ($bonus) : ?>
        <div class="bonus">
          <span class="bonus-icon">
            <?php echo get_svg_icon('star'); ?>
          </span>
          <span class="bonus-text">
            <div class="bonus-text__heading">Bonus</div>
            <div class="bonus-text__bonus"><?php echo $bonus; ?></div>
          </span><!-- .bonus-text --> 
        </div>
        <?php endif; ?>
        <?php if ($link) : ?>
          <a class="button button__primary w-100" rel="nofollow" target="_blank" href="<?php echo $link; ?>">
            Play Now
          </a>
        <?php endif; ?>
    </div>
    <?php } ?>
   
  </div>
  <!-- .review-header --> 

  <!-- REVIEW -->
  <div class="row flex-column flex-column-reverse flex-lg-row">
    <!-- REWVIEW COL -->
    <div class="col-12 col-lg-8 mt-4">
      <!-- Introduction -->
      <?php if($introduction) { ?>
      <div class="main--content">
        <?php echo $introduction; ?>
      </div>
      <?php }; ?>

      <!-- Homepage Image -->
      <?php if ($homepageImg) { ?>
        <img src="<?php echo $homepageImg; ?>" class="site-image w-100 h-auto mt-4 rounded-corners"/>
      <?php }; ?>

    
      <!-- Sign up -->
      <?php if ($sign_up_content) { ?>
        <section class="review-section main--content" id="sign-up">
          <h2><?php echo $name; ?> sign up process</h2>
          <?php echo $sign_up_content; ?>
        </section>
      <?php }; ?>  

      <!-- KYC -->
      <?php if ($kyc_content) { ?>
        <section class="review-section main--content" id="kyc">
          <h2><?php echo $name; ?> KYC requirements</h2>
          <?php echo $kyc_content; ?>
        </section>
      <?php }; ?>

      <!-- Games -->
      <?php if ($games_content) { ?>
        <section class="review-section main--content" id="games">
          <h2>Casino games on <?php echo $name; ?></h2>
          <!-- Image -->
          <?php if ($gamesImg) { ?>
            <img src="<?php echo $gamesImg; ?>" class="site-image"/>
          <?php }; ?>
          <?php echo $games_content; ?>
        </section>
        <?php echo terms_icon_list($game_terms); ?>
      <?php }; ?>

      <!-- Providers -->
      <?php if ($providers_content) { ?>
        <section class="review-section main--content" id="providers">
          <h2>Game providers on <?php echo $name; ?></h2>
          <?php echo $providers_content; ?>
          <?php echo terms_list($provider_terms); ?>
        </section>
      <?php }; ?>

      <!-- Betting -->
      <?php if ($betting_content) { ?>
        <section class="review-section main--content" id="betting">
        <h2><?php echo $name; ?> sports & esports betting</h2>
        <?php if ($bettingImg) { ?>
          <img src="<?php echo $bettingImg; ?>" class="site-image"/>
        <?php }; ?>
        <?php echo $betting_content; ?>
        </section>
      <?php }; ?>

      <!-- Payments -->
      <?php if ($payments_content) { ?>
        <section class="review-section main--content" id="payments"> 
          <h2><?php echo $name; ?> crypto & payment methods</h2>
          <?php echo $payments_content; ?>
          <?php echo terms_icon_list($crypto_terms); ?>    
        </section>
      <?php }; ?>

    
      <!-- Bonus -->
      <?php if ($bonus_content) { ?>
        <section class="review-section main--content" id="bonuses">
          <h2><?php echo $name; ?> bonuses</h2>
          <?php echo $bonus_content; ?>
        </section>
      <?php }; ?>    
        
      <?php 
      $bonusQuery = get_bonuses_by_review_query(get_the_ID()); 
      if ( $bonusQuery->have_posts() ) :
        
        if (!$bonus_content) {
          echo '<section class="review-section main--content" id="bonuses">'; 
          echo '<h2>' . $name  .  ' bonuses</h2>';
        }
        
          while ( $bonusQuery->have_posts() ) : $bonusQuery->the_post();  
            $bid = get_the_ID(); 
            require locate_template('components/card/bonus-long.php');
          endwhile;

        if (!$bonus_content) {
          echo '</section>';
        }
      endif; ?>

      
      <!-- VIP Program -->
      <?php if ($vip_content) { ?>
        <section class="review-section main--content" id="vip-program">
          <h2><?php echo $name; ?> VIP program</h2>
          <?php echo $vip_content; ?>
        </section>
      <?php }; ?>

      <!-- Mobile -->
      <?php if ($mobile_content) { ?>
        <section class="review-section main--content" id="mobile">
          <h2><?php echo $name; ?> mobile</h2>
          <?php echo $mobile_content; ?>
        </section>  
      <?php }; ?>

      <!-- Support -->
      <?php if ($support_content) { ?>
        <section class="review-section main--content" id="support">
          <h2>Customer support</h2>
          <?php echo $support_content; ?>
          <?php echo terms_list($support_channels); ?>
        </section>
      <?php }; ?>

      <!-- Languages --> 
      <?php if(!empty($languages)) { ?>
        <section class="review-section main--content" id="languages">
          <h2>Supported languages</h2>
          <p><?php echo $name; ?> supports <?php echo count($languages); ?> languages. </p>
          <?php echo terms_list($languages); ?>
        </section>
      <?php }; ?>

      <!-- Conslusion --> 
      <?php if($conclusion && $name) { ?>
        <section class="review-section main--content" id="why-play-at">
          <h2>Why play at <?php echo $name; ?>?</h2>
          <?php echo $conclusion ?>
        </section>
      <?php }; ?>

      <!-- BUTTON -->
      <?php if (!$closed) { ?> 
        <div class="mt-4">
          <a class="button button__primary w-100" rel="nofollow" target="_blank" href="<?php echo $link; ?>">
            Play Now
          </a>
        </div>
      <?php } ?>
          
      <!-- FAQS were here --> 
      <?php if (!empty($reviewFaqs)) { ?>
      <section class="mt-5 pt-3 border-top main--content" id="faqs">
        <h2 class="m-0">FAQs</h2>
        <?php foreach ($reviewFaqs as $faq) { ?>
          <!-- <div class="main--content"> -->
            <h3><?php echo $faq['question']; ?></h3>
            <p><?php echo $faq['answer']; ?></p>
          <!-- </div> -->
        <?php };  ?>
      </section>
      <?php }; ?>

      <!-- Read more about site -->   
      <?php if ($postRelQuery->have_posts()) : ?>
  
        <section class="mt-5 pt-3 border-top">
          <div class="main--content">
            <h2 class="m-0">Read more</h2>
          </div>
        
          <?php while ($postRelQuery->have_posts()) : $postRelQuery->the_post(); ?>
            <div class="mt-4">
              <?php require locate_template('components/card/article-long.php'); ?>
            </div>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
          
        </section><!-- .read more query --> 
      <?php endif; ?>

    </div>
    <!-- SIDEBAR COL / NAVIGATION -->      
    <div class="col-12 col-lg-4 mt-4">
      <div class="review-toc mt-4">
        <h2 class="review-toc__title">Table of Contents</h2>
        <nav class="review-toc__nav" aria-label="Table of Contents" itemscope itemtype="http://schema.org/SiteNavigationElement">
          <ul class="review-toc__list">

            <?php foreach ($reviewNavItems as $navItem) { ?>
              <li class="review-toc__item" itemprop="name">
                <a href="#<?php echo $navItem['anchor']; ?>" class="review-toc__link" itemprop="url">
                  <?php echo $navItem['label']; ?>
                </a>
              </li>
            <?php }; ?>
            
          </ul>
        </nav>
      </div>
    </div>
  </div>

</div><!-- .container --> 

<section class="review-bottom">
  <div class="container">

  
  <?php if (!$closed) { 
    if ( $more_sites->have_posts() ) : ?>
      <div class="mt-5 pt-4">
        <?php 
          outputNewSlideHTML(array(
            'query'   => $more_sites,
            'heading' => 'Top Sites'
          ));
        ?>
      </div>
    <?php endif; 
  }; ?> 
        
    <?php 
      $args = array(
        'post_type'      => 'post', 
        'posts_per_page' => 8,
        'meta_query'     => bonus_expired_meta_query()
    ); ?>

    <?php $latest_query = new WP_Query( $args ); ?>
    <?php if ( $latest_query->have_posts() ) : ?>
      <div class="mt-5 pt-4">
        <?php 
          outputNewSlideHTML(array(
            'query'   => $latest_query,
            'heading' => 'Latest'
          ));
        ?>
      </div>
    <?php endif; ?>
      
  </div><!-- .container -->
</section><!-- .section --> 

<?php get_footer(); ?>