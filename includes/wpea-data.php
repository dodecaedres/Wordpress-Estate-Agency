<?php
/**
 * WP Estate Agency configuration class
 */

class WPea_Data extends WPea {

    static function set_data() {

        parent::$labels = array(
            'custom_post' => array(
                'name'               => __( 'properties', WPEA_PLUGIN_NAME ),
                'singular_name'      => __( 'Property', WPEA_PLUGIN_NAME ),
                'add_new'            => __( 'Add', WPEA_PLUGIN_NAME ),
                'add_new_item'       => __( 'Add new property', WPEA_PLUGIN_NAME ),
                'edit_item'          => __( 'Edit', WPEA_PLUGIN_NAME ),
                'new_item'           => __( 'New property', WPEA_PLUGIN_NAME ),
                'view_item'          => __( 'View property', WPEA_PLUGIN_NAME ),
                'search_items'       => __( 'Search properties', WPEA_PLUGIN_NAME ),
                'not_found'          => __( 'Not found', WPEA_PLUGIN_NAME ),
                'not_found_in_trash' => __( 'Not found in trash', WPEA_PLUGIN_NAME ),
                'menu_name'          => __( 'Properties', WPEA_PLUGIN_NAME ),
            ),
        );

        parent::$options = array(
            'feed_url'            => '',
            'not_in_feed'         => 'delete', // for properties in database but not in feed : delete, draft
            'active_fields'       => array(),
            'active_taxonomies'   => array(),
            'agency'              => array(
                'name' => '',
                'tel' => '',
                'email' => '',
                'logo' => '',
            ),
            'admin'               => array(
                'show_in_menu'     => 0,
                'show_tax_in_menu' => 0,
                'table_taxonomies' => array(),
            ),
            'deactivation_delete' => 0,
            'cron'                => array(
                'active'     => 0,
                'recurrence' => 'daily',
                'hour'       => '06',
                'report'     => 0,
                'email'      => '',
            ),
            'images'              => array(
                'wpe_thumb' => array(
                    'width'  => 80,
                    'height' => 60,
                    'crop'   => 1
                ),
                'wpe_list'  => array(
                    'width'  => 305,
                    'height' => 170,
                    'crop'   => 1
                ),
                'wpe_detail'    => array(
                    'width'  => 913,
                    'height' => 500,
                    'crop'   => 1
                ),
            ),
            'seo'                 => array(
                'list_permalink'     => 'biens',
                'list_title'         => '',
                'list_h1'            => '',
                'permalink'          => '',
                'title'              => '',
                'h1'                 => '',
            ),
            'front'               => array(
                'use_wpe_templates'       => 1,
                'search_on_list_template' => 0,
                'template_search_type'    => 'full',
                'list_page_id'            => 0,
                'list_title'              => '',
                'list_pastille'           => '',
                'field_pastille'          => '',
                'contact_page_id'         => 0,
                'lazy_load'               => 0,
                'pagination'              => 0,
                'items_per_page'          => 9,
                'zoom'                    => 0,
            ),
            'addthis'             => array(
                'active' => 0,
                'pubid' => '',
                'size' => '',
                'items' => array( 'facebook', 'print', 'email', 'twitter', 'pinterest', 'linkedin', 'google_plus', 'addthis', 'counter'),
            ),
        );

        // if options are already saved in WP, refresh parent::$options
        $saved_options = json_decode( get_option( 'wpea' ), true );
        foreach( parent::$options as $key => $option ):
            if( !empty( $saved_options[$key] ) ):
                parent::$options[$key] = $saved_options[$key];
            endif;
        endforeach;

        // if search boxes are already saved in WP, refresh parent::$search
        $saved_searchboxes = json_decode( get_option( 'wpea_search' ), true );
        if( !empty( $saved_searchboxes ) ):
            parent::$search = $saved_searchboxes;
        endif;
        
        // if groups are already saved in WP, refresh parent::$groups
        $saved_groups = json_decode( get_option( 'wpea_groups' ), true );
        if( !empty( $saved_groups ) ):
            parent::$groups = $saved_groups;
        endif;
    }

}
