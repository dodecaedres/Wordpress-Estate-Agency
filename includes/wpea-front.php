<?php
/* 
 * WP Estate Agency Frontend functions
 */

class WPea_Front extends WPea  {
    
    /**
     * Scripts and styles enqueues
     * 
     * @since 1.0
     */
    public static function enqueues() {
        wp_enqueue_style( 'genericons', plugins_url( '../genericons/genericons.css', __FILE__ ), array(), '3.0.2');
        
        if ( isset(parent::$options['front']['lazy_load']) && parent::$options['front']['lazy_load'] == 1 ) :
            wp_enqueue_script( 'lazy-load', plugins_url( '../js/jquery.lazyload.min.js', __FILE__ ) );
        endif;
        
        if ( get_post_type() === WPEA_POST_TYPE and parent::$options['front']['use_wpe_templates'] == 1 ) :
            wp_enqueue_style( 'elastislide', plugins_url('../css/elastislide.css', __FILE__ ), array(), '20140731');
            wp_enqueue_script( 'modernizr', plugins_url('../js/modernizr.custom.17475.js', __FILE__ ), array('jquery'), '20140731');
            wp_enqueue_script( 'elastislide', plugins_url('../js/jquery.elastislide.js', __FILE__ ), array('jquery'), '20140731');
            wp_enqueue_script( 'swipebox', plugins_url('../js/jquery.swipebox.min.js', __FILE__ ), array('jquery'), '20140731');
            wp_enqueue_style( 'swipebox', plugins_url('../css/swipebox.min.css', __FILE__ ), array(), '20140731');
        endif;
        
        wp_enqueue_style( 'wpea', plugins_url( '../css/wpea.css', __FILE__ ) );
        wp_enqueue_script( 'wpea', plugins_url( '../js/wpea.js', __FILE__ ) );
    }
    
    /**
 * Frontend templates override
 * 
 * @since 1.0
 */
public static function set_template(){
    if( parent::$options['front']['use_wpe_templates'] == 1 ):
        
        // Initialize $page_template variable
        $page_template = ''; // Initialize the variable with an empty string
        
        // List page
        if ( is_page( parent::$options['front']['list_page_id'] ) ):
            $page_template = get_template_directory() . '/templates/wpea-list.php';
        
        // Details page
        elseif ( is_single() and get_post_type() === WPEA_POST_TYPE ):
            $page_template = get_template_directory() . '/templates/wpea-property.php';
        
        // Taxonomy
        elseif ( is_tax() ):
            $page_template = get_template_directory() . '/templates/wpea-taxonomy.php';
        endif;
        
        // Check if $page_template is not empty and if the file exists
        if( ! empty( $page_template ) && is_file( $page_template ) ):
            add_filter( 'body_class', array( 'WPea_Tools', 'add_body_classes' ) );
            include( $page_template );
            die();
        endif;
        
    endif;
}

        
    /**
     * Override Yoast breadcrumbs
     * 
     * @global type $post
     * @param type $links
     * @return type
     * @since 1.0
     */
    public static function override_yoast_breadcrumb_trail( $links ) {
        global $post;

        if ( is_singular( WPEA_POST_TYPE ) ):
            foreach( $links as $key => $link ):
                if( key( $link ) === 'ptarchive' and current( $link ) === WPEA_POST_TYPE ):
                    unset( $links[$key] );
                endif;
            endforeach;
            $breadcrumb[] = array(
                'url' => get_permalink( parent::$options['front']['list_page_id'] ),
                'text' => get_the_title( parent::$options['front']['list_page_id'] ),
            );
            unset( $links['ptarchive'] );
            array_splice( $links, 1, -2, $breadcrumb );
        endif;
        
        if ( is_tax()) :
            $breadcrumb[] = array(
                'url' => get_permalink( parent::$options['front']['list_page_id'] ),
                'text' => get_the_title( parent::$options['front']['list_page_id'] ),
            );
            array_splice( $links, 1, -2, $breadcrumb );
        endif;
        
        return $links;
    }
    
    /**
     * Add search to the query
     * 
     * @param type $query
     * @return type
     * @since 1.0
     */
    public static function pre_get_posts( $query ) {
        // validate
        if( is_admin() ):
            return;
        endif;

        if( $query->get( 'post_type' ) !== WPEA_POST_TYPE or empty( $_GET['wpea_search'] ) ):
            return;
        endif;
        
        $tax_query = array();

        // Search type
        $search_type = parent::$options['front']['template_search_type'];

        // get original meta query
        $meta_query = $query->get( 'meta_query' );

        foreach( $_GET as $get_key => $get_value ):
            if( empty( $get_value ) or $get_key === 'wpe_search' )
                continue;
            if( substr( $get_key, 0, 7 ) === 'wpemin_' ):
                $key_max = substr( $get_key, 7 );
                if( empty( $_GET[$key_max] ) ):
                    $meta_query[] = array(
                        'key' => 'wpea_' . $key_max,
                        'value' => array( intval( $get_value ), 999999999 ),
                        'type' => 'NUMERIC',
                        'compare' => 'BETWEEN'
                    );
                else:
                    continue;
                endif;
            endif;
            switch( parent::$search[$search_type][$get_key]['type'] ):
                case 'text':
                    $meta_query[] = array(
                        'key' => 'wpea_' . $get_key,
                        'value' => addslashes( urldecode( $get_value ) ),
                        'compare' => 'LIKE',
                    );
                    break;
                case 'min':
                    $meta_query[] = array(
                        'key' => 'wpea_' . $get_key,
                        'value' => addslashes( urldecode( $get_value ) ),
                        'type' => 'NUMERIC',
                        'compare' => '>=',
                    );
                    break;
                case 'max':
                    $meta_query[] = array(
                        'key' => 'wpea_' . $get_key,
                        'value' => addslashes( urldecode( $get_value ) ),
                        'type' => 'NUMERIC',
                        'compare' => '<=',
                    );
                    break;
                case 'interval':
                    if( empty( $_GET['wpemin_' . $get_key] ) ):
                        $get_value_min = 0;
                    else:
                        $get_value_min = intval( $_GET['wpemin_'.$get_key] );
                    endif;
                    $meta_query[] = array(
                        'key' => 'wpea_' . $get_key,
                        'value' => array( $get_value_min, intval( $_GET[$get_key] ) ),
                        'type' => 'NUMERIC',
                        'compare' => 'BETWEEN'
                    );
                    break;
                case 'select':
                    if( parent::$fields[$get_key]['type'] === 'taxonomy' ):
                        $tax_query[] = array(
                            'taxonomy' => parent::$fields[$get_key]['taxonomy'],
                            'field' => 'name',
                            'terms' => urldecode( $get_value ),
                        );
                    else:
                        $meta_query[] = array(
                            'key' => 'wpea_' . $get_key,
                            'value' => html_entity_decode( urldecode( $get_value ) ),
                            'compare' => 'IN',
                        );
                    endif;
                    break;
                default:
                    break;
            endswitch;
        endforeach;
        
        if( !empty( $tax_query ) ):
            $query->set('tax_query', $tax_query );
        endif;
        if( !empty( $meta_query ) ):
            $query->set('meta_query', $meta_query );
        endif;
        
        // always return
        return;
    }
    
    /**
     * Displays energy diagrams
     * 
     * @param type $post_id
     * @return string
     * @since 1.0
     */
    public static function get_energy_diagrams( $post_id ) {
        if ( empty( parent::$platform['dpe_key'] ) and empty( parent::$platform['ges_key'] ) ) :
            return;
        endif;
        
        $output = '';
        $dpe = WPea_tools::get_field( intval( $post_id ), parent::$platform['dpe_key'] );
        $ges = WPea_tools::get_field( intval( $post_id ), parent::$platform['ges_key'] );
        if( $dpe or $ges ):
            $output .= '<div class="wpea-wrapper-diagnostic">
                            <h2>' . __( 'Diagnosis of energy performance', WPEA_PLUGIN_NAME ) . '</h2>
                                <div>';
            if( $dpe ):
                $output .= '<ul id="wpea-dpe" data-value="' . $dpe . '">
                                <li>' . __( 'Economic residence', WPEA_PLUGIN_NAME ) . '</li>
                                <li><strong class="wpea-dpe"><span class="wpea-dpe-a"></span></strong></li>
                                <li><strong class="wpea-dpe"><span class="wpea-dpe-b"></span></strong></li>
                                <li><strong class="wpea-dpe"><span class="wpea-dpe-c"></span></strong></li>
                                <li><strong class="wpea-dpe"><span class="wpea-dpe-d"></span></strong></li>
                                <li><strong class="wpea-dpe"><span class="wpea-dpe-e"></span></strong></li>
                                <li><strong class="wpea-dpe"><span class="wpea-dpe-f"></span></strong></li>
                                <li><strong class="wpea-dpe"><span class="wpea-dpe-g"></span></strong></li>
                                <li>' . __( 'Inefficient housing', WPEA_PLUGIN_NAME ) . '</li>
                            </ul>';
                endif;
                if( $ges ):
                    $output .= '<ul id="wpea-ges" data-value="' . $ges . '">
                                    <li>' . __( 'Low-emission', WPEA_PLUGIN_NAME ) . '</li>
                                    <li><strong class="wpea-ges"><span class="wpea-ges-a"></span></strong></li>
                                    <li><strong class="wpea-ges"><span class="wpea-ges-b"></span></strong></li>
                                    <li><strong class="wpea-ges"><span class="wpea-ges-c"></span></strong></li>
                                    <li><strong class="wpea-ges"><span class="wpea-ges-d"></span></strong></li>
                                    <li><strong class="wpea-ges"><span class="wpea-ges-e"></span></strong></li>
                                    <li><strong class="wpea-ges"><span class="wpea-ges-f"></span></strong></li>
                                    <li><strong class="wpea-ges"><span class="wpea-ges-g"></span></strong></li>
                                    <li>' . __( 'High gas emission', WPEA_PLUGIN_NAME ) . '</li>
                                </ul>';
                endif;
                $output .= '</div>
                        </div>';
        endif;
        return $output;
    }
    
    /**
     * Display AddThis buttons
     * 
     * @return string
     * @since 1.0
     */
    public static function get_addthis_buttons() {
        $output = '';
        if ( parent::$options['addthis']['active'] == 1 and ! empty( parent::$options['addthis']['items'] ) ) :
            $output .= '<div class="alignleft addthis_label">' . __( 'Share:', WPEA_PLUGIN_NAME ) . '&nbsp;</div>
                        <div class="alignleft addthis_toolbox addthis_default_style ' . parent::$options['addthis']['size'] . '">';
            foreach ( parent::$options['addthis']['items'] as $key ) :
                $output .= '<a class="' . parent::$addthis[$key]['class'] .'"' . ( ( parent::$addthis[$key]['new_window'] == 1 ) ? ' target="_blank"' : '' ) . '></a>';
            endforeach;
            $output .= '</div>
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js' . ( ( ! empty( parent::$options['addthis']['pubid'] ) ) ? '#pubid='.parent::$options['addthis']['pubid'] : '' ) . '"></script>';
        endif;
        return $output;
    }
    
    /**
     * Override meta title
     * 
     * @param type $title
     */
    public static function set_title( $title ) {
        if ( is_single() and get_post_type() == WPEA_POST_TYPE and ! empty ( parent::$options['seo']['title'] ) ) :
            global $post;
            $args = array(
                'source' => 'wp',
                'mask' => parent::$options['seo']['title'],
                'post_id' => $post->ID,
            );
            $title = WPea_Tools::fields_replaced_string( $args );
        elseif ( ( is_page( parent::$options['front']['list_page_id'] ) or is_post_type_archive( WPEA_POST_TYPE ) ) and ! empty ( parent::$options['seo']['list_title'] ) ) :
            $title = parent::$options['seo']['list_title'];
        endif;
        return $title;
    }
    
    /**
     * Query for properties
     * 
     * @return \WP_Query
     * @since 1.0
     */
    public static function get_items( $params ) {
        $args = array(
            'post_type'   => WPEA_POST_TYPE,
            'post_status' => 'publish',
        );
        if ( parent::$options['front']['pagination'] == 1 ) :
            $args['posts_per_page'] = parent::$options['front']['items_per_page'];
            $args['paged'] = get_query_var('paged') ? intval( get_query_var('paged') ) : 1;
        else :
            $args['nopaging'] = true;
        endif;
        if ( !empty( $params ) ) :
            $args = array_merge( $args, $params );
        endif;
        $query = new WP_Query( $args );
        return $query;
    }
    
    /**
     * Build a list (<ul>) with properties
     * 
     * @param $r
     * @return html
     * @since 1.0
     */
    public static function get_list( $params ) {
        $r = self::get_items( $params );
        $html = '';
        if ( $r->have_posts() ) : $counter = 0;
            $counter = 0;
            //$html .= '<h2>' . __( 'Properties matching your search', WPEA_PLUGIN_NAME ) . '</h2>';
            $html .= '<ul class="wpea-list clearfix">';
            while ( $r->have_posts() ) :
                $counter++;
                $r->the_post();
                $images = wpea_get_field( get_the_ID(), 'images' );
                if ( ! empty( WPea::$options['front']['field_pastille'] ) ) :
                    $pastille = wpea_get_field( get_the_ID(), WPea::$options['front']['field_pastille'] );
                endif;
                $html .= '<li>';
                if( ! empty( WPea::$options['front']['list_pastille'] ) and $pastille === 'oui' ) :
                    $html .= '<div class="wpea_pastille">' . WPea::$options['front']['list_pastille'] . '</div>';
                endif;
                $html .= '<a href="' . get_the_permalink() . '" class="wpea_rollover animated">' . __( 'Discover', WPEA_PLUGIN_NAME ) . '</a>';
                $html .= '<a href="' . get_the_permalink() . '">';
                if( !empty( $images ) ):
                    $image = wp_get_attachment_image_src( $images[0], 'wpe_list' );
                    if ( $counter < 7 or WPea::$options['front']['lazy_load'] != 1 ) :
                        $html .= '<img src="' . $image[0] .'" width="' . $image[1] . '" height="' . $image[2] . '" />';
                    else :
                        $html .= '<img class="lazy" data-original="' . $image[0] . '" width="' . $image[1] . '" height="' . $image[2] . '" />';
                    endif;
                else:
                    if ( $counter < 7 or WPea::$options['front']['lazy_load'] != 1 ) :
                        $html .= '<img class="wpea-no-photo" src="' . plugin_dir_url( __FILE__ ) . '../images/no-photo.png" width="' . WPea::$options['images']['wpe_list']['width'] . '" height="' . WPea::$options['images']['wpe_list']['height'] . '" />';
                    else :
                        $html .= '<img class="lazy wpea-no-photo" data-original="' . plugin_dir_url( __FILE__ ) . '../images/no-photo.png" width="' . WPea::$options['images']['wpe_list']['width'] . '" height="' . WPea::$options['images']['wpe_list']['height'] . '" />';
                    endif;
                endif;
                $html .= '</a><br />';
                $html .= WPea_Tools::fields_replaced_string( array(
                    'source' => 'wp',
                    'post_id' => get_the_ID(),
                    'mask' => WPea::$options['front']['list_title'],
                    'linked' => true,
                    'truncate' => 9,
                ) );
                $html .= '</li>';
            endwhile;
            $html .= '</ul>';
            $html .= self::paging_nav( $r );
        else:
            $html .= '<p class="wpea-no-results">';
            if ( ! empty( WPea::$options['front']['contact_page_id'] ) ):
                $html .= sprintf( __( 'There is no result for your search but we have perhaps the property of your dreams. <a href="%s">Please click here to contact us!</a>', WPEA_PLUGIN_NAME ), get_permalink( WPea::$options['front']['contact_page_id'] ) );
            else:
            $html .= __( 'There is no result for your search.', WPEA_PLUGIN_NAME );
            endif;
            $html .= '<p>';
        endif;
        return $html;
    }
    
    /**
     * Display navigation when applicable.
     *
     * @param type $query
     * @return type
     * @since 1.0
     */
    public static function paging_nav( $query ) {
        // Don't print empty markup if there's only one page.
        if ( $query->max_num_pages < 2 ) :
            return;
        endif;

        $paged        = $query->query['paged'] ? intval( $query->query['paged']) : 1;
        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $query_args   = array();
        $url_parts    = explode( '?', $pagenum_link );

        if ( isset( $url_parts[1] ) ) {
            wp_parse_str( $url_parts[1], $query_args );
        }

        $pagenum_link = esc_url( remove_query_arg( array_keys( $query_args ), $pagenum_link ) );
        $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

        $format = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

        // Set up paginated links.
        $links = paginate_links( array(
            'base'      => $pagenum_link,
            'format'    => $format,
            'total'     => $query->max_num_pages,
            'current'   => $paged,
            'mid_size'  => 1,
            'add_args'  => WPea_Tools::array_map_recursive( 'urlencode', $query_args ),
            'prev_next' => false,
        ) );

        if ( $links ) :
            return '<nav class="wpea-paging-navigation" role="navigation">' .
                    '<div class="wpea-pagination">' .
                        $links .
                    '</div>' .
                '</nav>';
        endif;
    }
        
    /**
     * Return group object
     * 
     * @param type $id
     * @return type
     */
    public static function get_group( $id ){
        foreach( parent::$groups as $group ) :
            if ( $group['id'] == $id ) :
                return $group;
            endif;
        endforeach;
    }

    /**
     * Add opengraph to doctype
     * @param type $output
     * @return type
     */
    public static function add_opengraph_doctype( $output ) {
        return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
    }
    
   /**
 * Add open graph meta in head
 * 
 * @global type $post
 * @return type
 */
public static function insert_fb_in_head() {
    global $post;
    if ( ! is_singular() ) //if it is not a post or a page
        return;
    echo '<meta property="og:title" content="' . $post->post_title . '"/>';
    echo '<meta property="og:description" content="' . wp_strip_all_tags( $post->post_content ) . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . $post->guid . '"/>';
    echo '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '"/>';
    $images = wpea_get_field( get_the_ID(), 'images' );
    if ( ! empty( $images ) ) :
        $image = wp_get_attachment_image_src( $images[0], 'wpe_detail' );
        echo '<meta property="og:image" content="' . esc_attr( $image[0] ) . '"/>';
    else :
        echo '<meta property="og:image" content="' . plugin_dir_url( __FILE__ ) . '../../images/no-photo.png"/>';

    endif;
}

}