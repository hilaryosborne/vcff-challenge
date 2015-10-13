<?php

class CH_Event_Field_Results_Item extends VCFF_Event_Item {
	
	public function Render() {
        // Retrieve the context director
        $action_dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // If context data was passed
        $posted_data = $this->data;
        // Start gathering content
        ob_start();
        // Include the template file
        include($action_dir.'/'.get_class($this).'.tpl.php');
        // Get contents
        $output = ob_get_contents();
        // Clean up
        ob_end_clean();
        // Return the contents
        return $output;
    }

    public function Trigger() {
        // Retrieve the form instance
        $form_instance = $this->form_instance;
        // If the form did not validate
        if (!$form_instance->Is_Valid()) { return false; } 
        // Retrieve the form fields
        $form_fields = $form_instance->fields; 
        // If no form fields, return out
        if (!$form_fields || !is_array($form_fields)) { return false; }
        // Loop through each form field
        foreach ($form_fields as $machine_code => $field_instance) {
            // If the field is currently hidden
            if ($field_instance->Is_Hidden()) { continue; }
            // If the field instance is not a question
            if (!$field_instance->is_question) { continue; }
            // If the question is not empty
            if (!$field_instance->Is_Marked()) { continue; }
            // If the question has been marked as correct
            if ($field_instance->Is_Correct()) {
                // Add the correct message
                $field_instance->Add_Alert($field_instance->Get_Correct_Msg().' Correct','success');
            }
            // If the question has been marked as correct
            if ($field_instance->Is_Incorrect()) { 
                // Add the correct message
                $field_instance->Add_Alert($field_instance->Get_Incorrect_Msg().' Incorrect','danger'); 
            }
            // If the question has been marked as correct
            if ($field_instance->Get_Comment_Msg()) {
                // Add the correct message
                $field_instance->Add_Alert($field_instance->Get_Comment_Msg().' Comment','info');
            }
        }
    }
    
}
