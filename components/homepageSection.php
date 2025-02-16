<div class="container mt-5">
  <section>
    <?php 
        $blog_section_query = new WP_Query(array(
          'post_type'      => array('post'), 
          'posts_per_page' => 4, 
          'category_name'  => $blog_section_category,
          'post__not_in'   => $used_posts,
          'meta_query'     => bonus_expired_meta_query()
        )); 
        ?> 
   
        <?php if ( $blog_section_query->have_posts() ) : ?>

          <?php chaser_styled_sub_heading(array(
            'heading' => $blog_section_title,
            'link'    => $blog_section_slug
          )); ?>

          <p class="mt-2"><?php echo $blog_section_description; ?></p>

          <div class="row">
            <?php while ( $blog_section_query->have_posts() ) : $blog_section_query->the_post() ?>
              <div class="col-12 col-md-6 col-lg-3 mt-3">
                <?php require locate_template('components/card/article.php'); ?>
                <?php $used_posts[] = get_the_ID(); ?>
              </div>
            <?php endwhile; ?>

          </div><!-- .row --> 
        <?php wp_reset_postdata();
        endif; ?>
  </section>
</div>