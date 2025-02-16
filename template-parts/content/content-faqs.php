<?php 
if (is_tax()) {
  $term = get_queried_object();
  $faqs             = get_field('faqs', $term); 
  $faqs_heading     = get_field('faqs_heading', $term);
  $faqs_description = get_field('faqs_description', $term);
} else {
  $faqs             = get_field('faqs'); 
  $faqs_heading     = get_field('faqs_heading');
  $faqs_description = get_field('faqs_description');
}
?>
<?php if ($faqs) { ?> 
  <div class="bg-cus-light mt-5 p-3 rounded">
    <h2 class="mt-2 mb-4">FAQs</h2>
    <?php if ($faqs_description) { echo '<p>' . $faqs_description . '</p>'; }; ?>

    <?php foreach ($faqs as $faq) { 
      $question = $faq['question']; 
      $answer   = $faq['answer']; ?>

      <div class="mb-4">  
        <h3><?php echo $question; ?></h3>
        <p><?php echo $answer; ?></p>
      </div>
    <?php }; ?>

  </div><!-- .faqs__wrapper -->
<?php }; ?>