<?php
if (is_tax()) {
  $term = get_queried_object();
  $faqs = get_field('faqs', $term);
} else {
  $faqs = get_field('faqs');
}
?>
<?php if (is_array( $faqs ) && ! empty( $faqs )) { ?>
  <div class="faqs">
    <h2 class="faqs__heading">Frequently Asked Questions</h2>

    <div class="faq-items">

      <?php foreach ($faqs as $i => $faq) {
        $question  = $faq['question'];
        $answer    = $faq['answer'];
        $answer_id = 'faq-answer-' . $i; ?>

        <div class="faq">
          <h3>
            <button class="faq__toggle" aria-expanded="false" aria-controls="<?php echo $answer_id; ?>">
              <?php echo $question; ?>
              <span class="faq__icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
              </span>
            </button>
          </h3>
          <div class="faq__answer" id="<?php echo $answer_id; ?>" aria-hidden="true">
            <p><?php echo $answer; ?></p>
          </div>
        </div>

      <?php }; ?>

    </div>

  </div><!-- .faqs -->
<?php }; ?>
