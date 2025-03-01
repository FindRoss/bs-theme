<?php
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $submenu_class = 'sub-menu'; // Add your custom class here
        $output .= "\n$indent<div class=\"sub-menu-wrapper\"><ul class=\"$submenu_class\">\n";
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }
}
