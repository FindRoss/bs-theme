<?php get_header(); ?>

    <?php 
      $current_id = get_the_ID();

      // Dates
      $expiry_date = get_field('expiry_date'); 
      $bonus_marked_as_expired = get_field('bonus_expired');
      $expiry_date_has_passed = false;
      
      if ($expiry_date) {
        $expiry_date_timestamp = DateTime::createFromFormat('Y-m-d H:i:s', $expiry_date)->getTimestamp();
        $expiry_date_has_passed = $expiry_date_timestamp < time();
      }


    
 

    ?>  

   



 

<?php get_footer(); ?>