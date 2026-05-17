<?php
if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

acf_add_local_field_group( [
    'key'      => 'group_mega_menu_panel',
    'title'    => 'Mega Menu Panel',
    'fields'   => [
        [
            'key'           => 'field_menu_panel_post_type',
            'label'         => 'Panel Post Type',
            'name'          => 'menu_panel_post_type',
            'type'          => 'text',
            'instructions'  => 'Post type slug to display in the right panel (e.g. post, review, bonus). Leave blank to default to "post".',
            'placeholder'   => 'post',
        ],
        [
            'key'           => 'field_nav_subheading',
            'label'         => 'Nav Subheading',
            'name'          => 'nav_subheading',
            'type'          => 'text',
            'instructions'  => 'Short descriptor shown beneath the link label in the mega menu.',
        ],
        [
            'key'           => 'field_menu_panel_category',
            'label'         => 'Panel Category',
            'name'          => 'menu_panel_category',
            'type'          => 'taxonomy',
            'instructions'  => 'Category to filter posts in the panel. Only used when Panel Post Type is "post".',
            'taxonomy'      => 'category',
            'field_type'    => 'select',
            'return_format' => 'object',
            'allow_null'    => 1,
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'nav_menu_item',
                'operator' => '==',
                'value'    => 'all',
            ],
        ],
    ],
    'active' => true,
] );
