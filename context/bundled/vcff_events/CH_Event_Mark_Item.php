<?php

class CH_Event_Mark_Item extends VCFF_Event_Item {
	
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
        // Retrieve the form fields
        $form_containers = $form_instance->containers;
        // If no form fields, return out
        if (!$form_fields || !is_array($form_fields)) { return false; }
        // Loop through each form field
        foreach ($form_fields as $machine_code => $field_instance) {
            // If the field is currently hidden
            if ($field_instance->Is_Hidden()) { continue; }
            // If the field instance is not a question
            if (!$field_instance->is_question) { continue; }
            // If the question has been marked as correct
            $field_instance->Mark();
        }
        // If no form fields, return out
        if ($form_containers || is_array($form_containers)) { 
            // Loop through each form field
            foreach ($form_containers as $machine_code => $container_instance) {
                // If the field is currently hidden
                if ($container_instance->Is_Hidden()) { continue; }
                // If the field instance is not a question
                if (!$container_instance->is_ch) { continue; }
                // Execute the ordering function
                $container_instance->Calc_Ordering();
                // Execute the current calculations
                $container_instance->Calc_Current();
            }
        }
        // Calculate the form attempts
        $this->_Calc_Attempts();
        // Calculate the history
        $this->_Calc_History();
    }
    
    protected function _Calc_Attempts() {
        // Retrieve the form instance
        $form_instance = $this->form_instance;
        // Retreiev the form session id
        $session_id = $form_instance->Get_Session_ID();
        // If we already have set the field order
        if (isset($_SESSION["vcff/$session_id/ch"])) {
            // Populate the session data
            $session_data = $_SESSION["vcff/$session_id/ch"];
        } // Otherwise set with an empty array
        else { $session_data = array(); }
        // If the attempts are set
        if (isset($session_data['attempts'])) {
            // Update the attempts
            $session_data['attempts'] = intval($session_data['attempts'])+1;
        } // Otherwise set the attempts to 1
        else { $session_data['attempts'] = 1; }
        // Save to the form's session information
        $_SESSION["vcff/$session_id/ch"] = $session_data;
    }
    
    protected function _Calc_History() {
        // Retrieve the form instance
        $form_instance = $this->form_instance;
        // Retreiev the form session id
        $session_id = $form_instance->Get_Session_ID();
        // If we already have set the field order
        if (isset($_SESSION["vcff/$session_id/ch"])) {
            // Populate the session data
            $session_data = $_SESSION["vcff/$session_id/ch"];
        } // Otherwise set with an empty array
        else { $session_data = array(); }
        // Retrieve the form fields
        $form_fields = $form_instance->fields;
        // If no form fields, return out
        if (!$form_fields || !is_array($form_fields)) { return false; }
        // Loop through each form field
        foreach ($form_fields as $machine_code => $field_instance) {
            // If the field instance is not a question
            if (!$field_instance->is_question) { continue; }
            // If the question is empty
            if ($field_instance->Is_Empty()) {
                // Set the field status
                $calc_status = 'No Answer';
            } // Otherwise if is correct
            elseif ($field_instance->Is_Correct()) {
                // Set the field status
                $calc_status = 'Correct';
            } // Otherwise if is incorrect
            elseif ($field_instance->Is_Incorrect()) {
                // Set the field status
                $calc_status = 'Incorrect';
            } // Otherwise if is pending
            elseif ($field_instance->Is_Pending()) {
                // Set the field status
                $calc_status = 'Pending';
            }
            // If the question has been marked as correct
            $field_history[] = array(
                'label' => $field_instance->Get_Label(),
                'status' => $field_instance->mark,
                'marked' => $field_instance->Is_Marked() ? true : false,
                'visible' => $field_instance->Is_Hidden() ? false : true
            );
        }
        // Populate the history
        $session_data['history'][] = array(
            'time' => time(),
            'fields' => $field_history
        );
        // Save to the form's session information
        $_SESSION["vcff/$session_id/ch"] = $session_data;
    }
    
}