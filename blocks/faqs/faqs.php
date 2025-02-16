<?php 
  $faqs         = get_field('faqs'); 
  $faqs_heading = get_field('faqs_heading');
?>

<div class="faqs__wrapper">
  <h2 class="mb-4"><?php echo $faqs_heading; ?></h2>
  
  <?php foreach ($faqs as $faq) { 
    $question = $faq['question']; 
    $answer   = $faq['answer']; ?>

      <div class="mb-4">  
        <h3><?php echo $question; ?></h3>
        <div><?php echo $answer; ?></div>
      </div>

    <?php }; ?>
  </div>