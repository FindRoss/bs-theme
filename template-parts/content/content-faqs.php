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
<?php if (is_array( $faqs ) && ! empty( $faqs )) { ?> 
  <div class="faqs">
    <h2 class="faqs__heading">FAQs</h2>
    <?php if ($faqs_description) { echo '<p>' . $faqs_description . '</p>'; }; ?>

    <div class="faq-items">

      <?php foreach ($faqs as $faq) { 
        $question = $faq['question']; 
        $answer   = $faq['answer']; ?>

        <div class="faq">  
          <h3><?php echo $question; ?></h3>
          <p><?php echo $answer; ?></p>
        </div>

      <?php }; ?>

    </div>

  </div><!-- .faqs__wrapper -->
<?php }; ?>