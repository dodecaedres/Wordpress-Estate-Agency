<?php
/*
 * Default parameters
 * 
 * WPea::$platform = array(
 *      'type' => Feed type, only xml is currently supported,
 *      'name' => Display name for the platform,
 *      'item_node' => Node for each item to import,
 *      'id_type' => item_node_attribute or node
 *      'unicity_key' => Node for unicity key (i.e. reference),
 *      'title_key' => Node to use for post title (i.e. titre),
 *      'if_empty_title' => Node to use if title node is empty,
 *      'description_key' => Node to use for post content (i.e. description_internet),
 *      'images_key' => Node to use for images (i.e. images),
 *      'dpe_key' => Key to use for DPE diagram,
 *      'ges_key' => Key to use for GES diagram,
 * );
 * 
 * Fields to set
 * WPea::$fields = array(
 *      meta_key => array(
 *          'type' => 'text', 'tel', 'email', 'taxonomy', 'number', 'yesno' or 'images'
 *          'name' => Display name (you can use translate functions),
 *          'active' => 0 or 1, set default activation for the field, can be changed in WP Estate Agency settings,
 *          'taxonomy' => only for 'taxononmy' type, specified the key in $taxonomies array,
 *          'unit' => string displayed next to the field in custom post informations metabox,
 *          'help' => string displayed under the field in custom post informations metabox for help,
 *          'format'  => only for 'date' type, set the date format (i.e. 'dd-mm-yyyy'),
 *      ),
 * 
 * Taxonomies to set
 * WPea::$taxonomies = array(
 *      taxonomy_slug  => array(
 *          'active'  => 0 or 1, set default activation for the taxonomy, can be changed in WP Estate Agency settings,
 *          'labels' => array(
 *              'name'=> Label for name (you can use translate functions),
 *              'singular_name' => Label for singular_name (you can use translate functions),
 *              'all_items' => Label for all_items (you can use translate functions),
 *              'edit_item' => Label for edit_item (you can use translate functions),
 *              'view_item' => Label for view_item (you can use translate functions),
 *              'update_item' => Label for update_item (you can use translate functions),
 *              'add_new_item' => Label for add_new_item (you can use translate functions),
 *              'new_item_name' => Label for new_item_name (you can use translate functions),
 *              'search_items' => Label for search_items (you can use translate functions),
 *              'popular_items' => Label for popular_items (you can use translate functions),
 *              'separate_items_with_commas' => Label for separate_items_with_commas (you can use translate functions),
 *              'add_or_remove_items' => Label for add_or_remove_items (you can use translate functions),
 *              'choose_from_most_used' => Label for choose_from_most_used (you can use translate functions),
 *              'not_found' => Label for not_found (you can use translate functions),
 *          ),
 *          'terms' => array( 
 *              each term you want to add in taxonomy,
 *          ),
 *      );
 * 
 */

class WPea_Default extends WPea {

    public static function set_data() {
        
        parent::$platform = array(
            'type'            => 'xml',
            'name'            => __( 'Default', WPEA_PLUGIN_NAME ),
            'item_node'       => 'bien',
            'id_type'         => 'item_node_attribute',
            'unicity_key'     => 'reference',
            'title_key'       => 'titre',
            'description_key' => 'description',
            'images_key'      => 'images',
            'dpe_key'         => 'valeur_energie',
            'ges_key'         => 'valeur_ges',
        );

        parent::$fields = array(
            'reference'            => array(
                'type'   => 'text',
                'name'   => __( 'Property reference', WPEA_PLUGIN_NAME ),
                'active' => 1,
            ),
            'type_transaction'     => array(
                'type'      => 'taxonomy',
                'taxonomy'  => 'transaction_type',
                'name'      => __( 'Transaction type', WPEA_PLUGIN_NAME ),
                'active'    => 1,
            ),
            'type_bien'         => array(
                'type'      => 'taxonomy',
                'taxonomy'  => 'property_type',
                'name'      => __( 'Property type', WPEA_PLUGIN_NAME ),
                'active'    => 1,
            ),
            'prix'                 => array(
                'type'   => 'number',
                'name'   => __( 'Selling price or monthly rent charges included', WPEA_PLUGIN_NAME ),
                'unit'   => '€',
                'active' => 1,
                'format' => 'price',
            ),
            'titre'                => array(
                'type'   => 'text',
                'name'   => __( 'Ad title', WPEA_PLUGIN_NAME ),
                'active' => 1,
            ),
            'description' => array(
                'type'   => 'text',
                'name'   => __( 'Property description', WPEA_PLUGIN_NAME ),
                'active' => 1,
            ),
            'code_postal'          => array(
                'type'   => 'text',
                'name'   => __( 'Property zip code', WPEA_PLUGIN_NAME ),
                'active' => 0,
            ),
            'ville'                => array(
                'type'   => 'text',
                'name'   => __( 'Property city', WPEA_PLUGIN_NAME ),
                'active' => 0,
            ),
            'nombre_pieces'             => array(
                'type'   => 'number',
                'name'   => __( 'Number of rooms', WPEA_PLUGIN_NAME ),
                'active' => 0,
            ),
            'surface'    => array(
                'type'   => 'number',
                'name'   => __( 'Living surface', WPEA_PLUGIN_NAME ),
                'unit'   => 'm²',
                'active' => 1,
            ),
            'images'               => array(
                'type'    => 'group',
                'node'    => 'image',
                'content' => 'url',
                'name'    => __( 'Images', WPEA_PLUGIN_NAME ),
                'active'  => 1,
            ),
            'nouveaute'           => array(
                'type'   => 'yesno',
                'name'   => __( 'New', WPEA_PLUGIN_NAME ),
                'active' => 1,
            ),
            'surface_terrain'      => array(
                'type'   => 'number',
                'name'   => __( 'Plot area', WPEA_PLUGIN_NAME ),
                'unit'   => 'm²',
                'active' => 1,
            ),
            'bilan_energie'        => array(
                'type'   => 'text',
                'name'   => __( 'Energy consumption category', WPEA_PLUGIN_NAME ),
                'help'   => __( 'letter', WPEA_PLUGIN_NAME ),
                'active' => 1,
            ),
            'valeur_energie'       => array(
                'type'   => 'number',
                'name'   => __( 'Energy consumption value', WPEA_PLUGIN_NAME ),
                'help'   => __( 'numerical value', WPEA_PLUGIN_NAME ),
                'active' => 1,
            ),
            'bilan_ges'            => array(
                'type'   => 'text',
                'name'   => __( 'Category gas emissions greenhouse', WPEA_PLUGIN_NAME ),
                'help'   => __( 'letter', WPEA_PLUGIN_NAME ),
                'active' => 1,
            ),
            'valeur_ges'           => array(
                'type'   => 'number',
                'name'   => __( 'Value of greenhouse gas emissions', WPEA_PLUGIN_NAME ),
                'help'   => __( 'numerical value', WPEA_PLUGIN_NAME ),
                'active' => 1,
            ),
        );
        parent::$all_fields = parent::$fields;

        parent::$taxonomies = array(
            'transaction_type'  => array(
                'active'  => 1,
                'rewrite' => true,
                'labels' => array(
                    'name'                       => __( 'Transaction types', WPEA_PLUGIN_NAME ),
                    'singular_name'              => __( 'Transaction type', WPEA_PLUGIN_NAME ),
                    'all_items'                  => __( 'All transaction types', WPEA_PLUGIN_NAME ),
                    'edit_item'                  => __( 'Edit type', WPEA_PLUGIN_NAME ),
                    'view_item'                  => __( 'View type', WPEA_PLUGIN_NAME ),
                    'update_item'                => __( 'Update type', WPEA_PLUGIN_NAME ),
                    'add_new_item'               => __( 'Add new type', WPEA_PLUGIN_NAME ),
                    'new_item_name'              => __( 'New type name', WPEA_PLUGIN_NAME ),
                    'search_items'               => __( 'Search types', WPEA_PLUGIN_NAME ),
                    'popular_items'              => __( 'Popular types', WPEA_PLUGIN_NAME ),
                    'separate_items_with_commas' => __( 'Separate types with commas', WPEA_PLUGIN_NAME ),
                    'add_or_remove_items'        => __( 'Add or remove types', WPEA_PLUGIN_NAME ),
                    'choose_from_most_used'      => __( 'Choose from most used', WPEA_PLUGIN_NAME ),
                    'not_found'                  => __( 'Not found', WPEA_PLUGIN_NAME ),
                ),
                'terms' => array(
                    'vente',
                    'location',
                ),
            ),
            'property_type'     => array(
                'active'  => 1,
                'rewrite' => array(
                    'slug' => 'annonces-immobilieres',
                ),
                'labels' => array(
                    'name'                       => __( 'Property types', WPEA_PLUGIN_NAME ),
                    'singular_name'              => __( 'Property type', WPEA_PLUGIN_NAME ),
                    'all_items'                  => __( 'All property types', WPEA_PLUGIN_NAME ),
                    'edit_item'                  => __( 'Edit type', WPEA_PLUGIN_NAME ),
                    'view_item'                  => __( 'View type', WPEA_PLUGIN_NAME ),
                    'update_item'                => __( 'Update type', WPEA_PLUGIN_NAME ),
                    'add_new_item'               => __( 'Add new type', WPEA_PLUGIN_NAME ),
                    'new_item_name'              => __( 'New type name', WPEA_PLUGIN_NAME ),
                    'search_items'               => __( 'Search types', WPEA_PLUGIN_NAME ),
                    'popular_items'              => __( 'Popular types', WPEA_PLUGIN_NAME ),
                    'separate_items_with_commas' => __( 'Separate types with commas', WPEA_PLUGIN_NAME ),
                    'add_or_remove_items'        => __( 'Add or remove types', WPEA_PLUGIN_NAME ),
                    'choose_from_most_used'      => __( 'Choose from most used', WPEA_PLUGIN_NAME ),
                    'not_found'                  => __( 'Not found', WPEA_PLUGIN_NAME )
                ),
                'terms' => array(
                    'belle propriété',
                    'maison',
                    'fermette',
                    'terrain',
                    'appartement',
                    'pavillon',
                ),
            ),
        );
        parent::$all_taxonomies = parent::$taxonomies;
                
    }

}
