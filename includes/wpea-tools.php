<?php
/* 
 * WP Estate Agency tools functions
 */

class WPea_Tools extends WPea  {
    
    static function set_data() {
        
        parent::$addthis = array(
            'facebook' => array(
                'label' => 'Facebook',
                'class' => 'addthis_button_facebook',
                'new_window' => 1,
            ),
            'print' => array(
                'label' => __( 'Print', WPEA_PLUGIN_NAME ),
                'class' => 'addthis_button_print',
            ),
            'email' => array(
                'label' => __( 'Email', WPEA_PLUGIN_NAME ),
                'class' => 'addthis_button_email',
            ),
            'twitter' => array(
                'label' => 'Twitter',
                'class' => 'addthis_button_twitter',
                'new_window' => 1,
            ),
            'pinterest' => array(
                'label' => 'Pinterest',
                'class' => 'addthis_button_pinterest_share',
                'new_window' => 1,
            ),
            'linkedin' => array(
                'label' => 'Linked In',
                'class' => 'addthis_button_linkedin',
                'new_window' => 1,
            ),
            'google_plus' => array(
                'label' => 'Google +',
                'class' => 'addthis_button_google_plusone_share',
                'new_window' => 1,
            ),
            'addthis' => array(
                'label' => __( '+ button (with all AddThis services)', WPEA_PLUGIN_NAME ),
                'class' => 'addthis_button_compact',
            ),
            'counter' => array(
                'label' => __( 'Bubble counter', WPEA_PLUGIN_NAME ),
                'class' => 'addthis_counter addthis_bubble_style',
            ),
        );
    }
    
    /**
     * Allow XML uploads
     * 
     * @param type $mimes
     * @return type
     */
    public static function allow_upload_xml( $mimes ) {
        $mimes = array_merge($mimes, array('xml' => 'application/xml'));
        return $mimes;
    }
    
    /**
     * 
     * Change upload dir
     * @param type $upload
     * @return string
     */
    public static function change_upload_dir( $upload ) {
        $upload['subdir'] = '/wp-ea';
        $upload['path']   = $upload['basedir'] . $upload['subdir'];
        $upload['url']    = $upload['baseurl'] . $upload['subdir'];
        return $upload;
    }

    /**
     * Convert Id to term for query with filters
     * 
     * @global type $pagenow
     * @param type $query
     */
    public static function convert_id_to_term_in_query( $query ) {
        global $pagenow;
        $q_vars = &$query->query_vars;
        foreach( parent::$options['admin']['table_taxonomies'] as $tax ) :
            if ( $pagenow == 'edit.php' && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == WPEA_POST_TYPE && isset( $q_vars[$tax] ) && is_numeric( $q_vars[$tax] ) && $q_vars[$tax] != 0 ) :
                $term = get_term_by( 'id', $q_vars[$tax], $tax );
                $q_vars[$tax] = $term->slug;
            endif;
        endforeach;
    }
    
    /**
     * Replace a string with appropriate fields
     * 
     * @param array $args
     *  'source' : source data is in XML (xml) or in WP database (wp)
     *  'mask' : string to replace with data
     *  'post_id' : the post to use if source is wp, post_meta will be used if mask is not empty post_title otherwise
     *  'platform_key' : the node to use for data if mask is empty and source is xml
     *  'item' : the xml object
     *  'linked' : if true, a link wil be added on link with permalink value in href attribute
     * @return string
     */
    public static function fields_replaced_string( $args ) {
        if ( !empty( $args['mask'] ) ) :
            $title = $args['mask'];
            preg_match_all( '#%(.+)%#iU', $args['mask'], $matches );
            foreach( $matches[1] as $key ) :
                if ( $args['source'] === 'xml' ) :
                    $title = str_replace('%' . $key .'%', $args['item']->getElementsByTagName( $key )->item( 0 )->nodeValue, $title);
                elseif ( $args['source'] === 'wp' ) :
                    $field = self::get_field( $args['post_id'], $key );
                    if ( ! empty( $args['truncate'] ) ) :
                        $addendum = '';
                        $field = explode( ' ', $field, $args['truncate'] );
                        if ( count( $field ) >= $args['truncate'] ):
                            array_pop( $field );
                            $addendum = '...';
                        endif;
                        $field = implode( " ", $field ) . $addendum;
                    endif;
                    $title = str_replace('%' . $key .'%', $field, $title);
                endif;
            endforeach;
            if ( $args['source'] === 'wp' ) :
                $title = html_entity_decode( $title );
            endif;
            $title = ucfirst( $title );
        else:
            if ( $args['source'] === 'xml' and ! empty( $args['platform_key'] ) ) :
                $title = $args['item']->getElementsByTagName( parent::$platform[$args['platform_key']] )->item( 0 )->nodeValue;
                if ( empty( $title ) and ! empty( parent::$platform['if_empty_title'] ) ) :
                    $title = $args['item']->getElementsByTagName( parent::$platform['if_empty_title'] )->item( 0 )->nodeValue;
                endif;
            elseif ( $args['source'] === 'wp' ) :
                $title = get_the_title( $args['post_id'] );
            endif;
        endif;
        if ( $args['source'] === 'wp' and $args['linked'] === true ) :
            $title = '<a href="' . get_permalink( $args['post_id'] ) .'">' . $title . '</a>';
        endif;
        return $title;
    }

    /**
     * Test if file exists
     * 
     * @param type $url
     * @return boolean
     * @since 1.0
     */
    public static function is_file( $url ) {
        ini_set( 'allow_url_fopen', '1' );
        if ( @fclose( @fopen( $url, 'r' ) ) ) :
            return true;
        else:
            return false;
        endif;
    }
    
    /**
     * Parse request
     * 
     * @param type $query
     * @return type
     */
    public static function parse_request_trick($query) {
	if ( ! $query->is_main_query() )
            return;

	if ( count($query->query) != 2  || ! isset( $query->query['page'] ) ) {
            return;
	}

	if ( ! empty( $query->query['name'] ) ) {
            $query->set( 'post_type', array( 'post', WPEA_POST_TYPE, 'page' ) );
	}
    }
    
    /**
     * Remove Cusom Post Type slug
     * 
     * @param type $post_link
     * @param type $post
     * @param type $leavename
     * @return type
     */
    public static function remove_cpt_slug( $post_link, $post, $leavename ) {
	if ( $post->post_type != WPEA_POST_TYPE || $post->post_status != 'publish' ) {
            return $post_link;
	}
	$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
	return $post_link;
    }
    
    public static function add_body_classes( $classes ) {
        if ( is_page( parent::$options['front']['list_page_id'] ) or is_tax() ) :
            $classes[] = 'wpea-list-page';
        elseif ( get_post_type() === WPEA_POST_TYPE ) :
            $classes[] = 'wpea-property-page';
        endif;
	return $classes;
    }
    
    /**
     * Get custom field
     */
    public static function get_field( $post_id, $key, $unit = false, $format = false ) {
        if ( parent::$fields[$key]['type'] == 'group' or parent::$fields[$key]['type'] == 'sequence' ) :
            return json_decode( get_post_meta( intval( $post_id ), 'wpea_' . $key, true ) );
        elseif ( parent::$fields[$key]['type'] == 'taxonomy' ) :
            $terms = wp_get_post_terms( intval( $post_id ), parent::$fields[$key]['taxonomy'] );
            return $terms[0]->name;
        else:
            $field = get_post_meta( intval( $post_id ), 'wpea_' . $key, true );
            if ( ( $format or parent::$fields[$key]['format'] === 'price' ) and parent::$fields[$key]['type'] == 'number' ) :
                $field = number_format_i18n( intval( $field ) );
            endif;
            if ( $unit or ! empty( parent::$fields[$key]['unit'] ) ) :
                $field .= ' ' . parent::$fields[$key]['unit'];
            endif;
            return $field;
        endif;
    }
    
    /**
     * Get option wpea_custom_data
     * 
     * @param type $admin
     * @return type
     */
    public static function get_custom_data( $admin = false ) {
        $custom_data = get_option( 'wpea_custom_data' );
        if ( $admin ) :
            return $custom_data;
        else :
            return json_decode ( $custom_data, true );
        endif;
    }
    
    /**
     * Recursive array_map
     * 
     * @param callable $func
     * @param array $arr
     * @return array
     */
    public static function array_map_recursive( callable $func, array $arr ) {
        array_walk_recursive( $arr, function( &$v ) use ( $func ) {
            $v = $func( $v );
        });
        return $arr;
    }
    
}

WPea_Tools::set_data();
