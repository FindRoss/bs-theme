
<?php 
  $review_table_data = get_field('review_table');

// Add: Scroll  True / False
// $scroll = get_field('scroll') ?? null;
// PHP: echo $scroll ? "custom-table-scroll" : "";


// Add Fields to reviews
// VIP program
// VIP transfer
// VIP guide
// Blockchain
// Token
// Withdrawal speed
// Withdrawal fee
// Pros
// Cons
// 

// Have
// Type (casino / sports / esports)
// Crypto accepted
// Bonus
$excerpt = get_the_excerpt();

$columns = get_field('columns');



// To add to review
// Year Founded
// Number of games - casino_num_games
// Min deposit (BTC) - casino_year_founded
// Licensed
// KYC
// VIP Program

$count = 1; 
?>

<div class="main--table review--table custom-table-scroll">
  <!-- <div class="bc-branding"><img src="https://bitcoinchaser.com/wp-content/uploads/2025/12/bitcoinchaser-com-logo-icon__20x20.webp" /></div> -->
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Site</th>
        <th class="col-type">Type</th>
        <th class="col-crypto">Crypto</th>
        <th>Year Founded</th>
        <th>Num. Games</th>
        <th>Min. Deposit (BTC)</th>
        <th>License</th>
      </tr>
    </thead>
    <tbody> 

    <?php foreach($review_table_data as $review) : 
      $review_id = (int) $review;
      if ($review_id <= 0) continue;
              
        $review_type_terms  = get_the_terms($review_id, 'review_type');

        $license_terms = get_the_terms( $review_id, 'license' );
        if ( is_wp_error( $license_terms ) ) {
            $license_terms = [];
        }

        $crypto_terms = get_the_terms($review_id, 'cryptocurrency');
        $crypto_output = display_review_crypto($crypto_terms, 3); 

        // ACF Fields
        $details_group = get_field('details_group', $review_id);
        $year_founded = $details_group['year_founded'] ?? null; 
        $num_games = $details_group['num_games'] ?? null;
        $min_deposit_btc = $details_group['min_deposit_btc'] ?? null;
    ?>
      <tr>
        <td><?php echo $count; ?></td>
        <td><a href="<?php echo get_the_permalink($review); ?>"><?php echo get_the_title($review); ?></a></td>
        <td class="col-type"><div class="info-pills"><?php echo display_review_type($review_type_terms); ?></td>
        <td class="col-crypto"><div class="crypto-icons"><?php echo $crypto_output; ?></div></td>
        <td><?php echo $year_founded; ?></td>
        <td><?php echo $num_games; ?></td>
        <td><?php echo $min_deposit_btc; ?></td>
        <td><?php echo display_licenses($license_terms); ?></td>
      </tr> 
        <?php $count++; ?>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>