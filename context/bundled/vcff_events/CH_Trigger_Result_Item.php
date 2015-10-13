<?php

class CH_Trigger_Result_Item extends VCFF_Trigger_Item {
    
    public function Render() {
        // Retrieve the context director
        $trigger_dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // If context data was passed
        $posted_data = $this->data;
        // Start gathering content
        ob_start();
        // Include the template file
        include($trigger_dir.'/'.get_class($this).'.tpl.php');
        // Get contents
        $output = ob_get_contents();
        // Clean up
        ob_end_clean();
        // Return the contents
        return $output;
    }
    
    public function Check_Validation() {

        $action_instance = $this->action_instance;

        if (!$this->_Get_Marked_Result()) {
            // Add an alert to notify of field requirements
            $this->validation_errors['marked_result'] = true;
        }

        if (!is_array($this->validation_errors)) { return; }
        
        if (count($this->validation_errors) == 0) { return; }
        
        $action_instance->is_valid = false;
    }
    
    public function Check() {
        // Retrieve the form instance
        $form_instance = $this->form_instance;
        // If the form did not validate
        if (!$form_instance->Is_Valid()) { return false; } 
        // Retrieve the form fields
        $form_fields = $form_instance->fields;
        // If no form fields, return out
        if (!$form_fields || !is_array($form_fields)) { return false; }
        // The no answer in var
        $positive = 0; $negative = 0; $pending=0; $correct=0; $noanswer = 0; $ischecked = 0;
        // Loop through each form field
        foreach ($form_fields as $machine_code => $field_instance) {
            // If the field is currently hidden
            if ($field_instance->Is_Hidden()) { continue; }
            // If the field instance is not a question
            if (!$field_instance->is_question) { continue; }
            // If the question is not empty
            if ($field_instance->Is_Correct() || $field_instance->Is_Pending()) { $positive++; }
            // If the question is not empty
            if ($field_instance->Is_Pending()) { $pending++; }
            // If the question is not empty
            if ($field_instance->Is_Correct()) { $correct++; }
            // If the question is not empty
            if ($field_instance->Is_Incorrect()) { $negative++; }
            // If the question is not empty
            if ($field_instance->Is_Empty()) { $noanswer++; }
            // Up the is checked value
            $ischecked++;
        }
        // If there are visible non answered questions
        if ($noanswer > 0) { return false; }
        // If there are visible non answered questions
        if ($ischecked == 0) { return false; }
        // Retrieve the trigger value
        $trigger_value = $this->value; 
        // Retrieve the answer status
        $marked_result = $trigger_value['marked_result']; 
        // Determine what happens
        switch ($marked_result) {
            case 'all_positive' : return $negative == 0 ? true : false; break;
            case 'all_correct' : return $negative == 0 && $pending == 0 ? true : false; break;
            case 'some_unsuccessful' : return $negative > 0 ? true : false; break;
        }
    }
    
    public function _Get_Marked_Result() {
        
        $trigger_value = $this->value;
        
        if (!isset($trigger_value['marked_result'])) { return; }
        
        return $trigger_value['marked_result'];
    }
}