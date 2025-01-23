<?php
auth_reauthenticate();
access_ensure_global_level(config_get('manage_plugin_threshold'));

layout_page_header(plugin_lang_get('plugin_title'));
layout_page_begin('manage_overview_page.php');

print_manage_menu();
?>

<div class="col-md-12 col-xs-12">
    <div class="space-10"></div>

    <div class="form-container">
        <form action="<?php echo plugin_page('config_update') ?>" method="post">
            <?php echo form_security_field('plugin_CustomID_config_update') ?>

            <div class="widget-box widget-color-blue2">
                <div class="widget-header widget-header-small">
                    <h4 class="widget-title lighter">
                        <?php echo plugin_lang_get('plugin_title') . ': ' . plugin_lang_get('config') ?>
                    </h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed table-striped">
                                <tr>
                                    <th class="category width-60">
                                        <?php echo plugin_lang_get('project_name') ?>
                                    </th>
                                    <td>
                                        <select name="customid_project_id" class="input-sm">
                                            <option value="0" <?php check_selected(plugin_config_get('project_id'), 0); ?>>
                                                <?php echo lang_get('all_projects'); ?>
                                            </option>
                                            <?php print_project_option_list(plugin_config_get('project_id'), false); ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="category width-60">
                                        <?php echo lang_get('custom_field') ?>
                                    </th>
                                    <td>
                                        <select name="customid_field_id" class="input-sm">
                                            <?php
                                            $t_custom_fields = custom_field_get_ids();

                                            foreach ($t_custom_fields as $t_field_id) {
                                                $t_desc = custom_field_get_definition($t_field_id);
                                                echo '<option value="' . $t_field_id . '"';
                                                check_selected($t_field_id, plugin_config_get('field_id'));
                                                echo '>' . string_attribute($t_desc['name']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="category width-60">
                                        <?php echo plugin_lang_get('config_prefix') ?>
                                    </th>
                                    <td>
                                        <input name="customid_prefix" class="input-sm" size="30"
                                               value="<?php echo string_attribute(plugin_config_get('prefix')) ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <th class="category width-60">
                                        <?php echo plugin_lang_get('config_prefix_two') ?>
                                    </th>
                                    <td>
                                        <input name="customid_prefix_two" class="input-sm" size="30"
                                               value="<?php echo string_attribute(plugin_config_get('prefix_two')) ?>">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="widget-toolbox padding-8 clearfix">
                        <input type="submit" class="btn btn-primary btn-white btn-sm btn-round"
                               value="<?php echo plugin_lang_get('update_config') ?>" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
layout_page_end();
?>
