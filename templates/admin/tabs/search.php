<?php defined( 'ABSPATH' ) or exit; ?>
<form class="wpea-admin-form-search" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<?php wp_nonce_field( 'wpea_settings', 'wpea_search_nonce' ); ?>
    <p class="submit overflow">
        <input class="button button-primary alignright" type="submit" value="<?php _e( 'Save changes', WPEA_PLUGIN_NAME ); ?>" name="submit" required="required" />
    </p>
    <div id="post-body-content">
        <div class="meta-box-sortables ui-sortable">
            <?php foreach ( self::$search as $key => $tab ) : ?>
            <div class="postbox">
                <h3 class="hndle">
                    <?php
                    switch ( $key ) :
                        case 'default_title': _e( 'Default title', WPEA_PLUGIN_NAME ); break;
                        case 'basic'        : _e( 'Basic', WPEA_PLUGIN_NAME ); break;
                        case 'full'         : _e( 'Full', WPEA_PLUGIN_NAME ); break;
                        default             : break;
                    endswitch;
                    ?>
                </h3>
                <div class="inside">
                    <?php if ( $key == 'default_title' ) : ?>
                        <input name="wpea_search[<?php echo $key; ?>]" type="text" class="regular-text" value="<?php echo $tab; ?>" />
                    <?php else : ?>
                        <div class="fields_header">
                            <table class="form-table">
                                <thead>
                                    <tr>
                                        <th class="field-position"><?php _e( 'Position', WPEA_PLUGIN_NAME ); ?></th>
                                        <th class="field-key"><?php _e( 'Field', WPEA_PLUGIN_NAME ); ?></th>
                                        <th class="field-type"><?php _e( 'Field type', WPEA_PLUGIN_NAME ); ?></th>
                                        <th class="field-expand"></th>
                                        <th class="field-delete"></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="fields" data-group="<?php echo $key; ?>">
                            <?php
                            $counter = 0;
                            $tab['new_field'] = array( 'type' => 'text' );
                            foreach ( $tab as $key2 => $tab2 ) : $counter ++; $unique = time() + $counter;
                            ?>
                            <div class="field<?php echo $key2 === 'new_field' ? ' field_clone' : ''; ?>" data-unique="<?php echo $unique; ?>">
                                <div class="field_meta">
                                    <table class="form-table">
                                        <tbody>
                                            <tr>
                                                <td class="field-position"><span class="circle"><?php echo $counter; ?></span></td>
                                                <td class="field-key"><a href="javascript:void(0);" class="toggle-field-form"><?php echo $key2 === 'new_field' ? __( 'new field', WPEA_PLUGIN_NAME ) : $key2; ?></a></td>
                                                <td class="field-type"><?php _e( $tab2['type'], WPEA_PLUGIN_NAME ); ?></td>
                                                <td class="field-expand"><a href="javascript:void(0);" class="toggle-field-form genericon genericon-downarrow"></a></td>
                                                <td class="field-delete"><a class="wpea-button-delete ir" href="javascript:void(0);"><?php _e( 'Delete', WPEA_PLUGIN_NAME ); ?></a>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="field_form">
                                    <table class="form-table">
                                        <tr>
                                            <th><?php _e( 'Field type', WPEA_PLUGIN_NAME ); ?></th>
                                            <td>
                                                <select class="field-type" name="wpea_search[<?php echo $key; ?>][<?php echo $unique; ?>][type]">
                                                    <option value="text"<?php echo $tab2['type'] == 'text' ? ' selected="selected"' : ''; ?>><?php _e( 'text', WPEA_PLUGIN_NAME ); ?></option>
                                                    <option value="select"<?php echo $tab2['type'] == 'select' ? ' selected="selected"' : ''; ?>><?php _e( 'select', WPEA_PLUGIN_NAME ); ?></option>
                                                    <option value="min"<?php echo $tab2['type'] == 'min' ? ' selected="selected"' : ''; ?>><?php _e( 'min', WPEA_PLUGIN_NAME ); ?></option>
                                                    <option value="max"<?php echo $tab2['type'] == 'max' ? ' selected="selected"' : ''; ?>><?php _e( 'max', WPEA_PLUGIN_NAME ); ?></option>
                                                    <option value="interval"<?php echo $tab2['type'] == 'interval' ? ' selected="selected"' : ''; ?>><?php _e( 'interval', WPEA_PLUGIN_NAME ); ?></option>
                                                    <option value="submit"<?php echo $tab2['type'] == 'submit' ? ' selected="selected"' : ''; ?>><?php _e( 'submit', WPEA_PLUGIN_NAME ); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="field-data"<?php echo $tab2['type'] == 'submit' ? ' style="display:none;"' : ''; ?>>
                                            <th><?php _e( 'Field', WPEA_PLUGIN_NAME ); ?></th>
                                            <td>
                                                <select class="field-key" name="wpea_search[<?php echo $key; ?>][<?php echo $unique; ?>][key]">
                                                    <option value=""></option>
                                                    <?php $tab_fields = array_keys( self::$fields ); sort( $tab_fields ); ?>
                                                    <?php foreach( $tab_fields as $key3 ): ?>
                                                        <option value="<?php echo $key3; ?>"<?php echo $key3 == $key2 ? ' selected="selected"' : ''; ?>><?php echo $key3; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="field-taxonomy field-taxonomy-name"<?php echo ! empty( $tab2['taxonomy'] ) ? '' : ' style="display:none;"'; ?>>
                                            <th><?php _e( 'Taxonomy', WPEA_PLUGIN_NAME ); ?></th>
                                            <td>
                                                <span><?php echo self::$taxonomies[$tab2['taxonomy']]['labels']['singular_name']; ?></span>
                                                <input class="field-taxonomy" type="hidden" name="wpea_search[<?php echo $key; ?>][<?php echo $unique; ?>][taxonomy]" value="<?php echo $tab2['taxonomy']; ?>" />
                                            </td>
                                        </tr>
                                        <tr class="field-taxonomy field-taxonomy-hide"<?php echo ! empty( $tab2['taxonomy'] ) ? '' : ' style="display:none;"'; ?>>
                                            <th><?php _e( 'Hide empty', WPEA_PLUGIN_NAME ); echo $tab2['hide_empty']; ?></th>
                                            <td>
                                                <label><input class="field-hide_empty" type="radio" value="" <?php echo empty( $tab2['hide_empty'] ) ? ' checked="checked"' : ''; ?> name="wpea_search[<?php echo $key; ?>][<?php echo $unique; ?>][hide_empty]" /><?php _e( 'no', WPEA_PLUGIN_NAME ); ?></label>&nbsp;&nbsp;&nbsp;
                                                <label><input class="field-hide_empty" type="radio" value="1" <?php echo $tab2['hide_empty'] == 1 ? ' checked="checked"' : '' ; ?> name="wpea_search[<?php echo $key; ?>][<?php echo $unique; ?>][hide_empty]" /><?php _e( 'yes', WPEA_PLUGIN_NAME ); ?></label>
                                            </td>
                                        </tr>
                                        <tr class="field-select"<?php echo $tab2['type'] == 'select' ? '' : ' style="display:none;"'; ?>>
                                            <th><?php _e( 'First choice (empty)', WPEA_PLUGIN_NAME ); ?></th>
                                            <td><input class="field-default" type="text" class="regular-text" value="<?php echo $tab2['default']; ?>" name="wpea_search[<?php echo $key; ?>][<?php echo $unique; ?>][default]" /></td>
                                        </tr>
                                        <tr class="field-data"<?php echo $tab2['type'] == 'submit' ? ' style="display:none;"' : ''; ?>>
                                            <th><?php _e( 'Label', WPEA_PLUGIN_NAME ); ?></th>
                                            <td><input class="field-label" type="text" class="regular-text" value="<?php echo $tab2['label']; ?>" name="wpea_search[<?php echo $key; ?>][<?php echo $unique; ?>][label]" /></td>
                                        </tr>
                                        <tr class="field-text"<?php echo in_array( $tab2['type'], array( 'text', 'min', 'max' ) ) ? '' : ' style="display:none;"'; ?>>
                                            <th><?php _e( 'Placeholder', WPEA_PLUGIN_NAME ); ?></th>
                                            <td><input class="field-placeholder" type="text" class="regular-text" value="<?php echo $tab2['placeholder']; ?>" name="wpea_search[<?php echo $key; ?>][<?php echo $unique; ?>][placeholder]" /></td>
                                        </tr>
                                        <tr class="field-interval"<?php echo $tab2['type'] == 'interval' ? '' : ' style="display:none;"'; ?>>
                                            <th><?php _e( 'First placeholder', WPEA_PLUGIN_NAME ); ?></th>
                                            <td><input class="field-first_placeholder" type="text" class="regular-text" value="<?php echo $tab2['first_placeholder']; ?>" name="wpea_search[<?php echo $key; ?>][<?php echo $unique; ?>][first_placeholder]" /></td>
                                        </tr>
                                        <tr class="field-interval"<?php echo $tab2['type'] == 'interval' ? '' : ' style="display:none;"'; ?>>
                                            <th><?php _e( 'Second placeholder', WPEA_PLUGIN_NAME ); ?></th>
                                            <td><input class="field-second_placeholder" type="text" class="regular-text" value="<?php echo $tab2['second_placeholder']; ?>" name="wpea_search[<?php echo $key; ?>][<?php echo $unique; ?>][second_placeholder]" /></td>
                                        </tr>
                                        <tr class="field-submit"<?php echo $tab2['type'] == 'submit' ? '' : ' style="display:none;"'; ?>>
                                            <th><?php _e( 'Label', WPEA_PLUGIN_NAME ); ?></th>                               
                                            <td><input class="field-value" type="text" class="regular-text" value="<?php echo $tab2['value']; ?>" name="wpea_search[<?php echo $key; ?>][<?php echo $unique; ?>][value]" /></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <a href="javascript:void(0);" class="alignright button wpea-button-add"><?php _e( 'Add field', WPEA_PLUGIN_NAME ); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <p class="submit">
        <input type="hidden" name="action" value="save_search" />
        <input class="button button-primary alignright" type="submit" value="<?php _e( 'Save changes', WPEA_PLUGIN_NAME ); ?>" name="submit" required="required" />
    </p>
</form>