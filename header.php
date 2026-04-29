<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <!-- WP_HEAD STARTS -->
    <?php wp_head(); ?>
    <!-- GTM -->
    <?php if (!is_admin() && strpos(home_url(), 'https://bitcoinchaser.com') !== false && !is_user_logged_in()) { ?>
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-M5FRRGN');</script>
    <?php } ?>
</head>
<body <?php body_class(); ?>>

<?php if (!is_admin() && strpos(home_url(), 'https://bitcoinchaser.com') !== false && !is_user_logged_in()) { ?>
  <!-- GTM (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M5FRRGN"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php } ?>

<header class="header">
  <div class="container">
    <div class="nav-layout">
      
      <div class="nav-layout__logo">
        <button type="button" id="nav-toggle" class="button button__icon" aria-expanded="false" aria-label="Open menu">
          <i data-feather="menu"></i>
        </button>
        <a href="/" class="d-flex align-items-center">
          <img width="274" height="34" class="exclude-lazyload" src="https://bitcoinchaser.com/wp-content/uploads/2014/06/bitcoinchaser_logo-03.png" alt="BitcoinChaser logo">
        </a>
      </div>

      <nav class="nav-layout__menu desktop-navigation">
        <?php 
          wp_nav_menu( array(
            'theme_location'  => 'primary',
            'menu_class'      => 'desktop-menu',
            'menu_id'         => 'desktop-menu',
            'container'       => false,
            'depth'           => 2,
            'walker'          => new Custom_Walker_Nav_Menu(),
          )); 
        ?>
      </nav>

      <div class="nav-layout__search">
        <button type="button" id="nav-search-btn" class="button button__icon" aria-label="Search BitcoinChaser">
          <i data-feather="search"></i>
        </button>
      </div>
      
    </div>
  </div>
</header>

<?php get_template_part( 'template-parts/ad/ad-top' ); ?>

<div class="background-drawer">

  <div class="background-drawer__header">
    <button type="button" id="nav-toggle-close" class="button button__icon" aria-expanded="false" aria-label="Open menu">
      <i data-feather="x"></i>
    </button>
    
    <div class="chaser-search">
      <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
        <div class="chaser-search__layout">
          <input class="mr-sm-2 nav-search-input" type="search" placeholder="Search" aria-label="Search" value="" name="s" id="s">
          <button id="searchsubmit" class="button button__primary" value="Search" type="submit"><i data-feather="search"></i></button>
        </div>
      </form>
    </div>
  </div>

  <?php wp_nav_menu( array(
    'theme_location'  => 'sidebar',
    'depth'           => 2,
    'container'       => false,
    'menu_class'      => 'menu-sidebar-nav',
    'menu_id'         => 'menu-sidebar-nav'
  )); ?>
  
</div>

<div class="page-overlay"></div>
<main>