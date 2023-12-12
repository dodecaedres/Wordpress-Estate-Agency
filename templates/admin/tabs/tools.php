<?php
defined( 'ABSPATH' ) or exit;
$available_tools = 0;
?>
<div id="post-body-content">
    <div class="meta-box-sortables ui-sortable">
        <div class="postbox">
            <div class="inside">
                <ul class="wpea-admin-list">
                    <?php if ( ! empty( self::$options['feed_url'] ) and self::$platform['external_feed'] ) : $available_tools ++;?>
                    <li>
                        <a class="confirm-link" data-txt="<?php _e( "You're going to process to feed importation. Continue ?", WPEA_PLUGIN_NAME ); ?>" href="?page=<?php echo WPEA_PLUGIN_NAME; ?>&amp;tab=import&amp;action=process">
                            <?php _e( 'Force process feed', WPEA_PLUGIN_NAME ); ?>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php $nb_properties = wp_count_posts( WPEA_POST_TYPE ); ?>
                    <?php if ( $nb_properties->publish > 0 or $nb_properties->draft > 0 ) : $available_tools ++; ?>
                    <li>
                        <a class="confirm-link" data-txt="<?php _e( "You're going to delete all WP Estate Agency items. Continue ?", WPEA_PLUGIN_NAME ); ?>" href="?page=<?php echo WPEA_PLUGIN_NAME; ?>&amp;tab=delete&amp;action=process">
                            <?php _e( 'Delete all properties', WPEA_PLUGIN_NAME ); ?>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
                <?php if ( $available_tools == 0 ) : ?>
                    <p><?php _e( 'No tool available. Fill the feed URL or import properties to enable them.', WPEA_PLUGIN_NAME ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>