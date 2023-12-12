<?php defined( 'ABSPATH' ) or exit; ?>
<form class="wpea-admin-form-groups" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<?php wp_nonce_field( 'wpea_settings', 'wpea_groups_nonce' ); ?>
    <p class="submit overflow">
        <input class="button button-primary alignright" type="submit" value="<?php _e( 'Save changes', WPEA_PLUGIN_NAME ); ?>" name="submit" required="required" />
    </p>
    <div id="post-body-content">
        <div class="groups">
            <?php 
            self::$groups['group_clone'] = array(
                'title'  => __( 'New group', WPEA_PLUGIN_NAME ),
                'fields' => array(
                    'new_field' => array(
                        'key'   => 'new_field',
                        'label' => __( 'New field', WPEA_PLUGIN_NAME ),
                    ),
                ),
            );
            if ( count( self::$groups ) == 1 ) :
                self::$groups['new_group'] = self::$groups['group_clone'];
            endif;
            $counter_group = 0;
foreach ( self::$groups as $key => $group ) : $counter_group ++; $unique_group = 'group_' . time() . $counter_group;
    if ( ! isset( $group['id'] ) ) {
        $group['id'] = $counter_group;
    }

    if ( ! isset( $group['fields']['new_field'] ) ) :
        $group['fields']['new_field'] = array(
            'key'   => 'new_field',
            'label' => __( 'New field', WPEA_PLUGIN_NAME ),
        );
    endif; ?>
    <div class="postbox group<?php echo $key === 'group_clone' ? ' group_clone' : ''; ?>" data-unique="<?php echo $unique_group; ?>">
        <h3 class="hndle group-handle">
            <?php _e( 'Title:', WPEA_PLUGIN_NAME ); ?> <input name="wpea_groups[<?php echo $unique_group; ?>][title]" type="text" class="regular-text" value="<?php echo $group['title']; ?>" />
            <input name="wpea_groups[<?php echo $unique_group; ?>][id]" type="hidden" value="<?php echo $group['id']; ?>" />
            <p><?php echo 'id : ' . $group['id']; ?></p>
            <a class="wpea-button-delete ir" href="javascript:void(0);"><?php _e( 'Delete', WPEA_PLUGIN_NAME ); ?></a>
        </h3>
                    <div class="inside">
                        <div class="fields" data-group="<?php echo $unique_group; ?>">
                            <?php
                            $counter = 0;
                            foreach ( $group['fields'] as $key2 => $tab ) : $counter ++; $unique = time() + $counter;
                            ?>
                            <div class="field<?php echo $key2 === 'new_field' ? ' field_clone' : ''; ?>" data-unique="<?php echo $unique; ?>">
                                <div class="field_meta">
                                    <table class="form-table">
                                        <tbody>
                                            <tr>
                                                <td class="field-position"><span class="circle"><?php echo $counter; ?></span></td>
                                                <td class="field-key"><a href="javascript:void(0);" class="toggle-field-form"><?php echo $key2 === 'new_field' ? __( 'new field', WPEA_PLUGIN_NAME ) : $tab['key']; ?></a></td>
                                                <td class="field-expand"><a href="javascript:void(0);" class="toggle-field-form genericon genericon-downarrow"></a></td>
                                                <td class="field-delete"><a class="wpea-button-delete ir" href="javascript:void(0);"><?php _e( 'Delete', WPEA_PLUGIN_NAME ); ?></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="field_form">
                                    <table class="form-table">
                                        <tr>
                                            <th><?php _e( 'Field', WPEA_PLUGIN_NAME ); ?></th>
                                            <td>
                                                <select data-key="key" class="field-key field-input" name="wpea_groups[<?php echo $unique_group; ?>][<?php echo $unique; ?>][key]">
                                                    <option value=""></option>
                                                    <?php $tab_fields = array_keys( self::$fields ); sort( $tab_fields ); ?>
                                                    <?php foreach( $tab_fields as $select_key ): ?>
                                                        <option value="<?php echo $select_key; ?>"<?php echo $select_key == $tab['key'] ? ' selected="selected"' : ''; ?>><?php echo $select_key; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php _e( 'Combined with', WPEA_PLUGIN_NAME ); ?></th>
                                            <td>
                                               

    <select data-key="combined" class="field-combined field-input" name="wpea_groups[<?php echo $unique_group; ?>][<?php echo $unique; ?>][combined]">
        <option value=""></option>
        <?php $tab_fields = array_keys( self::$fields ); sort( $tab_fields ); ?>
        <?php foreach( $tab_fields as $select_key ): ?>
            <option value="<?php echo $select_key; ?>"<?php echo isset( $tab['combined'] ) && $select_key == $tab['combined'] ? ' selected="selected"' : ''; ?>><?php echo $select_key; ?></option>
        <?php endforeach; ?>
    </select>
 

                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php _e( 'Label', WPEA_PLUGIN_NAME ); ?></th>
                                            <td><input data-key="label" class="field-label field-input regular-text" type="text" value="<?php echo $tab['label']; ?>" name="wpea_groups[<?php echo $unique_group; ?>][<?php echo $unique; ?>][label]" /></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <a href="javascript:void(0);" class="alignright button wpea-button-add"><?php _e( 'Add field', WPEA_PLUGIN_NAME ); ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="javascript:void(0);" class="alignright button wpea-button-add-group"><?php _e( 'Add group', WPEA_PLUGIN_NAME ); ?></a>
    </div>
    <p class="submit">
        <input type="hidden" name="action" value="save_groups" />
        <input class="clear button button-primary alignright" type="submit" value="<?php _e( 'Save changes', WPEA_PLUGIN_NAME ); ?>" name="submit" required="required" />
    </p>
</form>