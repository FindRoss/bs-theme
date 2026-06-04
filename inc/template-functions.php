<?php

function bs_get_geo_top_sites(): array {
  $geo_country_map = [
    'US' => [ 'slug' => 'united-states',  'title' => 'Top US Sites',         'link' => '/country/united-states/' ],
    'GB' => [ 'slug' => 'united-kingdom', 'title' => 'Top UK Sites',         'link' => '/country/united-kingdom/' ],
    'CA' => [ 'slug' => 'canada',         'title' => 'Top Canadian Sites',   'link' => '/country/canada/' ],
    'DE' => [ 'slug' => 'germany',        'title' => 'Top German Sites',     'link' => '/country/germany/' ],
    'NZ' => [ 'slug' => 'new-zealand',    'title' => 'Top NZ Sites',         'link' => '/country/new-zealand/' ],
    'IE' => [ 'slug' => 'ireland',        'title' => 'Top Irish Sites',      'link' => '/country/ireland/' ],
    'AT' => [ 'slug' => 'austria',        'title' => 'Top Austrian Sites',   'link' => '/country/austria/' ],
    'IN' => [ 'slug' => 'india',          'title' => 'Top Indian Sites',     'link' => '/country/india/' ],
    'IT' => [ 'slug' => 'italy',          'title' => 'Top Italian Sites',    'link' => '/country/italy/' ],
    'ZA' => [ 'slug' => 'south-africa',   'title' => 'Top SA Sites',         'link' => '/country/south-africa/' ],
    'DK' => [ 'slug' => 'denmark',        'title' => 'Top Danish Sites',     'link' => '/country/denmark/' ],
    'NL' => [ 'slug' => 'netherlands',    'title' => 'Top Dutch Sites',      'link' => '/country/netherlands/' ],
    'FR' => [ 'slug' => 'france',         'title' => 'Top French Sites',     'link' => '/country/france/' ],
    'PH' => [ 'slug' => 'philippines',    'title' => 'Top PH Sites',         'link' => '/country/philippines/' ],
    'NO' => [ 'slug' => 'norway',         'title' => 'Top Norwegian Sites',  'link' => '/country/norway/' ],
    'CH' => [ 'slug' => 'switzerland',    'title' => 'Top Swiss Sites',      'link' => '/country/switzerland/' ],
    'JP' => [ 'slug' => 'japan',          'title' => 'Top Japanese Sites',   'link' => '/country/japan/' ],
    'MX' => [ 'slug' => 'mexico',         'title' => 'Top Mexican Sites',    'link' => '/country/mexico/' ],
    'FI' => [ 'slug' => 'finland',        'title' => 'Top Finnish Sites',    'link' => '/country/finland/' ],
    'GR' => [ 'slug' => 'greece',         'title' => 'Top Greek Sites',      'link' => '/country/greece/' ],
    'RU' => [ 'slug' => 'russia',         'title' => 'Top Russian Sites',    'link' => '/country/russia/' ],
    'PT' => [ 'slug' => 'portugal',       'title' => 'Top Portuguese Sites', 'link' => '/country/portugal/' ],
    'SE' => [ 'slug' => 'sweden',         'title' => 'Top Swedish Sites',    'link' => '/country/sweden/' ],
    'TH' => [ 'slug' => 'thailand',       'title' => 'Top Thai Sites',       'link' => '/country/thailand/' ],
    'UA' => [ 'slug' => 'ukraine',        'title' => 'Top Ukrainian Sites',  'link' => '/country/ukraine/' ],
    'BR' => [ 'slug' => 'brazil',         'title' => 'Top Brazilian Sites',  'link' => '/country/brazil/' ],
    'TR' => [ 'slug' => 'turkey',         'title' => 'Top Turkish Sites',    'link' => '/country/turkey/' ],
    'KR' => [ 'slug' => 'south-korea',    'title' => 'Top Korean Sites',     'link' => '/country/south-korea/' ],
    'CZ' => [ 'slug' => 'czech-republic', 'title' => 'Top Czech Sites',      'link' => '/country/czech-republic/' ],
    'BE' => [ 'slug' => 'belgium',        'title' => 'Top Belgian Sites',    'link' => '/country/belgium/' ],
    'PL' => [ 'slug' => 'poland',         'title' => 'Top Polish Sites',     'link' => '/country/poland/' ],
    'ES' => [ 'slug' => 'spain',          'title' => 'Top Spanish Sites',    'link' => '/country/spain/' ],
    'HK' => [ 'slug' => 'hong-kong',      'title' => 'Top HK Sites',         'link' => '/country/hong-kong/' ],
    'NG' => [ 'slug' => 'nigeria',        'title' => 'Top Nigerian Sites',   'link' => '/country/nigeria/' ],
    'KE' => [ 'slug' => 'kenya',          'title' => 'Top Kenyan Sites',     'link' => '/country/kenya/' ],
  ];

  if ( function_exists( 'geot_target' ) ) {
    foreach ( $geo_country_map as $iso => $config ) {
      if ( geot_target( $iso ) ) {
        $country_term = get_term_by( 'slug', $config['slug'], 'country' );
        if ( $country_term ) {
          $geo_ids = get_field( 'featured_reviews', $country_term ) ?: [];
          if ( ! empty( $geo_ids ) ) {
            return [
              'title'    => $config['title'],
              'link'     => $config['link'],
              'post_ids' => array_slice( array_map( 'intval', $geo_ids ), 0, 4 ),
            ];
          }
        }
        break;
      }
    }
  }

  // Fallback: generic sites from ACF options
  $rows    = get_field( 'sites', 'options' ) ?: [];
  $post_ids = array_slice( array_column( $rows, 'review' ), 0, 4 );

  return [
    'title'    => 'Top Sites',
    'link'     => '',
    'post_ids' => array_map( 'intval', $post_ids ),
  ];
}

function terms_to_box($terms, $title, $with_links = false, $current_page_url = ''): string  {

  if (!is_array($terms) || count($terms) === 0) return '';

  // Define a consistent threshold
  $threshold = 4;
  // Dont show count on taxonomy pages
  $is_review = is_singular('review');
  // Set variable for tracking if is current page
  $is_active_page = false; 

  ob_start(); ?>

  <div class="box <?php echo (count($terms) > $threshold) ? 'show-more-list' : ''; ?>">
    <div class="box__content">

      <h3 class="title">
        <?php echo $title; ?> 
        <?php if ($is_review) {  
            echo '<span class="">(' . count($terms) . ')</span>'; 
          };
        ?>   
      </h3>
      <ul>
        <?php foreach ($terms as $index => $term):
          $is_object = is_object($term);
          $term_name = $is_object ? $term->name : $term;
          $icon      = $is_object ? get_field('icon', $term) : null;
          $term_link = $is_object ? get_term_link($term) : null;

          // Check if we are on the page already
          $on_current_page = $term_link === $current_page_url;
          
          // Determine li classes
          $li_classes = [];
          if ($index >= $threshold) {
              $li_classes[] = 'list-item-hidden';
          };
          if ($on_current_page) {
            $li_classes[] = 'is-active';
          };
        ?>

          <li class="box-item <?php echo esc_attr(implode(' ', $li_classes)); ?>">
            <?php if (($with_links && $term_link)) : ?>
              <a <?php echo $on_current_page ? '' : 'href="' . esc_url($term_link) . '"'; ?>>
            <?php endif; ?>
            <?php if (($title == 'Cryptocurrency' || $title == 'Games' || $title = 'Sites') && !empty($icon['sizes']['thumbnail'])): ?>
              <img
                src="<?php echo esc_url($icon['sizes']['thumbnail']); ?>"
                width="40"
                height="auto"
                alt="<?php echo esc_attr($icon['alt'] ?? $term_name); ?>"
              >
            <?php endif; ?>
              <?php echo esc_html($term_name); ?>
              <?php if ($on_current_page) { ?>
                 <span class="dot">•</span>
              <?php } ?>
            <?php if (($with_links && $term_link)) : ?>
              </a>
            <?php endif; ?>
             
          </li>
        <?php endforeach; ?>
      </ul>

    </div><!-- .box__content -->

    <?php if (count($terms) > $threshold) { ?>

      <div class="box__footer">
        <button class="round-icon" id="expand-review-list"><?php echo get_svg_icon('chevron-down'); ?></button>
      </div>

    <?php } ?>
  </div>
    
<?php 
  return ob_get_clean();  
} ?>