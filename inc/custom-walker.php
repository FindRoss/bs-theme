<?php
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {

    private $current_parent_id   = null;
    private $current_panel_type  = null;

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        if ( ! empty( $args->is_mobile ) ) {
            $output .= "\n$indent<ul class=\"sub-menu\">\n";
        } elseif ( $this->current_panel_type === 'review' ) {
            $output .= "\n$indent<div class=\"sub-menu-wrapper\"><div class=\"mega-menu__inner mega-menu__inner--full\">\n";
        } else {
            $output .= "\n$indent<div class=\"sub-menu-wrapper\"><div class=\"mega-menu__inner\"><ul class=\"sub-menu\">\n";
        }
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        if ( ! empty( $args->is_mobile ) ) {
            $panel = $this->get_posts_panel( $this->current_parent_id );
            if ( $panel ) {
                $output .= "$indent<li class=\"mobile-panel-item\">$panel</li>\n";
            }
            $output .= "$indent</ul>\n";
        } elseif ( $this->current_panel_type === 'review' ) {
            $panel = $this->get_posts_panel( $this->current_parent_id );
            $output .= "$indent<div class=\"mega-menu__panel mega-menu__panel--full\">$panel</div></div></div>\n";
        } else {
            $panel = $this->get_posts_panel( $this->current_parent_id );
            $output .= "$indent</ul><div class=\"mega-menu__panel\">$panel</div></div></div>\n";
        }
    }

    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if ( $depth > 0 && $this->current_panel_type === 'review' && empty( $args->is_mobile ) ) {
            return;
        }
        parent::end_el( $output, $item, $depth, $args );
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        // Track the top-level parent and its panel type so start/end_lvl can use them
        if ( $depth === 0 && in_array( 'menu-item-has-children', $item->classes ) ) {
            $this->current_parent_id  = $item->ID;
            $this->current_panel_type = get_field( 'menu_panel_post_type', $item->ID ) ?: 'post';
        }

        // Skip sub-menu items entirely for review panels on desktop
        if ( $depth > 0 && $this->current_panel_type === 'review' && empty( $args->is_mobile ) ) {
            return;
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

        $post_type = get_field( 'menu_panel_post_type', $parent_menu_item_id ) ?: 'post';

        $query_args = [
            'post_type'      => $post_type,
            'posts_per_page' => 4,
            'no_found_rows'  => true,
        ];

        if ( $post_type === 'post' ) {
            $category = get_field( 'menu_panel_category', $parent_menu_item_id );
            if ( ! $category ) return '';

            $featured_ids = get_field( 'featured', 'term_' . $category->term_id );
            if ( ! empty( $featured_ids ) ) {
                $query_args['post__in'] = $featured_ids;
                $query_args['orderby']  = 'post__in';
            } else {
                $query_args['cat'] = $category->term_id;
            }

        } elseif ( $post_type === 'review' ) {
            $post_ids = get_field( 'sites', 'options' );
            if ( empty( $post_ids ) ) return '';
            $query_args['posts_per_page'] = 10;
            $query_args['post__in']       = $post_ids;
            $query_args['orderby']        = 'post__in';

        } elseif ( $post_type === 'bonus' ) {
            $post_ids = get_field( 'top_bonus', 'options' );
            if ( empty( $post_ids ) ) return '';
            $query_args['posts_per_page'] = 5;
            $query_args['post__in']       = $post_ids;
            $query_args['orderby']        = 'post__in';
            $query_args['meta_query']     = bonus_expired_meta_query();
        }

        $query = new WP_Query( $query_args );

        if ( ! $query->have_posts() ) return '';

        $html = '<div class="mega-menu__posts">';

        if ( in_array( $post_type, [ 'review', 'bonus' ], true ) ) {
            $template = 'template-parts/card/' . $post_type . '-pill';
            ob_start();
            while ( $query->have_posts() ) {
                $query->the_post();
                get_template_part( $template );
            }
            $html .= ob_get_clean();
        } else {
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
