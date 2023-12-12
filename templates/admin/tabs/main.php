<?php defined( 'ABSPATH' ) or exit; ?>
<form class="wpea-admin-form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<?php wp_nonce_field( 'wpea_settings', 'wpea_settings_nonce' ); ?>
    <p class="submit overflow">
        <input class="button button-primary alignright" type="submit" value="<?php _e( 'Save changes', WPEA_PLUGIN_NAME ); ?>" name="submit" required="required" />
    </p>
    <div id="post-body-content">
        <div class="meta-box-sortables ui-sortable">
        <?php if ( isset(self::$platform['external_feed']) && self::$platform['external_feed'] ) : ?>
<div class="postbox">
    <h3 class="hndle"><?php _e( 'Feed', WPEA_PLUGIN_NAME ); ?></h3>
                <div class="inside">
                    <table class="form-table post-box">
                        <tbody>
                            <tr>
                                <th>
                                    <label><?php _e( 'Real estate software', WPEA_PLUGIN_NAME ); ?></label>
                                </th>
                                <td>
                                    <?php echo self::$platform['name']; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label><?php _e( 'Feed URL', WPEA_PLUGIN_NAME ); ?></label>
                                </th>
                                <td>
                                    <input type="text" class="large-text" name="wpea_options[feed_url]" value="<?php echo self::$options['feed_url']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Properties not in feed', WPEA_PLUGIN_NAME ); ?></th>
                                <td>
                                    <label><input type="radio" value="delete" <?php echo ( self::$options['not_in_feed'] == 'delete' ? ' checked="checked"' : '' ); ?> name="wpea_options[not_in_feed]" /><?php _e( 'Delete', WPEA_PLUGIN_NAME ); ?></label>&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" value="draft" <?php echo ( self::$options['not_in_feed'] == 'draft' ? ' checked="checked"' : '' ); ?> name="wpea_options[not_in_feed]" /><?php _e( 'Set to draft', WPEA_PLUGIN_NAME ); ?></label>&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" value="trash" <?php echo ( self::$options['not_in_feed'] == 'trash' ? ' checked="checked"' : '' ); ?> name="wpea_options[not_in_feed]" /><?php _e( 'Move to trash', WPEA_PLUGIN_NAME ); ?></label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            <div class="postbox">
                <h3 class="hndle"><?php _e( 'Agency', WPEA_PLUGIN_NAME ); ?></h3>
                <div class="inside">
                    <table class="form-table post-box">
                        <tbody>
                            <tr>
                                <th>
                                    <label><?php _e( 'Name', WPEA_PLUGIN_NAME ); ?></label>
                                </th>
                                <td>
                                    <input type="text" class="regular-text" name="wpea_options[agency][name]" value="<?php echo self::$options['agency']['name']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label><?php _e( 'Phone', WPEA_PLUGIN_NAME ); ?></label>
                                </th>
                                <td>
                                    <input type="text" class="regular-text" name="wpea_options[agency][tel]" value="<?php echo self::$options['agency']['tel']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label><?php _e( 'Email', WPEA_PLUGIN_NAME ); ?></label>
                                </th>
                                <td>
                                    <input type="text" class="regular-text" name="wpea_options[agency][email]" value="<?php echo self::$options['agency']['email']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label><?php _e( 'Logo URL', WPEA_PLUGIN_NAME ); ?></label>
                                </th>
                                <td>
                                    <input type="text" class="regular-text" name="wpea_options[agency][logo]" value="<?php echo self::$options['agency']['logo']; ?>" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
           <?php if ( isset(self::$platform['external_feed']) && self::$platform['external_feed'] ) : ?>
    <div class="postbox">
        <h3 class="hndle"><?php _e( 'Feed Settings', WPEA_PLUGIN_NAME ); ?></h3>
                <div class="inside">
                    <table class="form-table post-box">
                        <tbody>
                            <tr>
                                <th><?php _e( 'Enable', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input class="toggle-checkbox" data-toggle="toggle_cron" type="checkbox" <?php echo ( self::$options['cron']['active'] == 1 ? ' checked="checked"' : '' ); ?> value="1" name="wpea_options[cron][active]" /></td>
                            </tr>
                            <tr class="toggle_cron"<?php echo ( self::$options['cron']['active'] == 1 ? '' : ' style="display:none;"' ); ?>>
                                <th><?php _e( 'Recurrence', WPEA_PLUGIN_NAME ); ?></th>
                                <td>
                                    <label><input type="radio" value="daily" <?php echo ( self::$options['cron']['recurrence'] == 'daily' ? ' checked="checked"' : '' ); ?> name="wpea_options[cron][recurrence]" /><?php _e( 'Daily', WPEA_PLUGIN_NAME ); ?></label>&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" value="twicedaily" <?php echo ( self::$options['cron']['recurrence'] == 'twicedaily' ? ' checked="checked"' : '' ); ?> name="wpea_options[cron][recurrence]" /><?php _e( 'Twice daily', WPEA_PLUGIN_NAME ); ?></label>&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" value="hourly" <?php echo ( self::$options['cron']['recurrence'] == 'hourly' ? ' checked="checked"' : '' ); ?> name="wpea_options[cron][recurrence]" /><?php _e( 'Hourly', WPEA_PLUGIN_NAME ); ?></label>
                                </td>
                            </tr>
                            <tr class="toggle_cron"<?php echo ( self::$options['cron']['active'] == 1 ? '' : ' style="display:none;"' ); ?>>
                                <th><?php _e( 'Hour', WPEA_PLUGIN_NAME ); ?></th>
                                <td>
                                    <select id="cron_hour" name="wpea_options[cron][hour]">
                                    <?php for ( $i = 0; $i <= 23; $i++ ) : ?>
                                        <option value="<?php echo $i; ?>"<?php echo str_pad( $i, 2, '0', STR_PAD_LEFT ) == self::$options['cron']['hour'] ? ' selected="selected"' : ''; ?>><?php echo str_pad( $i, 2, '0', STR_PAD_LEFT ); ?></option>
                                    <?php endfor; ?>
                                    </select>
                                    <label for="cron_hour"><?php _e( 'h', WPEA_PLUGIN_NAME ); ?></label>
                                </td>
                            </tr>
                            <tr class="toggle_cron"<?php echo ( self::$options['cron']['active'] == 1 ? '' : ' style="display:none;"' ); ?>>
                                <th><?php _e( 'Report', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input class="toggle-checkbox" data-toggle="toggle_cron_2" type="checkbox" <?php echo ( self::$options['cron']['report'] == 1 ? ' checked="checked"' : '' ); ?> value="1" name="wpea_options[cron][report]" /></td>
                            </tr>
                            <tr class="toggle_cron_2"<?php echo ( self::$options['cron']['report'] == 1 ? '' : ' style="display:none;"' ); ?>>
                                <th><?php _e( 'Report email', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input type="text" class="regular-text" name="wpea_options[cron][email]" value="<?php echo self::$options['cron']['email']; ?>" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            <div class="postbox">
                <h3 class="hndle"><?php _e( 'Admin', WPEA_PLUGIN_NAME ); ?></h3>
                <div class="inside">
                    <table class="form-table post-box">
                        <tbody>
                            <tr>
                                <th><?php _e( 'Manage properties in admin', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input class="toggle-checkbox" data-toggle="toggle_admin_taxonomy" type="checkbox" <?php echo ( self::$options['admin']['show_in_menu'] == 1 ? ' checked="checked"' : '' ); ?> value="1" name="wpea_options[admin][show_in_menu]" /></td>
                            </tr>
                            <tr class="toggle_admin_taxonomy"<?php echo ( self::$options['admin']['show_in_menu'] == 1 ? '' : ' style="display:none;"' ); ?>>
                                <th><?php _e( 'Taxonomies in properties table', WPEA_PLUGIN_NAME ); ?></th>
                                <td>
                                    <?php foreach( self::$taxonomies as $tax_key => $tax_tab ): ?>
										<?php 
										// Ensure the variable is an array
										if (!is_array(self::$options['admin']['table_taxonomies'])) {
											self::$options['admin']['table_taxonomies'] = [];
										}
										?>
										<input data-toggle="toggle_admin_taxonomy" type="checkbox" <?php echo ( in_array( $tax_key, self::$options['admin']['table_taxonomies'] ) ? ' checked="checked"' : '' ); ?> value="<?php echo $tax_key; ?>" name="wpea_options[admin][table_taxonomies][]" /><?php echo $tax_tab['labels']['singular_name']; ?><br />
									<?php endforeach; ?>

                                </td>
                            </tr>
                            <tr class="toggle_admin_taxonomy"<?php echo ( self::$options['admin']['show_in_menu'] == 1 ? '' : ' style="display:none;"' ); ?>>
                                <th><?php _e( 'Manage taxonomies in admin', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input type="checkbox" <?php echo ( self::$options['admin']['show_tax_in_menu'] == 1 ? ' checked="checked"' : '' ); ?> value="1" name="wpea_options[admin][show_tax_in_menu]" /></td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Remove WP Estate Agency data on uninstall', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input type="checkbox" <?php echo ( self::$options['deactivation_delete'] == 1 ? ' checked="checked"' : '' ); ?> value="1" name="wpea_options[deactivation_delete]" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="postbox">
                <h3 class="hndle"><?php _e( 'Frontend', WPEA_PLUGIN_NAME ); ?></h3>
                <div class="inside">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th><?php _e( 'Contact page', WPEA_PLUGIN_NAME ); ?></th>
                                <td>
                                    <?php $args = array( 'post_type' => 'page', 'post_status' => 'any', 'nopaging' => true, 'orderby' => 'post_title', 'order' => 'ASC' ); ?>
                                    <select name="wpea_options[front][contact_page_id]">
                                        <option value="0"></option>
                                        <?php foreach ( get_posts( $args ) as $page ): ?>
                                            <option value="<?php echo $page->ID; ?>" <?php echo (self::$options['front']['contact_page_id'] == $page->ID ? ' selected="selected"' : ''); ?>><?php echo $page->post_title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><?php _e( 'List title', WPEA_PLUGIN_NAME ); ?></th>
                                <td>
                                    <input class="regular-text" type="text" name="wpea_options[front][list_title]" value="<?php echo self::$options['front']['list_title']; ?>" />
                                    <p class="description"><?php echo sprintf( __( 'Use \'&#37;\' to frame each field (<a href="%s">list available here</a>).', WPEA_PLUGIN_NAME ), $links['help'] ); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Field pastille', WPEA_PLUGIN_NAME ); ?></th>
                                <td>
                                    <select name="wpea_options[front][field_pastille]">
                                        <option value=""></option>
                                        <?php foreach ( self::$fields as $key => $field ) : ?>
                                            <?php if ( $field['type'] === 'yesno' ) : ?>
                                                <option value="<?php echo $key; ?>" <?php echo (self::$options['front']['field_pastille'] == $key ? ' selected="selected"' : ''); ?>><?php echo $field['name']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Pastille label', WPEA_PLUGIN_NAME ); ?></th>
                                <td>
                                    <input class="regular-text" type="text" name="wpea_options[front][list_pastille]" value="<?php echo self::$options['front']['list_pastille']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Thumbnail size', WPEA_PLUGIN_NAME ); ?></th>
                                <td>
                                    <label for="thumbnail_size_w"><?php _e( 'Width', WPEA_PLUGIN_NAME ); ?></label>
                                    <input id="thumbnail_size_w" class="small-text" type="number" value="<?php echo self::$options['images']['wpe_thumb']['width']; ?>" min="0" step="1" name="wpea_options[images][wpe_thumb][width]" />
                                    <label for="thumbnail_size_h"><?php _e( 'Height', WPEA_PLUGIN_NAME ); ?></label>
                                    <input id="thumbnail_size_h" class="small-text" type="number" value="<?php echo self::$options['images']['wpe_thumb']['height']; ?>" min="0" step="1" name="wpea_options[images][wpe_thumb][height]" />
                                    <br />
                                    <input id="thumbnail_crop" type="checkbox" <?php echo ( self::$options['images']['wpe_thumb']['crop'] == 1 ? ' checked="checked"' : '' ); ?> value="1" name="wpea_options[images][wpe_thumb][crop]" />
                                    <label for="thumbnail_crop"><?php _e( 'Crop thumbnail to exact dimensions', WPEA_PLUGIN_NAME ); ?></label>
                                </td>
                            </tr>
                            <tr>
                                <th><?php _e( 'List size', WPEA_PLUGIN_NAME ); ?></th>
                                <td>
                                    <label for="list_size_w"><?php _e( 'Width', WPEA_PLUGIN_NAME ); ?></label>
                                    <input id="list_size_w" class="small-text" type="number" value="<?php echo self::$options['images']['wpe_list']['width']; ?>" min="0" step="1" name="wpea_options[images][wpe_list][width]" />
                                    <label for="list_size_h"><?php _e( 'Height', WPEA_PLUGIN_NAME ); ?></label>
                                    <input id="list_size_h" class="small-text" type="number" value="<?php echo self::$options['images']['wpe_list']['height']; ?>" min="0" step="1" name="wpea_options[images][wpe_list][height]" />
                                    <br />
                                    <input id="list_crop" type="checkbox" <?php echo ( self::$options['images']['wpe_list']['crop'] == 1 ? ' checked="checked"' : '' ); ?> value="1" name="wpea_options[images][wpe_list][crop]" />
                                    <label for="list_crop"><?php _e( 'Crop thumbnail to exact dimensions', WPEA_PLUGIN_NAME ); ?></label>
                                </td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Detail size', WPEA_PLUGIN_NAME ); ?></th>
                                <td>
                                    <label for="detail_size_w"><?php _e( 'Width', WPEA_PLUGIN_NAME ); ?></label>
                                    <input id="detail_size_w" class="small-text" type="number" value="<?php echo self::$options['images']['wpe_detail']['width']; ?>" min="0" step="1" name="wpea_options[images][wpe_detail][width]" />
                                    <label for="detail_size_h"><?php _e( 'Height', WPEA_PLUGIN_NAME ); ?></label>
                                    <input id="detail_size_h" class="small-text" type="number" value="<?php echo self::$options['images']['wpe_detail']['height']; ?>" min="0" step="1" name="wpea_options[images][wpe_detail][height]" />
                                    <br />
                                    <input id="detail_crop" type="checkbox" <?php echo ( self::$options['images']['wpe_detail']['crop'] == 1 ? ' checked="checked"' : '' ); ?> value="1" name="wpea_options[images][wpe_detail][crop]" />
                                    <label for="detail_crop"><?php _e( 'Crop thumbnail to exact dimensions', WPEA_PLUGIN_NAME ); ?></label>
                                </td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Pagination', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input type="text" value="<?php echo isset(self::$platform['pagination']) ? esc_attr(self::$platform['pagination']) : ''; ?>" name="wpea_options[front][pagination]" />
</td>
                            </tr>
                            <tr class="toggle_pagination"<?php echo ( self::$options['front']['pagination'] == 1 ? '' : ' style="display:none;"' ); ?>>
                                <th><?php _e( 'Properties per page', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input class="small-text" type="number" value="<?php echo self::$options['front']['items_per_page']; ?>" min="0" step="1" name="wpea_options[front][items_per_page]" /></td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Use WP Estate Agency templates', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input class="toggle-checkbox" data-toggle="toggle_template" type="checkbox" <?php echo ( self::$options['front']['use_wpe_templates'] == 1 ? ' checked="checked"' : '' ); ?> value="1" name="wpea_options[front][use_wpe_templates]" /></td>
                            </tr>
                            <tr class="toggle_template"<?php echo ( self::$options['front']['use_wpe_templates'] == 1 ? '' : ' style="display:none;"' ); ?>>
                                <th><?php _e( 'Lazy load', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input type="checkbox" <?php echo isset(self::$platform['lazy_load']) && self::$platform['lazy_load'] === '1' ? 'checked' : ''; ?> value="1" name="wpea_options[front][lazy_load]" /></td>
                            </tr>
                            <tr class="toggle_template"<?php echo ( self::$options['front']['use_wpe_templates'] == 1 ? '' : ' style="display:none;"' ); ?>>
                                <th><?php _e( 'Images zoom', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input type="checkbox" <?php echo isset(self::$platform['zoom']) && self::$platform['zoom'] === '1' ? 'checked' : ''; ?> value="1" name="wpea_options[front][zoom]" />
</td>
                            </tr>
                            <tr class="toggle_template"<?php echo ( self::$options['front']['use_wpe_templates'] == 1 ? '' : ' style="display:none;"' ); ?>>
                                <th><?php _e( 'Display Search box on list template', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input type="checkbox" <?php echo isset(self::$platform['search_on_list_template']) && self::$platform['search_on_list_template'] === '1' ? 'checked' : ''; ?> value="1" name="wpea_options[front][search_on_list_template]" />
</td>
                            </tr>
                            <tr class="toggle_template"<?php echo ( self::$options['front']['use_wpe_templates'] == 1 ? '' : ' style="display:none;"' ); ?>>
                                <th><?php _e( 'Search box type', WPEA_PLUGIN_NAME ); ?></th>
                                <td>
                                    <label><input type="radio" value="full" <?php echo ( self::$options['front']['template_search_type'] == 'full' ? ' checked="checked"' : '' ); ?> name="wpea_options[front][template_search_type]" /><?php _e( 'Full', WPEA_PLUGIN_NAME ); ?></label>&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" value="basic" <?php echo ( self::$options['front']['template_search_type'] == 'basic' ? ' checked="checked"' : '' ); ?> name="wpea_options[front][template_search_type]" /><?php _e( 'Basic', WPEA_PLUGIN_NAME ); ?></label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="postbox">
                <h3 class="hndle"><?php _e( 'SEO', WPEA_PLUGIN_NAME ); ?></h3>
                <div class="inside">
                    <h4><?php _e( 'List page', WPEA_PLUGIN_NAME ); ?></h4>
                    <table class="form-table post-box">
                        <tbody>
                            <tr>
                                <th><?php _e( 'Permalink', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input type="text" name="wpea_options[seo][list_permalink]" value="<?php echo self::$options['seo']['list_permalink']; ?>" /></td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Meta title', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input class="regular-text" type="text" name="wpea_options[seo][list_title]" value="<?php echo self::$options['seo']['list_title']; ?>" /></td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Page title (h1)', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input class="regular-text" type="text" name="wpea_options[seo][list_h1]" value="<?php echo self::$options['seo']['list_h1']; ?>" /></td>
                            </tr>
                        </tbody>
                    </table>
                    <h4><?php _e( 'Property page', WPEA_PLUGIN_NAME ); ?></h4>
                    <p><?php echo sprintf( __( 'Use \'&#37;\' to frame each field (<a href="%s">list available here</a>).', WPEA_PLUGIN_NAME ), $links['help'] ); ?></p>
                    <table class="form-table post-box">
                        <tbody>
                            <tr>
                                <th><?php _e( 'Permalink', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input class="regular-text" type="text" name="wpea_options[seo][permalink]" value="<?php echo self::$options['seo']['permalink']; ?>" /></td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Meta title', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input class="regular-text" type="text" name="wpea_options[seo][title]" value="<?php echo self::$options['seo']['title']; ?>" /></td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Page title (h1)', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input class="regular-text" type="text" name="wpea_options[seo][h1]" value="<?php echo self::$options['seo']['h1']; ?>" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="postbox">
                <h3 class="hndle"><?php _e( 'AddThis', WPEA_PLUGIN_NAME ); ?></h3>
                <div class="inside">
                    <table class="form-table post-box">
                        <tbody>
                            <tr>
                                <th><?php _e( 'Enable Addthis buttons', WPEA_PLUGIN_NAME ); ?></th>
                                <td><input type="checkbox" id="wpea_addthis_active" value="1" name="wpea_options[addthis][active]" <?php echo (isset(self::$options['addthis']['active']) && self::$options['addthis']['active'] == 1) ? 'checked' : ''; ?> />
</td>
                            </tr>
                            <tr class="toggle_cron"<?php echo ( isset(self::$options['cron']['active']) ? (self::$options['cron']['active'] == 1 ? '' : ' style="display:none;"') : ' style="display:none;"' ); ?>>

                                <th><?php _e( 'Buttons size', WPEA_PLUGIN_NAME ); ?></th>
                                <td>
                                    <label><input type="radio" value="" <?php echo ( empty( self::$options['addthis']['size'] ) ? ' checked="checked"' : '' ); ?> name="wpea_options[addthis][size]" />16x16</label>&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" value="addthis_20x20_style" <?php echo ( self::$options['addthis']['size'] == 'addthis_20x20_style' ? ' checked="checked"' : '' ); ?> name="wpea_options[addthis][size]" />20x20</label>&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" value="addthis_32x32_style" <?php echo ( self::$options['addthis']['size'] == 'addthis_32x32_style' ? ' checked="checked"' : '' ); ?> name="wpea_options[addthis][size]" />32x32</label>
                                </td>
                            </tr>
                            <tr class="toggle_cron"<?php echo ( isset(self::$options['cron']['active']) && self::$options['cron']['active'] == 1 ? '' : ' style="display:none;"' ); ?>>

                                <th><?php _e( 'Displayed buttons', WPEA_PLUGIN_NAME ); ?></th>
                                <td>
                                    <?php foreach( self::$addthis as $key => $item ): ?>
                                    <input type="checkbox" <?php echo ( in_array( $key, self::$options['addthis']['items'] ) ) ? ' checked="checked"' : ''; ?> value="<?php echo $key; ?>" name="wpea_options[addthis][items][]" /><?php echo $item['label']; ?><br />
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                            <tr class="toggle_cron"<?php echo ( isset(self::$options['cron']['active']) && self::$options['cron']['active'] == 1 ? '' : ' style="display:none;"' ); ?>>

                                <th>pubID</th>
                                <td><input class="regular-text" type="text" name="wpea_options[addthis][pubid]" value="<?php echo self::$options['addthis']['pubid']; ?>" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="postbox">
                <h3 class="hndle"><?php _e( 'Active fields', WPEA_PLUGIN_NAME ); ?></h3>
                <div class="inside">
                    <?php foreach( self::$all_fields as $key => $tab ): ?>
                        <input type="checkbox" <?php echo ( in_array( $key, self::$options['active_fields'] ) ? ' checked="checked"' : '' ); ?> value="<?php echo $key; ?>" name="wpea_options[active_fields][]" /><?php echo $tab['name']; ?><br />
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="postbox">
                <h3 class="hndle"><?php _e( 'Active taxonomies', WPEA_PLUGIN_NAME ); ?></h3>
                <div class="inside">
                    <?php foreach( self::$all_taxonomies as $key => $tab ): ?>
                        <input type="checkbox" <?php echo ( in_array( $key, self::$options['active_taxonomies'] ) ? ' checked="checked"' : '' ); ?> value="<?php echo $key; ?>" name="wpea_options[active_taxonomies][]" /><?php echo $tab['labels']['singular_name']; ?><br />
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="postbox">
                <h3 class="hndle"><?php _e( 'Custom data', WPEA_PLUGIN_NAME ); ?></h3>
                <div class="inside">
                    <p><?php _e( '<strong>Only JSON data is supported</strong>.<br />To retrieve custom data as an array on frontend, use the <code>wpea_get_custom_data()</code> function.', WPEA_PLUGIN_NAME ); ?></p>
                    <?php
                    $custom_data = WPea_Tools::get_custom_data( true );
                    $custom_data_decoded = json_decode( $custom_data );
                    ?>
                    <textarea class="large-text" name="wpea_custom_data" rows="7"><?php if ( ! empty( $custom_data_decoded ) ) echo $custom_data; ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <p class="submit">
        <input type="hidden" name="wpea_options[front][list_page_id]" value="<?php echo self::$options['front']['list_page_id']; ?>" />
        <input type="hidden" name="action" value="save" />
        <input class="button button-primary alignright" type="submit" value="<?php _e( 'Save changes', WPEA_PLUGIN_NAME ); ?>" name="submit" required="required" />
    </p>
</form>