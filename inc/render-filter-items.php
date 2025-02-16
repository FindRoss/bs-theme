<?php 

function render_filter_items() {

  ob_start(); ?>

  <div class="filter-item">
    
    <h3 class="filter-toggle">
      <span class="heading">Type</span>
      <span class="icon"><?php echo get_svg_icon('chevron-up'); ?></span>
    </h3>

    <div class="checkboxes-wrapper">
      <div class="checkboxes" data-checkbox-type="postType">

        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="post" id="checkArticle" aria-labelledby="checkArticleLabel">
          <label class="form-check-label" for="checkArticle" id="checkArticleLabel">
            Articles
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="review" id="checkReview" aria-labelledby="checkReviewLabel">
          <label class="form-check-label" for="checkReview" id="checkReviewLabel">
            Reviews
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="bonus" id="checkBonus" aria-labelledby="checkBonusLabel">
          <label class="form-check-label" for="checkBonus" id="checkBonusLabel">
            Bonuses
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="streamer" id="checkStreamer" aria-labelledby="checkStreamerLabel">
          <label class="form-check-label" for="checkStreamer" id="checkStreamerLabel">
            Streamers
          </label>
        </div>
        
      </div>
    </div>
  </div><!-- .filter-item -->  

  <?php $content = ob_get_clean(); 
  echo $content;
}