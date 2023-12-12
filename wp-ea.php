<?php
/**
 * Plugin Name: wordpress estate agency
 * Description: Maximize your real estate business potential with our advanced WordPress Estate Agency Plugin. Designed to streamline property listings and enhance user experience, this plugin offers a sleek, user-friendly interface with customizable options. Key features include detailed property profiles, interactive maps, advanced search filters, and easy-to-manage client inquiries. Optimized for SEO, it ensures your listings rank higher in search results. Responsive design ensures a seamless display on all devices, boosting your online presence and client engagement. Upgrade your real estate website with this powerful, efficient tool.
 * Version: 1.0.0
 * Author: Hexadecaedre
 * Author URI: https://hexadecaedre.com
 * Text Domain: wpea
 */

defined( 'ABSPATH' ) or exit;

define( 'WPEA_PLUGIN_NAME', 'wp-ea');
define( 'WPEA_POST_TYPE', 'property');

require_once( plugin_dir_path( __FILE__ ) . 'includes/wpea.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/wpea-widgets.php' );

register_deactivation_hook( __FILE__, array( 'WPea', 'deactivation' ) );
register_uninstall_hook(    __FILE__, array( 'WPea', 'uninstall' ) );

add_action( 'init', array( 'WPea', 'init' ) );
