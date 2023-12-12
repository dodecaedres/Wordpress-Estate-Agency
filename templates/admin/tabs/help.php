<?php defined( 'ABSPATH' ) or exit; ?>
<div id="post-body-content">
    <div class="meta-box-sortables ui-sortable">
        <div class="postbox">
            <h3 class="hndle"><?php _e( 'Breadcrumbs', WPEA_PLUGIN_NAME ); ?></h3>
            <div class="inside">
                <p>
                    <?php _e( 'If you use WP Estate Agency templates and the WordPress SEO plugin by Yoast, you can enable the breadcrumbs. WP Estate Agency templates support WordPress SEO breadcrumbs and will display them.', WPEA_PLUGIN_NAME ); ?>
                </p>
            </div>
        </div>
        <div class="postbox">
            <h3 class="hndle"><?php _e( 'Scheduled task', WPEA_PLUGIN_NAME ); ?></h3>
            <div class="inside">
                <p>
                    <?php _e( 'If you want to use the scheduled task, we recommend you disable the default WordPress CRON and configure an automatic task on your hosting.', WPEA_PLUGIN_NAME ); ?><br />
                    <?php _e( 'To disable the native WordPress CRON, add these lines in the wp-config.php file:', WPEA_PLUGIN_NAME ); ?>
                </p>
                <code>define('DISABLE_WP_CRON', 'true');</code>
                <p>
                    <?php _e( "Next, add the wp-cron.php script in your hosting CRON tab. Otherwise <strong>native and vital functions of WordPress no longer work</strong> (planning posts for example).", WPEA_PLUGIN_NAME ); ?><br />
                    <?php _e( "Schedule the CRON job every hour minimum.", WPEA_PLUGIN_NAME ); ?>
                </p>
            </div>
        </div>
        <div class="postbox">
            <h3 class="hndle"><?php _e( 'Available fields', WPEA_PLUGIN_NAME ); ?></h3>
            <div class="inside">
                <p><?php _e( 'You can use this fields to configure WP Estate Agency (i.e. for H1 titles):', WPEA_PLUGIN_NAME ); ?></p>
                <table class="wpea-table-bordered">
                    <thead>
                        <tr>
                            <th><?php _e( 'Key', WPEA_PLUGIN_NAME ); ?></th>
                            <th><?php _e( 'Description', WPEA_PLUGIN_NAME ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( self::$fields as $key => $tab ) : ?>
                            <?php if ( $key == self::$platform['images_key'] ) : $key = 'images'; endif; ?>
                            <tr>
                                <td><?php echo $key; ?></td>
                                <td class="description"><?php echo $tab['name']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <h2><?php _e( 'WP Estate Agency widgets', WPEA_PLUGIN_NAME ); ?></h2>
        <div class="postbox">
            <h3 class="hndle">WPea_Widget_Search</h3>
            <div class="inside">
                <p><?php _e( 'Display a search box. Search boxes are defined in <a href="?page=wp-ea&amp;tab=search">WP Estate Agency settings</a>.', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Parameters', WPEA_PLUGIN_NAME ); ?></h4>
                <p><code><&#63;php the_widget( 'WPea_Widget_Search', <em>array</em> $widget_instance, <em>array</em> $widget_args ); &#63;></code></p>
                <ul class="wpea-admin-list">
                    <li> $widget_args['start_wrapper'] : <?php _e( 'Add your HTML wrapper for the widget.', WPEA_PLUGIN_NAME ); ?></li>
                    <li> $widget_args['before_widget']</li>
                    <li> $widget_args['before_title']</li>
                    <li> $widget_args['after_title']</li>
                    <li> $widget_args['after_widget']</li>
                    <li> $widget_args['end_wrapper'] : <?php _e( 'End of your HTML wrapper', WPEA_PLUGIN_NAME ); ?></li>
                    <li> $widget_instance['title']</li>
                    <li> $widget_instance['type'] : <?php _e( 'Search type. Availables values are <em>full</em> or <em>basic</em>', WPEA_PLUGIN_NAME ); ?></li>
                    <li> $widget_instance['title'] : <?php _e( 'Title for your search box.', WPEA_PLUGIN_NAME ); ?></li>
                </ul>
                <h4><?php _e( 'Usage', WPEA_PLUGIN_NAME ); ?></h4>
                <?php _e( 'Appearance menu or ', WPEA_PLUGIN_NAME ); ?><code>the_widget( 'WPea_Widget_Search', $widget_instance, $widget_args );</code><?php _e( 'in your templates.', WPEA_PLUGIN_NAME ); ?>
            </div>
        </div>
        <div class="postbox">
            <h3 class="hndle">WPea_Widget_Group</h3>
            <div class="inside">
                <p><?php _e( 'Display a group of WP Estate Agency fields. Groups are defined in <a href="?page=wp-ea&amp;tab=groups">WP Estate Agency settings</a>.', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Parameters', WPEA_PLUGIN_NAME ); ?></h4>
                <p><code><&#63;php the_widget( 'WPea_Widget_Group', <em>array</em> $widget_instance, <em>array</em> $widget_args ); &#63;></code></p>
                <ul class="wpea-admin-list">
                    <li> $widget_args['before_widget']</li>
                    <li> $widget_args['before_title']</li>
                    <li> $widget_args['after_title']</li>
                    <li> $widget_args['after_widget']</li>
                    <li> $widget_instance['title']</li>
                    <li> $widget_instance['id'] : <?php _e( 'The ID of the group. It\'s displayed in the <a href="?page=wp-ea&amp;tab=groups">WP Estate Agency settings</a>.', WPEA_PLUGIN_NAME ); ?></li>
                    <li> $widget_instance['show_title'] : <?php _e( 'Weither to show the title of the fields group or not.', WPEA_PLUGIN_NAME ); ?></li>
                </ul>
                <h4><?php _e( 'Usage', WPEA_PLUGIN_NAME ); ?></h4>
                <?php _e( 'Appearance menu or ', WPEA_PLUGIN_NAME ); ?><code>the_widget( 'WPea_Widget_Group', array( 'id' => 2 ) );</code><?php _e( 'in your templates.', WPEA_PLUGIN_NAME ); ?>
            </div>
        </div>
        <div class="postbox">
            <h3 class="hndle">WPea_Widget_Last_Properties</h3>
            <div class="inside">
                <p><?php _e( 'Display last properties in an unorderd list.', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Parameters', WPEA_PLUGIN_NAME ); ?></h4>
                <p><code><&#63;php the_widget( 'WPea_Widget_Last_Properties', <em>array</em> $widget_instance, <em>array</em> $widget_args ); &#63;></code></p>
                <ul class="wpea-admin-list">
                    <li> $widget_args['before_widget']</li>
                    <li> $widget_args['before_title']</li>
                    <li> $widget_args['after_title']</li>
                    <li> $widget_args['after_widget']</li>
                    <li> $widget_instance['title']</li>
                    <li> $widget_instance['number'] : <?php _e( 'number of propeties to display.', WPEA_PLUGIN_NAME ); ?></li>
                    <li> $widget_instance['condition'] : <?php _e( 'Use a field as a condition in the query. The field must be a "yesno" type. The value set in the query is "yes".', WPEA_PLUGIN_NAME ); ?></li>
                </ul>
                <h4><?php _e( 'Usage', WPEA_PLUGIN_NAME ); ?></h4>
                <?php _e( 'Appearance menu or ', WPEA_PLUGIN_NAME ); ?><code>the_widget( 'WPea_Widget_Last_Properties', $widget_instance, $widget_args );</code><?php _e( 'in your templates.', WPEA_PLUGIN_NAME ); ?>
            </div>
        </div>
        <h2><?php _e( 'WP Estate Agency functions', WPEA_PLUGIN_NAME ); ?></h2>
        <div class="postbox">
            <h3 class="hndle">wpea_list()</h3>
            <div class="inside">
                <p><?php _e( 'Build a unordered list with properties', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Parameters', WPEA_PLUGIN_NAME ); ?></h4>
                <p><?php _e( 'No parameters.', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Usage', WPEA_PLUGIN_NAME ); ?></h4>
                <code>wpea_list();</code>
            </div>
        </div>
        <div class="postbox">
            <h3 class="hndle">wpea_get_items()</h3>
            <div class="inside">
                <p><?php _e( 'Returns query object filtered on published WP Estate Agency custom post type and paginated if needed. Then simply use it like the WordPress query (have_posts(), the_post()...).', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Parameters', WPEA_PLUGIN_NAME ); ?></h4>
                <p><?php _e( 'No parameters.', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Usage', WPEA_PLUGIN_NAME ); ?></h4>
                <code>$wpea_query = wpea_get_items();</code>
            </div>
        </div>
        <div class="postbox">
            <h3 class="hndle">wpea_paging_nav()</h3>
            <div class="inside">
                <p><?php _e( 'Display navigation when applicable.', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Parameters', WPEA_PLUGIN_NAME ); ?></h4>
                <p><?php _e( 'No parameters.', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Usage', WPEA_PLUGIN_NAME ); ?></h4>
                <code>wpea_paging_nav();</code>
            </div>
        </div>
        <div class="postbox">
            <h3 class="hndle">wpea_get_field()</h3>
            <div class="inside">
                <p><?php _e( 'Returns the value of the specified field.<br />If the field type is a taxonomy, the returned result will be the taxonomy value.', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Parameters', WPEA_PLUGIN_NAME ); ?></h4>
                <p><code><&#63;php $field = wpea_get_field( <em>int</em> $post_id, <em>mixed</em> $field_key ); &#63;></code></p>
                <ul class="wpea-admin-list">
                    <li> $post_id : <?php _e( 'specific post ID where your value was entered <em>(required)</em>', WPEA_PLUGIN_NAME ); ?></li>
                    <li> $field_key : <?php _e( 'the name of the field to be retrieved. eg “reference” <em>(required)</em>', WPEA_PLUGIN_NAME ); ?></li>
                </ul>
                <h4><?php _e( 'Usage', WPEA_PLUGIN_NAME ); ?></h4>
                <code>$value = wpea_get_field( "text_field", 123 );</code>
            </div>
        </div>
        <div class="postbox">
            <h3 class="hndle">wpea_get_energy_diagrams()</h3>
            <div class="inside">
                <p><?php _e( 'Displays the energy diagrams.<br />Background images are png and located in the “images” directory of WP Estate Agency plugin.', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Parameters', WPEA_PLUGIN_NAME ); ?></h4>
                <p><code><&#63;php wpea_get_energy_diagrams( <em>int</em> $post_id ); &#63;></code></p>
                <ul class="wpea-admin-list">
                    <li> $post_id : <?php _e( 'specific post ID <em>(required)</em>', WPEA_PLUGIN_NAME ); ?></li>
                </ul>
                <h4><?php _e( 'Usage', WPEA_PLUGIN_NAME ); ?></h4>
                <code>wpea_get_energy_diagrams( 123 );</code>
            </div>
        </div>
        <div class="postbox">
            <h3 class="hndle">wpea_get_addthis_buttons()</h3>
            <div class="inside">
                <p><?php _e( 'Displays AddThis share buttons and JavaScript call. Buttons displayed are configured in the WP Estate Agency settings page.', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Parameters', WPEA_PLUGIN_NAME ); ?></h4>
                <p><?php _e( 'No parameters.', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Usage', WPEA_PLUGIN_NAME ); ?></h4>
                <code>wpea_get_addthis_buttons();</code>
            </div>
        </div>
        <div class="postbox">
            <h3 class="hndle">wpea_get_custom_data()</h3>
            <div class="inside">
                <p><?php _e( 'Returns the value of the custom data configured in WP Estate Agency settings.<br />Please note the custom data only accepts JSON.', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Parameters', WPEA_PLUGIN_NAME ); ?></h4>
                <p><?php _e( 'No parameters.', WPEA_PLUGIN_NAME ); ?></p>
                <h4><?php _e( 'Usage', WPEA_PLUGIN_NAME ); ?></h4>
                <code>$value = wpea_get_custom_data();</code>
            </div>
        </div>
    </div>
</div>