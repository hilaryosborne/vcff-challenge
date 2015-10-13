<?php

class CH_Trigger_Answers_Item extends VCFF_Trigger_Item {
    
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

        if (!$this->_Get_Answer_Status()) {
            // Add an alert to notify of field requirements
            $this->validation_errors['answer_status'] = true;
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
        $noanswer = 0; $hasanswer = 0;
        // Loop through each form field
        foreach ($form_fields as $machine_code => $field_instance) {
            // If the field is currently hidden
            if ($field_instance->Is_Hidden()) { continue; }
            // If the field instance is not a question
            if (!$field_instance->is_question) { continue; }
            // If the question is not empty
            if (!$field_instance->Is_Empty()) { $hasanswer++; continue; }
            // Inc up the no answer
            $noanswer++;
        }
        // Retrieve the trigger value
        $trigger_value = $this->value; 
        // Retrieve the answer status
        $answer_status = $trigger_value['answer_status'];
        // Determine what happens
        switch ($answer_status) {
            case 'all' : return $noanswer == 0 ? true : false; break;
            case 'some' : return $hasanswer > 0 ? true : false; break;
        }
    }
    
    public function _Get_Answer_Status() {
        
        $trigger_value = $this->value;
        
        if (!isset($trigger_value['answer_status'])) { return; }
        
        return $trigger_value['answer_status'];
    }
}