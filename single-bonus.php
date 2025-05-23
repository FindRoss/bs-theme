<?php get_header(); ?>

    <?php 
      $current_id = get_the_ID();
      $options_bonuses = get_field('bonuses', 'options');

      // Remove the current ID from the options bonuses if it exists
      $options_bonuses = array_diff($options_bonuses, array($current_id));
      // Re-index the array if needed
      $options_bonuses = array_values($options_bonuses);

      // Text field
      $bonus            = get_field('bonus');
      $plus             = get_field('bonus_plus');
      $bonus_title      = get_field('bonus_title');
      $turnover         = get_field('turnover'); 
      $min_deposit      = get_field('min_deposit'); 
      $code             = get_field('code'); 
      $code_extended    = get_field('code_extended'); 
      $max_cashout      = get_field('max_cashout'); 
      $max_bonus        = get_field('max_bonus');
      $players_eligible = get_field('players_eligible'); 
      $game             = get_field('game'); 
      $valid_for        = get_field('valid_for');  

      // Dates
      $start_date = get_field('start_date');
      $expiry_date = get_field('expiry_date'); 
      $expiry_date_has_passed = false;
      
      if ($expiry_date) {
        $expiry_date_timestamp = DateTime::createFromFormat('Y-m-d H:i:s', $expiry_date)->getTimestamp();
        $expiry_date_has_passed = $expiry_date_timestamp < time();
      }

      // Bonus Expired  
      $bonus_marked_as_expired = get_field('bonus_expired');
      
      // Bonus Exclusive
      $bonus_exclusive = get_field('exclusive');

      // Bonus Link
      $bonus_link = get_field('bonus_link');

      // Relationship from Single-Bonus
      $casino_id = get_field('single_bonus_casino')[0];
      
      $details_group  = get_field('details_group', $casino_id);
      $name           = $details_group['name']; 
      $link           = $details_group['affiliate_link']; 
      $featured_image = get_the_post_thumbnail_url($casino_id, 'medium');

      $media_group = get_field('media_group', $casino_id);
      $theme_color = $media_group['theme_color'];

      $bonusType = get_the_terms(get_the_ID(), 'bonus_type');
      $bonusTypeOutput = ""; 

      // Check if $bonusType is not false and is an array
      if ($bonusType && !is_wp_error($bonusType)) {
          $bonusTypeLength = count($bonusType);
          $bonusTypeCount  = 0; 

        foreach ($bonusType as $type) {
          $bonusTypeOutput .= '<a href="' . esc_url(get_term_link($type)) . '">' . esc_html($type->name) . '</a>'; 
          $bonusTypeCount++;
          
          // Append a comma if there are more terms to come
          if ($bonusTypeCount < $bonusTypeLength) {
              $bonusTypeOutput .= ', ';
          }
        }
      }; 

      $table_fields = array(
        "Site"                  => $casino_id ? '<a href="' . get_the_permalink($casino_id) . '">' . $name . '</a>' : null,
        "Bonus"                 => $bonus,
        "Bonus Code"            => $code_extended ? $code_extended : $code,
        "Bonus Type"            => $bonusTypeOutput,
        "Wagering Requirements" => $turnover, 
        "Minimum Deposit"       => $min_deposit, 
        "Maximum Bonus"         => $max_bonus,
        "Max Cashout"           => $max_cashout,
        "Eligible Game"         => $game, 
        "Players Eligible"      => $players_eligible,
        "Bonus Duration"        => $valid_for,
        "Valid From"            => $start_date,
        "Expires On"            => formatDate($expiry_date),
      );

      $output_link = $bonus_link ? $bonus_link : $link;

      $relatedBonusArgs = array(
        'post_type'      => 'bonus',
        'posts_per_page' => 8,
        'meta_query'     => bonus_expired_meta_query(),
        'post__not_in'   => array($current_id)
      );
      
      if (!empty($options_bonuses)) {
        $relatedBonusArgs['post__in'] = $options_bonuses;
        $relatedBonusArgs['orderby'] = 'post__in'; 
      };
      $relatedBonus = new WP_Query($relatedBonusArgs);

      $sameSiteBonusArgs = array(
        'post_type'      => 'bonus',
        'posts_per_page' => 8,
        'post__not_in'   => array($current_id),
        'meta_query'     => array_merge(
        bonus_expired_meta_query(),
          array(
            array(
              'key'     => 'single_bonus_casino', 
              'value'   => '"' . $casino_id . '"', 
              'compare' => 'LIKE'
            )
          )
        ),
      );
      $sameSiteBonus = new WP_Query($sameSiteBonusArgs);

  

      $bonus_has_expired = $bonus_marked_as_expired || $expiry_date_has_passed;
    ?>  

    <?php if($bonus_has_expired) { ?>
      <?php get_template_part( 'template-parts/message/message-expired' ); ?>
    <?php } ?>

    <article>
      <div class="bonus-header-wrapper">
        <div class="container">
          <div class="bonus-header">
            <div class="bonus-header__brand" style="background: <?php echo $theme_color; ?>">
              <img src="<?php echo $featured_image ?>" alt="<?php $name . ' logo'; ?>" class="rounded-corners" aria-hidden="true" /> 
            </div>

            <div class="bonus-header__content">

              <?php if ($bonus_exclusive) : ?>
                <span class="info-pill exclusive">
                  <?php echo get_svg_icon('star'); ?>
                  <span>Exclusive</span>
                </span>
              <?php endif; ?>

              <h1><?php the_title(); ?></h1>

            </div><!-- .bonus-header__content -->
            
            <?php if (!$bonus_has_expired) : ?> 
            <div class="bonus-header__cta">
               
              <?php if ($code) { ?>
                <div class="button button__outline bonus-code">
                  <span class="bonus-code__label">Code: </span>
                  <span class="bonus-code__code mx-1"><?php echo $code; ?></span>
                  <span class="bonus-code__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
                    </svg>
                  </span>
                </div>
              <?php }; ?>
              <a href="<?php echo $output_link; ?>" class="button button__primary" rel="nofollow" target="_blank">Get Bonus</a>
            </div>
            <?php endif; ?>
            
          </div><!-- .bonus-header -->
        </div><!-- .container --> 
      </div><!-- .sticky --> 

      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-8">

            <!-- BODY -->
            <div class="bonus-body main--content">

              <?php if (get_the_content()) {  ?>
              <div class="bonus-body__content">
                <?php the_content(); ?>
              </div> 
              <?php }; ?>
                    
              <div class="bonus-body__table">
                <h2>Details</h2>
                <table class="chaser-table">
                  <tbody>
                    <?php foreach($table_fields as $key => $value) { ?>
                      <?php if ($value) : ?>
                        <tr>
                          <td><?php echo $key; ?></td>
                          <td><?php echo $value; ?></td>
                        </tr>  
                      <?php endif; ?>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div><!--.bonus-body --> 

          </div><!-- .col -->
        </div><!-- .row -->
      </div><!-- .container --> 
    </article>

  <?php if ($sameSiteBonus->have_posts()) : ?>
    <div class="container mt-5">
      <section>
        <?php 
          $sameSiteTitle = 'More ' . $name . ' Bonuses';
          outputNewSlideHTML(array(
            'query'   => $sameSiteBonus,
            'heading' => $sameSiteTitle
          ));
        ?>
      </section>
    </div>
  <?php endif; ?> 

  
  <?php 
    if ($bonusType && !is_wp_error($bonusType)) : 
      foreach( $bonusType as $term ) {
        $term_id = $term->term_id;
        $term_name = $term->name;
        $term_slug = $term->slug;
        $term_link = get_term_link($term_id);

        // Set up the query for bonuses with this bonus type.
        $args = array(
          'post_type'      => 'bonus',
          'posts_per_page' => 8,
          'meta_query'     => bonus_expired_meta_query(),
          'tax_query'      => array(
            array(
              'taxonomy' => 'bonus_type',
              'field'    => 'slug',
              'terms'    => $term_slug,
            )
          ),
          // Additional parameters like meta_query, order, etc. can be added here if needed.
        );
        $bonus_type_query = new WP_Query( $args );
      }

      echo '<div class="container mt-5">';
      echo '<section>';
        outputNewSlideHTML(array(
          'query'   => $bonus_type_query,
          'heading' => $term_name . ' Bonuses',
          'link'    => $term_link
        ));
      echo '</section>'; 
      echo '</div>'; 
    endif; ?>

  <?php if ($relatedBonus->have_posts()) : ?>
    <div class="container mt-5">
      <section>
        <?php 
          outputNewSlideHTML(array(
            'query'   => $relatedBonus,
            'heading' => 'Bonuses',
            'link'    => '/bonuses/'
          ));
        ?>
      </section>
    </div>
  <?php endif; ?> 
  
  <?php get_template_part( 'template-parts/section/articles' ); ?>

<?php get_footer(); ?>