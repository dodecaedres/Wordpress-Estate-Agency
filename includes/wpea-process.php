<?php
/* 
 * WP Estate Agency Processing functions
 */

class WPea_Process extends WPea  {
    
    /**
     * Save options
     * 
     * @since 1.0
     */
    public static function save_options( $tab_options = array() ) {
        $tmp = json_decode( stripslashes( $_REQUEST['wpea_custom_data'] ) );
        if( ! empty ( $_REQUEST['wpea_custom_data'] ) and ! empty( $tmp ) ) :
            update_option( 'wpea_custom_data',  stripslashes( $_REQUEST['wpea_custom_data'] ) );
        else :
            delete_option( 'wpea_custom_data' );
        endif;
        if ( empty( $tab_options ) ) :
            foreach ( $_REQUEST['wpea_options'] as $key => $value ) :
                if ( is_array( $value ) ) :
                    foreach ( $value as $tkey => $tvalue ) :
                        if ( is_array( $tvalue ) ) :
                            foreach ( $tvalue as $ttkey => $ttvalue ) :
                                $tab_options[$key][$tkey][$ttkey] = esc_attr( $ttvalue );
                            endforeach;
                        else:
                            $tab_options[$key][$tkey] = esc_attr( $tvalue );
                        endif;
                    endforeach;
                else:
                    if ( $key === 'feed_url' ) :
                        $tab_options[$key] = esc_url( $value );
                    else:
                        $tab_options[$key] = esc_attr( $value );
                    endif;
                endif;
            endforeach;
             // Reset Cron if settings have changed
            if ( isset( $_REQUEST['wpea_options']['cron'] ) && is_array( $_REQUEST['wpea_options']['cron'] ) && isset( $_REQUEST['wpea_options']['cron']['active'] ) && $_REQUEST['wpea_options']['cron']['active'] == 1 ) 
    // Your code here


                wp_clear_scheduled_hook( 'wpea_cron' );
            endif;
      
        update_option( 'wpea', json_encode( $tab_options ) );
        WPea_Data::set_data();
        // Cron set
        if ( isset( $_REQUEST['wpea_options']['cron'] ) && $_REQUEST['wpea_options']['cron']['active'] == 1 ) :

            WPea_Cron::setup();
        endif;
    }
    
    /**
     * Save groups
     * 
     * @since 1.0
     */
    public static function save_groups() {
        $tab_groups = array();
        foreach ( $_POST['wpea_groups'] as $group_key => $fields ):
            if( $fields['title'] === __( 'New group', WPEA_PLUGIN_NAME ) ) :
                continue;
            endif;
            $tab_groups[$group_key]['id'] = (int) $fields['id'];
            $tab_groups[$group_key]['title'] = sanitize_text_field( wp_unslash( $fields['title'] ) );
            foreach ( $fields as $key => $field ):
                if ( is_array( $field ) and ! empty ( $field['key'] ) ) :
                    foreach( $field as $field_key => $field_value ) :
                        $tab_groups[$group_key]['fields'][$key][$field_key] = stripslashes( $field_value );
                    endforeach;
                endif;
            endforeach;
        endforeach;
        update_option( 'wpea_groups', json_encode( $tab_groups ) );
        parent::$groups = $tab_groups;
    }
    
    /**
     * Save search boxes
     * 
     * @since 1.0
     */
    public static function save_search_boxes() {
        $tab_search = array(
            'default_title' => '',
            'basic' => array(),
            'full' => array(),
        );
        foreach ( $_POST['wpea_search'] as $group => $tab ):
            if( $group == 'default_title' ) :
                $tab_search['default_title'] = sanitize_text_field( wp_unslash( $tab ) );
            else:
                foreach ( $tab as $field ):
                    if ( $field['type'] === 'submit' ) :
                        $tab_search[$group]['submit']['type'] = $field['type'];
                        if ( ! empty( $field['value'] ) ) :
                            $tab_search[$group]['submit']['value'] = sanitize_text_field( wp_unslash( $field['value'] ) );
                        endif;
                    elseif ( ! empty( $field['key'] ) ) :
                        $tab_search[$group][$field['key']]['type'] = $field['type'];
                        foreach ( $field as $key => $value ) :
                            if ( ! empty( $value ) and $key != 'key' ) :
                                $tab_search[$group][$field['key']][$key] = sanitize_text_field( wp_unslash( $value ) );
                            endif;
                        endforeach;
                    endif;
                endforeach;
            endif;
        endforeach;
        update_option( 'wpea_search', json_encode( $tab_search ) );
        parent::$search = $tab_search;
    }
    
    /**
     * Prepare feed import
     * 
     * @since 1.0
     */
    public static function prepare_import() {
        $tab = array(
            'delete' => array(),
            'existing' => array(),
            'process' => array(),
        );
        $results['url'] = parent::$options['feed_url'];
        
        // Load feed file
        $xml  = new DOMDocument();
        $xml->load( $results['url'] );
        $tab['url'] = $results['url'];
        
        // Properties already in database
        $query = new WP_Query( array( 'post_type' => WPEA_POST_TYPE, 'nopaging' => true ) );
        while ( $query->have_posts() ) :
            $query->the_post();
            $id = get_the_ID();
            $ref = esc_attr(get_post_meta($id, 'wpea_'.parent::$platform['unicity_key'], true));
            $tab['delete'][$id] = $ref;
            $tab['existing'][$id] = $ref;
        endwhile;      
        
        // Parse items
        foreach ( $xml->getElementsByTagName( parent::$platform['item_node'] ) as $item ) :
            // Unset from items to delete so the property will be updated and not deleted or drafted
            $post_to_delete = array_search( $item->getElementsByTagName( parent::$platform['unicity_key'] )->item( 0 )->nodeValue, $tab['delete'] );
            if ( ! empty( $post_to_delete ) ) :
                unset( $tab['delete'][$post_to_delete] );
            endif;
            if ( parent::$platform['id_type'] === 'item_node_attribute' ) :
                $id = $item->getAttribute( 'id' );
            else :
                $id = $item->getElementsByTagName( parent::$platform['unicity_key'] )->item( 0 )->nodeValue;
            endif;
            $tab['process'][$id] = $item->getElementsByTagName( parent::$platform['unicity_key'] )->item( 0 )->nodeValue;
        endforeach;
        
        return $tab;
    }

    /**
     * Process a single custom post ID (can be an AJAX handler)
     * 
     * @param type $id
     * @param type $remain
     * @param type $existing_items
     * @param type $items_to_delete
     * @param type $feed_url
     * @param type $added
     * @param type $updated
     * @since 1.0
     * @todo Save other types of grouped values
     */
    public static function import( $id = null, $remain = 0, $existing_items = array(), $items_to_delete = array(), $feed_url = null, $added = 0, $updated = 0 ) {
        // Don't break the JSON result
        @error_reporting( 0 ); 
        // 5 minutes per item should be enough
        @set_time_limit( 900 );
        
        // Common arguments
        $args_default = array(
            'post_type' => WPEA_POST_TYPE,
            'post_status' => 'publish',
            'ping_status' => 'closed',
            'comment_status' => 'closed',
        );
        
        if ( empty( $id ) ) :
            $id = (int) $_REQUEST['id'];
            $remain = (int) $_REQUEST['remain'];
            $existing_items = $_REQUEST['existing'];
            $items_to_delete = $_REQUEST['delete'];
            $feed_url = esc_url( $_REQUEST['feed'] );
        endif;
        
        // Load feed file
        $xml  = new DOMDocument();
        $xml->load( $feed_url );
        
        // Parse items
        foreach ( $xml->getElementsByTagName( parent::$platform['item_node'] ) as $item ) :
            if ( parent::$platform['id_type'] === 'item_node_attribute' ) :
                $test_id = $item->getAttribute( 'id' );
            else :
                $test_id = $item->getElementsByTagName( parent::$platform['unicity_key'] )->item( 0 )->nodeValue;
            endif;
            // If item is not the one we want we continue
            if ( $id != $test_id )
                continue;
            
            // Arguments tab
            $args_post = array();
            $args_meta = array();
            $taxonomies = array();
            $group = array();
            $token_new = array();
           
            // Test for add or update
            $post_to_update = array_search( $item->getElementsByTagName( parent::$platform['unicity_key'] )->item( 0 )->nodeValue, $existing_items );
            if ( !empty( $post_to_update ) ) :
                $args_post['ID'] = $post_to_update;
                $updated++;
            else:
                $added++;
            endif;
            
            // Post title
            $args_post['post_title'] = WPea_Tools::fields_replaced_string( array(
                'source' => 'xml',
                'item' => $item,
                'mask' => parent::$options['seo']['h1'],
                'platform_key' => 'title_key' 
            ) );
            if ( empty( $args_post['post_title'] ) ) :
                $args_post['post_title'] = $item->getElementsByTagName( parent::$platform['if_empty_title'] )->item( 0 )->nodeValue;
            endif;
            
            // Post description
            $args_post['post_content'] = str_replace('\n','<br />', $item->getElementsByTagName( parent::$platform['description_key'] )->item( 0 )->nodeValue );
            
            // Permalink
            $args_post['post_name'] = WPea_Tools::fields_replaced_string( array(
                'source' => 'xml',
                'item' => $item,
                'mask' => parent::$options['seo']['permalink']
            ) );    
            if ( empty( $args_post['post_name'] ) ) :
                $args_post['post_name'] = $item->getElementsByTagName( parent::$platform['if_empty_title'] )->item( 0 )->nodeValue;
            endif;

            // Get fields
            foreach ( parent::$fields as $field_key => $field_datas ) :
                // sequence
                if ( $field_datas['type'] === 'sequence' ) :
                    if ( $field_datas['first_empty'] and ! empty( $item->getElementsByTagName( $field_datas['base'] )->item( 0 )->nodeValue ) ) :
                        $group[$field_key][] = $item->getElementsByTagName( $field_datas['base'] )->item( 0 )->nodeValue;
                    endif;
                    $count = $field_datas['start'];
                    while ( ! empty( $item->getElementsByTagName( $field_datas['base'].$field_datas['separator'].$count )->item( 0 )->nodeValue ) ) :
                        $group[$field_key][] = $item->getElementsByTagName( $field_datas['base'].$field_datas['separator'].$count )->item( 0 )->nodeValue;
                        $count++;
                    endwhile;
                    // set token to check if there are changes (on ly for URL content type)
                    if( $field_datas['content'] === 'url' ) :
                        $token_new[$field_key] = md5( implode( ',', $group[$field_key] ) );
                    endif;
                else :
                    // all feeds except title and description
                    if ( $field_key != parent::$platform['description_key'] and !empty( $item->getElementsByTagName( $field_key )->item( 0 )->nodeValue ) ) :
                        // taxonomies
                        if ( $field_datas['type'] === 'taxonomy' ) :
                            $taxonomies[$field_datas['taxonomy']][] = $item->getElementsByTagName( $field_key )->item( 0 )->nodeValue;
                        // group
                        elseif ( $field_datas['type'] === 'group' ) :
                            foreach ( $item->getElementsByTagName( $field_datas['node'] ) as $sub_item ) :
                                $group[$field_key][$sub_item->getAttribute( 'id' )] = $sub_item->nodeValue;
                            endforeach;
                            // set token to check if there are changes (on ly for URL content type)
                            if( $field_datas['content'] === 'url' ) :
                                $token_new[$field_key] = md5( implode( ',', $group[$field_key] ) );
                            endif;
                        // yes no
                        elseif ( $field_datas['type'] === 'yesno' ) :
                            $args_meta['wpea_'.$field_key] = strtolower( $item->getElementsByTagName( $field_key )->item( 0 )->nodeValue );
                        // bool
                        elseif ( $field_datas['type'] === 'bool' ) :
                            $args_meta['wpea_'.$field_key] = intval( $item->getElementsByTagName( $field_key )->item( 0 )->nodeValue );
                        // post date
                        elseif ( $field_datas['type'] === 'postdate' ) :
                            $date_stamp = intval( $item->getElementsByTagName( $field_key )->item( 0 )->nodeValue );
                            $args_post['post_date'] = date( "Y-m-d H:i:s", $date_stamp );
                        else:
                            $args_meta['wpea_'.$field_key] = $item->getElementsByTagName( $field_key )->item( 0 )->nodeValue;
                        endif;
                    endif;
                endif;
            endforeach;
                        
            // Database insert
            $args = array_merge( $args_default, $args_post );
            $post_id = wp_insert_post( $args );
            // custom fields
            foreach ( $args_meta as $meta_key => $meta_value ) :
                $test = update_post_meta( $post_id, $meta_key, $meta_value );
            endforeach;
            // taxonomies (not set in wp_insert_post because cron user doesn't have the capability to work with a taxonomy)
            foreach( $taxonomies as $tax_slug => $tax_termss ) :
                wp_set_object_terms( $post_id, $tax_termss, $tax_slug, true );
            endforeach;
            // update group if content is url and token is different from previous update
            foreach ( $group as $key => $item ) :
                if ( parent::$fields[$key]['content'] === 'url' ) :
                    if ( $token_new[$key] !== get_post_meta( $post_id, 'wpea_' . $key . '_token', true ) or parent::$platform['force_'.$key] == 1 ) :
                        // images delete
                        self::delete( $post_id, false, true );
                        // images insert
                        $group_tab = array();
                        foreach ( $item as $item_url ) :
                            $item_id = self::upload_media( $item_url, $post_id );
                            $item_tab[] = $item_id;
                        endforeach;
                        // post meta update
                        // if it's images we save with a forced key (images)
                        if ( $key == self::$platform['images_key'] ) :
                            $key = 'images' ;
                        endif;
                        update_post_meta( $post_id, 'wpea_' . $key, json_encode( $item_tab ) );
                        update_post_meta( $post_id, 'wpea_' . $key . '_token', $token_new[$key] );
                    endif;
                else :
                    //TODO : save other types of grouped values than URL (eg. multilanguage content). Should be done with a further platform that requires this feature.
                endif;
            endforeach;
            
            // If all items are processed
            if ( empty( $remain ) ) :
                self::post_import( $items_to_delete, $feed_url );
                $report['deleted'] = count( $items_to_delete );
            endif;
        endforeach;
        
        $report['added'] = $added;
        $report['updated'] = $updated;
        return $report;
    }
    
    /**
     * Actions after import
     * 
     * @param type $items_to_delete
     * @since 1.0
     */
    public static function post_import( $items_to_delete=array(), $feed_url='' ) {
        // Delete or draft concerned posts
        foreach ( $items_to_delete as $id_to_delete => $ref_to_delete ) :
            if ( parent::$options['not_in_feed'] === 'delete' ) :
                self::delete( $id_to_delete );
            else:
                wp_update_post( array( 'ID' => $id_to_delete, 'post_status' => parent::$options['not_in_feed'] ) );
            endif;
        endforeach;
        // Unlink file
        if ( !empty( $feed_url ) ) :
            @unlink( str_replace( 'http://'.$_SERVER['HTTP_HOST'],'..',$feed_url ) );
        endif;
    }
    
    /**
     * Upload a file in media center
     * 
     * @return int
     */
   public static function upload_media($url, $post_id) {
    $uploads = wp_upload_dir();
    $wpea_dir = $uploads['basedir'] . '/' . date('Y') . '/';
    $wpea_url = $uploads['baseurl'] . '/' . date('Y') . '/';

    if (!file_exists($wpea_dir)) {
        mkdir($wpea_dir, 0755, true);
    }

	
        
         $filename = array_pop(explode("/", $url));
        
           if (@fclose(@fopen($url, "r"))) {
        copy($url, $wpea_dir . $filename);
        $file_info = getimagesize($wpea_dir . $filename);
        $img_data  = array(
                'post_author'       => 1,
                'post_date'         => current_time( 'mysql' ),
                'post_date_gmt'     => current_time( 'mysql' ),
                'post_title'        => $filename,
                'post_status'       => 'inherit',
                'comment_status'    => 'closed',
                'ping_status'       => 'closed',
                'post_name'         => sanitize_title_with_dashes( str_replace( "_", "-", $filename ) ),
                'post_modified'     => current_time( 'mysql' ),
                'post_modified_gmt' => current_time( 'mysql' ),
                'post_parent'       => $post_id,
                'post_type'         => 'attachment',
                'guid'              => $wpea_url . $filename,
                'post_mime_type'    => $file_info['mime'],
                'post_excerpt'      => '',
                'post_content'      => ''
            );

             $attach_id = wp_insert_attachment($img_data, $wpea_dir . $filename, $post_id);

        if (!is_wp_error($attach_id)) {
            $attach_data = wp_generate_attachment_metadata($attach_id, $wpea_dir . $filename);
            if ($attach_data) {
                wp_update_attachment_metadata($attach_id, $attach_data);
            }
            return $attach_id;
        } else {
            // Something went wrong, so let's log an error message
            error_log("Error inserting attachment: " . $attach_id->get_error_message());
        }
    } else {
        // Something went wrong, so let's log an error message
        error_log("Error opening remote image URL: " . $url);
    }
    return 0; // Indicate failure
}
    
    /**
     * Save informations metabox
     * 
     * @param type $post_id
     * @param type $post
     * @return type
     */
    public static function save_informations( $post_id, $post ) {
        if ( !isset( $_POST['wpea_'.parent::$platform['unicity_key']] ) or !wp_verify_nonce( $_POST['wpea_informations_nonce'], 'wpea' ) ) :
            return $post_id;
        endif;

        $type = get_post_type_object( $post->post_type );
        if ( !current_user_can( $type->cap->edit_post ) ){
            return $post_id;
        }

        foreach ( parent::$fields as $key => $field ) :
            if ( !in_array( $key, array( parent::$platform['title_key'], parent::$platform['description_key'] ) ) ) :
                $field_key = 'wpea_'.$key;
                switch ( $field['type'] ) :
                    case 'text':
                    case 'tel':
                    case 'email':
                    case 'number':
                    case 'date':
                    case 'yesno':
                        update_post_meta( $post_id, $field_key, sanitize_text_field( wp_unslash( $_POST[$field_key] ) ) );
                    break;
                    case 'taxonomy':
                        wp_set_post_terms( $post_id, array( intval( $_POST[$field_key] ) ), $field['taxonomy'] );
                    break;
                    default:
                    break;
                endswitch;
            endif;
        endforeach;
    }

    /**
     * Save images metabox
     * 
     * @todo Add, delete, reorder images in property admin
     * 
     * @param type $post_id
     * @param type $post
     * @return type
     */
    public static function save_images( $post_id, $post ) {
        if ( !isset( $_POST['wpea-images-ids'] ) or !wp_verify_nonce( $_POST['wpea_images_nonce'], 'wpea' ) ) :
            return $post_id;
        endif;

        $type = get_post_type_object( $post->post_type );
        if ( !current_user_can( $type->cap->edit_post ) ){
            return $post_id;
        }
        
        update_post_meta( $post_id, 'wpea_images', "[" . sanitize_text_field( wp_unslash( $_POST['wpea-images-ids'] ) ) . "]" );
        update_post_meta( $post_id, 'wpea_images_token', 0 );
    }

    /**
     * Prepare delete for delete all custom posts
     * 
     * @return array
     * @since 1.0
     */
    public static function prepare_delete(){
        $tab = array();
        $query = new WP_Query( array( 'post_type' => WPEA_POST_TYPE, 'nopaging' => true ) );
        while ( $query->have_posts() ) :
            $query->the_post();
            $post_id = get_the_ID();
            $tab[$post_id] = get_post_meta( $post_id, 'wpea_'.parent::$platform['unicity_key'], true );
        endwhile;
        return $tab;
    }
    
    /**
     * Delete a single custom post ID and/or his media
     * 
     * @param type $post_id
     * @param type $delete_item
     * @param type $delete_attachments 
     * @since 1.0
     */
    public static function delete( $post_id = null, $delete_item = true, $delete_attachments = true ) {
        // Don't break the JSON result (for AJAX process
        @error_reporting( 0 ); 
        // 5 minutes per item should be enough
        @set_time_limit( 900 );
        
        // AJAX case
        if ( empty( $post_id ) ) :
            $post_id = (int) $_REQUEST['id'];
        endif;
        
        //delete post attachments
        if ( $delete_attachments ) :
            if ( get_post_type( $post_id ) !== WPEA_POST_TYPE ) :
                return;
            endif;
            $attachments = get_children( array( 'post_parent' => $post_id, 'post_type' => 'attachment' ) );
            foreach ( $attachments as $attachment ) :
                wp_delete_attachment( $attachment->ID );
            endforeach;
        endif;
        
        //delete post
        if ( $delete_item ) :
            $taxonomies = array();
            foreach ( parent::$taxonomies as $taxonomy => $tab_taxonomy ) :
                $taxonomies[] = $taxonomy;
            endforeach;
            wp_delete_object_term_relationships( $post_id, $taxonomies );
            wp_delete_post( $post_id, true );
        endif;
    }

    
}