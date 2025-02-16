<?php
// Field from block
$type = get_field( 'type' ); 
$text = get_field( 'text' );

$icon_type = '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#c8c807" class="bi bi-lightning-fill" viewBox="0 0 16 16">
                <path d="M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641z"/>
              </svg>';

if ($type === "fact") {
  $icon_type = '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#288000" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247m2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z"/>
                </svg>';
} else if ($type === "note") {
  $icon_type = '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#c8c807" class="bi bi-lightbulb-fill" viewBox="0 0 16 16">
                  <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5"/>
                </svg>';     
}
?>

<aside class="note-block">
  <div class="note-block__title">
    <span class="icon"><?php echo $icon_type; ?></span><span class="text-uppercase note-block__header ff-main"><?php echo $type; ?></span>
  </div>
  <div class="note-block__content">
    <?php echo $text; ?>
  </div>
</aside>

 
 


