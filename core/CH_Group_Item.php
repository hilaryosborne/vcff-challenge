<?php

class CH_Group_Item extends VCFF_Container_Item {
    
    public $current = array();
    
    public $field_order;
    
    public $is_ch = true;
    
    public function On_Create() {
        // Retrieve the form instance
        $form_instance = $this->form_instance;
        
        $form_instance->Add_Action('after_review',array($this,'Calc_Ordering'),15);
        $form_instance->Add_Action('after_review',array($this,'Calc_Current'),25);
    }
    
    protected function _Add_Chaos($options) {
        // If not an array, return out
        if (!is_array($options)) { return $options; } 
        // Create a chaos value
        $chaos = rand(2,20);
        // Loop through
        for ($i=0;$i<$chaos;$i++) {
            // Return the array keys
            $keys = array_keys($options); 
            // Shuffle returned keys
            shuffle($keys);
            // Temp random var
            $random = array(); 
            // Loop through and populate random 
            foreach ($keys as $key) { $random[$key] = $options[$key];  }
            // Populate the options
            $options = $random;
        }
        // Return the options
        return $options; 
    }
    
    public function Is_Randomised() {
        // Retrieve the element
        $el = $this->el;
        // Return the result
        return (isset($el->attributes['ch_randomise_questions']) && $el->attributes['ch_randomise_questions'] == 'yes') ? true : false ;
    }
    
    public function Calc_Ordering() {
        // Retrieve the form instance
        $form_instance = $this->form_instance;
        // Retrieve the machine code of the container
        $machine_code = $this->machine_code;
        // Reset the field order
        $this->field_order = array();
        // Retreiev the form session id
        $session_id = $form_instance->Get_Session_ID();
        // If we already have set the field order
        if (isset($_SESSION["vcff/$session_id/ch"])) {
            // Populate the session data
            $session_data = $_SESSION["vcff/$session_id/ch"];
        } // Otherwise set with an empty array
        else { $session_data = array(); }
        // If this group already has a saved 
        if (!isset($session_data['group_fields/'.$machine_code])) {
            // Retrieve the list of fields
            $fields = array();
            // Loop through each field
            foreach ($this->fields as $fld_machine_code => $field_instance) {
                // If this is not a question field
                if (!$field_instance->is_question) { continue; }
                // Populate the ordered list
                $fields[$fld_machine_code] = $field_instance;
            }
            // If the questions are to be randomised
            if ($this->Is_Randomised()) {
                // Randomise the fields list
                $fields = $this->_Add_Chaos($fields);
            } 
            // Loop through each saved field order
            foreach ($fields as $fld_machine_code => $field_instance) {
                // Retrieve the field instance
                $this->field_order[] = $fld_machine_code;
            }
            // Save to the form's session information
            $_SESSION["vcff/$session_id/ch"]['group_fields/'.$machine_code] = $this->field_order;
        } // Set the field order 
        else { $this->field_order = $session_data['group_fields/'.$machine_code]; } 
    }
    
    public function Get_Question_Number() {
        // Retrieve the element
        $el = $this->el;
        // If no question number has been specified
        if (!isset($el->attributes['ch_questions_number']) || !$el->attributes['ch_questions_number']) { return 1; }
        // Retrieve the number of allowed fields
        return intval($el->attributes['ch_questions_number']);
    }
    
    public function Calc_Current() {
        // Retrieve the form instance
        $form_instance = $this->form_instance;
        // Retrieve the list of fields
        $fields = $this->fields;
        // Retrieve the field order
        $field_order = $this->field_order;
        // If there is no field order
        if (!is_array($field_order)) { return; }
        // Reset the current array
        $this->current = array();
        // The list of ordered fields
        $_ordered = array();
        // Loop through each field
        foreach ($field_order as $k => $fld_machine_code) {
            // Populate the ordered list
            $_ordered[$fld_machine_code] = $fields[$fld_machine_code];
        } 
        // FIRST PASS - Questions marked as correct or PENDING are ALWAYS visible
        foreach ($_ordered as $fld_machine_code => $field_instance) {
            // If we have already reached the current number
            if (count($this->current) >= $this->Get_Question_Number()) { continue; }
            // If the field has already been added
            if (isset($this->current[$fld_machine_code])) { continue; }
            // If not marked
            if (!$field_instance->Is_Marked()) { continue; }
            // If not corrent or pending
            if (!$field_instance->Is_Correct() && !$field_instance->Is_Pending()) { continue; }
            // Otherwise make current
            $this->current[$fld_machine_code] = $field_instance;
        }
        // SECOND PASS - Questions not marked are sometimes visible
        foreach ($_ordered as $fld_machine_code => $field_instance) {
            // If we have already reached the current number
            if (count($this->current) >= $this->Get_Question_Number()) { continue; }
            // If the field has already been added
            if (isset($this->current[$fld_machine_code])) { continue; }
            // If not marked
            if ($field_instance->Is_Marked()) { continue; }
            // Otherwise make current
            $this->current[$fld_machine_code] = $field_instance;
        }
        // THIRD PASS - Any Remaining Questions
        foreach ($_ordered as $fld_machine_code => $field_instance) {
            // If we have already reached the current number
            if (count($this->current) >= $this->Get_Question_Number()) { continue; }
            // If the field has already been added
            if (isset($this->current[$fld_machine_code])) { continue; }
            // Otherwise make current
            $this->current[$fld_machine_code] = $field_instance;
        }
        // If there are no current fields
        if (!is_array($this->current)) { return; } 
        // loop through the current fields
        foreach ($_ordered as $fld_machine_code => $field_instance) {
            // If the field has already been added
            if (isset($this->current[$fld_machine_code])) {
                // Set the field as visible
                $field_instance->is_hidden = false;  
            } // Otherwise hide 
            else { $field_instance->is_hidden = true; }
            
            $field_instance->ajax['marked'] = $field_instance->Is_Marked();
        }
    }
    
    
    
}