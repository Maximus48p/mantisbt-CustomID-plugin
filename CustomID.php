<?php

class CustomIDPlugin extends MantisPlugin {
    /**
     * Register the plugin with MantisBT.
     */
    function register() {
        $this->name = 'Custom ID Plugin';    # Proper name of plugin
        $this->description = 'Allows to display the contents of a custom field instead of the issue ID';    # Short description of the plugin
        $this->page = 'config_page';         # Default plugin page

        $this->version = '0.3';              # Plugin version string
        $this->requires = array(             # Plugin dependencies, array of basename => version pairs
            'MantisCore' => '2.0.0',         # Updated to depend on MantisBT 2.x
        );

        $this->author = 'GTZ Ethiopia ICT Service - Development Team';  # Author/team name
        $this->contact = 'ict-et@gtz.de';     # Author/team e-mail address
        $this->url = '';                      # Support webpage
    }

    /**
     * Register plugin hooks.
     */
    function hooks() {
        return array(
            'EVENT_DISPLAY_BUG_ID' => 'display_bug_id'
        );
    }

    /**
     * Plugin configuration settings.
     */
    function config() {
        return array(
            'project_id' => 0,
            'field_id' => 0,
            'prefix' => '',
        );
    }

    /**
     * Custom logic to display bug IDs using a custom field value.
     */
    function display_bug_id($p_event, $p_text) {
        $p_bug_id = (int)$p_text;

        // Check if bug exists
        if (!bug_exists($p_bug_id)) {
            return $p_text;
        }

        // Get bug data
        $bug = bug_get($p_bug_id);
        $project = $bug->project_id;  // Updated to direct property access

        // Check if bug belongs to configured project
        if ($project != plugin_config_get('project_id')) {
            return $p_text;
        }

        // Retrieve plugin configuration values
        $p_field_id = plugin_config_get('field_id');
        $prefix = plugin_config_get('prefix');

        // Determine if the bug has any relationships
        $has_parent = false;

        // Check for source relationships (e.g., "blocks" relationships)
        $t_bugs_ids = relationship_get_all_src($p_bug_id);
        foreach ($t_bugs_ids as $t_relationship) {
            if ($t_relationship->type == BUG_BLOCKS) {
                $has_parent = true;
                break;
            }
        }

        // Check for destination relationships (e.g., "depends on" relationships)
        $t_bugs_ids = relationship_get_all_dest($p_bug_id);
        foreach ($t_bugs_ids as $t_relationship) {
            if ($t_relationship->type == BUG_DEPENDANT) {
                $has_parent = true;
                break;
            }
        }

        // Use alternate prefix if the bug has a parent relationship
        $prefix_two = plugin_config_get('prefix_two');
        if ($has_parent) {
            $prefix = $prefix_two;
        }

        // Get custom field definition and value
        $p_def = custom_field_get_definition($p_field_id);
        $t_custom_field_value = custom_field_get_value($p_field_id, $p_bug_id);

        // Display the custom field value using the defined function for its type (if available)
        global $g_custom_field_type_definition;
        if (isset($g_custom_field_type_definition[$p_def['type']]['#function_string_value'])) {
            return $prefix . call_user_func(
                $g_custom_field_type_definition[$p_def['type']]['#function_string_value'],
                $t_custom_field_value
            );
        }

        // Default fallback to prefix + custom field value
        return $prefix . $t_custom_field_value;
    }
	// todo: remove jump to field for such projects!
}
