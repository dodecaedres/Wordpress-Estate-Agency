<?php
/**
 * This file controls all of the content from the Settings page.
 */
# Exit if accessed directly
defined( 'ABSPATH' ) or exit;
$message = '';
$notice_class = 'updated';
$notice_style = '';
$text_goback = sprintf( __( 'To go back to the previous page, <a href="%s">click here</a>.', WPEA_PLUGIN_NAME ), 'javascript:history.go(-1)' );
$links = array(
    'main' => '?page=' . WPEA_PLUGIN_NAME,
    'groups' => '?page=' . WPEA_PLUGIN_NAME . '&amp;tab=groups',
    'search' => '?page=' . WPEA_PLUGIN_NAME . '&amp;tab=search',
    'tools' => '?page=' . WPEA_PLUGIN_NAME . '&amp;tab=tools',
    'help' => '?page=' . WPEA_PLUGIN_NAME . '&amp;tab=help',
);

$current_tab = WPea_Admin::get_current_tab();
$current_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

switch ($current_action):
    // Save settings
    case 'save' :
        //test nonce
        if ( !wp_verify_nonce( $_POST['wpea_settings_nonce'], 'wpea_settings' ) ):
            $message      = __( 'Nonce error.', WPEA_PLUGIN_NAME );
            $notice_class = 'error';
        //test droits
        elseif ( !current_user_can( 'manage_options' ) ):
            $message      = '<p><strong>' . __( 'You are not allowed to change the settings.', WPEA_PLUGIN_NAME ) . '</strong></p>';
            $notice_class = 'error';
        else:
            WPea_Process::save_options();
            $message      = '<p><strong>' . __( 'Your settings have been saved.', WPEA_PLUGIN_NAME ) . '</strong></p>';
            $notice_style = 'display:block;';
        endif;
        break;
    // Save search boxes
    case 'save_search' :
        //test nonce
        if ( !wp_verify_nonce( $_POST['wpea_search_nonce'], 'wpea_settings' ) ):
            $message      = __( 'Nonce error.', WPEA_PLUGIN_NAME );
            $notice_class = 'error';
        //test droits
        elseif ( !current_user_can( 'manage_options' ) ):
            $message      = '<p><strong>' . __( 'You are not allowed to change the settings.', WPEA_PLUGIN_NAME ) . '</strong></p>';
            $notice_class = 'error';
        else:
            WPea_Process::save_search_boxes();
            $message      = '<p><strong>' . __( 'Your search boxes have been saved.', WPEA_PLUGIN_NAME ) . '</strong></p>';
            $notice_style = 'display:block;';
        endif;
        break;
    // Save groups
    case 'save_groups' :
        //test nonce
        if ( !wp_verify_nonce( $_POST['wpea_groups_nonce'], 'wpea_settings' ) ):
            $message      = __( 'Nonce error.', WPEA_PLUGIN_NAME );
            $notice_class = 'error';
        //test droits
        elseif ( !current_user_can( 'manage_options' ) ):
            $message      = '<p><strong>' . __( 'You are not allowed to change the settings.', WPEA_PLUGIN_NAME ) . '</strong></p>';
            $notice_class = 'error';
        else:
            WPea_Process::save_groups();
            $message      = '<p><strong>' . __( 'Your groups have been saved.', WPEA_PLUGIN_NAME ) . '</strong></p>';
            $notice_style = 'display:block;';
        endif;
        break;
    // Import or Delete
    case 'process' :
        switch ( $current_tab ):
            // Import
            case 'import':
                if ( WPea_Tools::is_file( self::$options['feed_url'] ) === false ):
                    $message      = '<p><strong>' . __( 'WP Estate Agency feed not found.', WPEA_PLUGIN_NAME ) . '</strong></p>';
                    $notice_class = 'error';
                else:
                    $process_tab = WPea_Process::prepare_import();
                endif;
                break;
            // Delete
            case 'delete' :
                $process_tab['process'] = WPea_Process::prepare_delete();
                break;
            // Default, nothing to do here
            default :
                break;
        endswitch;
        break;
    // Default, nothing to do here
    default :
        break;
endswitch;
?>
<noscript><p><em><?php _e( 'You must enable Javascript in order to proceed!', WPEA_PLUGIN_NAME ) ?></em></p></noscript>

<div id="message" class="<?php echo $notice_class; ?> fade" style="<?php echo $notice_style; ?>"><?php echo $message; ?></div>

<div class="wrap">
    <h2>WP Estate Agency</h2>
    <h2 class="nav-tab-wrapper">
        <a class="nav-tab<?php echo ( $current_tab === 'main' ? ' nav-tab-active' : '' ); ?>" href="<?php echo $links['main']; ?>"><?php _e( 'Settings', WPEA_PLUGIN_NAME ); ?></a>
        <a class="nav-tab<?php echo ( $current_tab === 'groups' ? ' nav-tab-active' : '' ); ?>" href="<?php echo $links['groups']; ?>"><?php _e( 'Field groups', WPEA_PLUGIN_NAME ); ?></a>
        <a class="nav-tab<?php echo ( $current_tab === 'search' ? ' nav-tab-active' : '' ); ?>" href="<?php echo $links['search']; ?>"><?php _e( 'Search boxes', WPEA_PLUGIN_NAME ); ?></a>
        <?php if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'process'): ?>
            <span id="wpea-process-tab" class="nav-tab nav-tab-active"><?php echo sprintf( __( '%s in progress...', WPEA_PLUGIN_NAME ), $current_tab == 'delete' ? __( 'Deletion', WPEA_PLUGIN_NAME ) : __( 'Import', WPEA_PLUGIN_NAME ) ); ?></span>
        <?php endif; ?>
        <a class="nav-tab<?php echo ( $current_tab === 'tools' ? ' nav-tab-active' : ''  ); ?>" href="<?php echo $links['tools']; ?>"><?php _e( 'Tools', WPEA_PLUGIN_NAME ); ?></a>
        <a class="nav-tab<?php echo ( $current_tab === 'help' ? ' nav-tab-active' : ''  ); ?>" href="<?php echo $links['help']; ?>"><?php _e( 'Help', WPEA_PLUGIN_NAME ); ?></a>
    </h2>
    <div class="wpea-credits alignright"><?php _e( 'WP Estate Agency is a tool developed by <a href="https://dev.hexadecaedre.fr" target="_blank">Hexadecaedre</a>.', WPEA_PLUGIN_NAME ); ?></div>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder" data-tab="<?php echo $current_tab; ?>">
            <?php include( plugin_dir_path( __FILE__ ) . 'tabs/' . $current_tab . '.php' ); ?>
        </div><!-- #post-body -->
    </div><!-- #poststuff -->
</div><!-- .wrap -->