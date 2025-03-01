<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php wp_title('&laquo;', true, 'right'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_head(); ?>
    <!-- Google Tag Manager -->
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
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M5FRRGN"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php } ?>

<header class="mb-4 bg-white"><!-- sticky-top -->
  <div class="container">
    <nav class="nav-layout">

      <div class="nav-layout__logo">
        <div class="d-flex align-items-center">
          <button type="button" id="nav-toggle" class="button button__icon me-2 d-lg-none" aria-expanded="false" aria-label="Open menu">
             <?php echo get_svg_icon('hamburger'); ?>
          </button>
          <a href="/">
            <img width="274" height="34" src="https://bitcoinchaser.com/wp-content/uploads/2014/06/bitcoinchaser_logo-03.png" alt="BitcoinChaser.com logos">
          </a>
        </div>
      </div><!-- .col -->

      <nav class="nav-layout__menu desktop-navigation">
        <?php 
          wp_nav_menu( array(
            'theme_location'  => 'primary',
            'menu_class'      => 'desktop-menu',
            'menu_id'         => 'desktop-menu',
            'container'       => false,
            'depth'           => 2,
            'walker'          => new Custom_Walker_Nav_Menu(), // Use the custom walker
          )); 
        ?>
      </nav><!--.col -->

      <div class="nav-layout__search">
        <button type="button" id="nav-search-btn" class="button button__icon" aria-label="Search BitcoinChaser">
          <?php echo get_svg_icon('search'); ?>
        </button>
      </div><!-- .col -->
      
    </nav>
  </div><!-- .container -->
</header>


<div class="background-drawer">
  <form class="form-inline w-100 p-2 bg-cus-light" role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <div class="input-group input-group-lg w-100">
    <input class="form-control mr-sm-2 nav-search-input" type="search" placeholder="Search" aria-label="Search" value="" name="s" id="s" type="text">
    <button id="searchsubmit" class="button button__primary" value="Search" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/></svg></button>
    </div>
  </form>
  
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