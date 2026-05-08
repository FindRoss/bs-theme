<?php
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {

    private $current_parent_id = null;

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        if ( ! empty( $args->is_mobile ) ) {
            $output .= "\n$indent<ul class=\"sub-menu\">\n";
        } else {
            $output .= "\n$indent<div class=\"sub-menu-wrapper\"><div class=\"mega-menu__inner\"><ul class=\"sub-menu\">\n";
        }
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        if ( ! empty( $args->is_mobile ) ) {
            $output .= "$indent</ul>\n";
        } else {
            $panel = $this->get_posts_panel( $this->current_parent_id );
            $output .= "$indent</ul><div class=\"mega-menu__panel\">$panel</div></div></div>\n";
        }
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        // Track the top-level parent so end_lvl can read its category field
        if ( $depth === 0 && in_array( 'menu-item-has-children', $item->classes ) ) {
            $this->current_parent_id = $item->ID;
        }

        $before_length = strlen( $output );
        parent::start_el( $output, $item, $depth, $args, $id );

        // Only inject into sub-menu items (depth > 0)
        if ( $depth > 0 ) {
            $icon_src   = $this->get_item_icon( $item );
            $subheading = get_field( 'nav_subheading', $item->ID );

            $new_part = substr( $output, $before_length );

            if ( $subheading ) {
                $icon_html = $icon_src
                    ? '<img class="nav-icon" src="' . esc_url( $icon_src ) . '" alt="" width="36" height="36" aria-hidden="true">'
                    : '';
                $sub_html = '<span class="nav-item__subheading">' . esc_html( $subheading ) . '</span>';
                $new_part = preg_replace(
                    '/(<a[^>]*>)(.*?)(<\/a>)/s',
                    '$1' . $icon_html . '<span class="nav-item__text"><span class="nav-item__title">$2</span>' . $sub_html . '</span>$3',
                    $new_part,
                    1
                );
            } elseif ( $icon_src ) {
                $icon_html = '<img class="nav-icon" src="' . esc_url( $icon_src ) . '" alt="" width="36" height="36" aria-hidden="true">';
                $new_part  = preg_replace( '/(<a[^>]*>)/', '$1' . $icon_html, $new_part, 1 );
            }

            $output = substr( $output, 0, $before_length ) . $new_part;
        }
    }

    private function get_posts_panel( $parent_menu_item_id ) {
        if ( ! $parent_menu_item_id ) return '';

        $category = get_field( 'menu_panel_category', $parent_menu_item_id );
        if ( ! $category ) return '';

        $query = new WP_Query( [
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'no_found_rows'  => true,
            'cat'            => $category->term_id,
        ] );

        if ( ! $query->have_posts() ) return '';

        $html = '<div class="mega-menu__posts">';

        while ( $query->have_posts() ) {
            $query->the_post();

            $thumb = get_the_post_thumbnail_url( null, 'medium' );
            $date  = get_the_date( 'j M Y' );

            $html .= '<a href="' . esc_url( get_permalink() ) . '" class="mega-menu__post">';
            if ( $thumb ) {
                $html .= '<img src="' . esc_url( $thumb ) . '" alt="' . esc_attr( get_the_title() ) . '" width="120" height="80">';
            }
            $html .= '<div class="mega-menu__post-content">';
            $html .= '<span class="mega-menu__post-date">' . esc_html( $date ) . '</span>';
            $html .= '<h4 class="mega-menu__post-title">' . esc_html( get_the_title() ) . '</h4>';
            $html .= '</div></a>';
        }

        wp_reset_postdata();
        $html .= '</div>';

        return $html;
    }

    private function get_item_icon( $item ) {
        $icon = null;

        if ( $item->type === 'taxonomy' ) {
            $icon = get_field( 'icon', 'term_' . $item->object_id );
        } elseif ( $item->type === 'post_type' ) {
            $icon = get_field( 'icon', $item->object_id );
        }

        if ( $icon && is_array( $icon ) ) {
            return $icon['sizes']['thumbnail'] ?? $icon['url'];
        }

        return null;
    }
}
