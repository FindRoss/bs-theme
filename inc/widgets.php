<?php 

function widget_registration($name, $id, $description, $beforeWidget, $afterWidget, $beforeTitle, $afterTitle) {
  register_sidebar( array(
      'name' => __($name),
      'id' => $id,
      'description' => $description,
      'before_widget' => $beforeWidget,
      'after_widget' => $afterWidget,
      'before_title' => $beforeTitle,
      'after_title' => $afterTitle,
  ));
};

function multiple_widget_init(){
  widget_registration('Sidebar ad', 'sidebar-ad', 'Display an ad in the sidebar of posts and pages', '', '', '', '');
  widget_registration('Top ad', 'top-ad', 'Display an ad on the top of posts and pages', '<div class="ad-wrapper">', '</div>', '', ''); 
  widget_registration('Bottom ad', 'bottom-ad', 'Display an ad on the bottom of posts and pages', '<div class="ad-wrapper">', '</div>', '', ''); 
  widget_registration('US Sidebar ad', 'us-sidebar-ad', 'Display an ad to US users in the sidebar of posts and pages', '', '', '', '');
  widget_registration('US Top ad', 'us-top-ad', 'Display an ad to US users on the top of posts and pages', '<div class="ad-wrapper">', '</div>', '', ''); 
  widget_registration('US Bottom ad', 'us-bottom-ad', 'Display an ad to US users on the bottom of posts and pages', '<div class="ad-wrapper">', '</div>', '', ''); 
}
add_action('widgets_init', 'multiple_widget_init');