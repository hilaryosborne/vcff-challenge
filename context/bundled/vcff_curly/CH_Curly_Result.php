<?php

class CH_Curly_Result extends VCFF_Item {
    
    public $form_instance;
    
    public $tag = 'ch_result';
    
    public $name = 'CH Form Result';
    
    public $category = 'Challenge';
    
    public $hint = 'ch_result';
    
    /**
     * Returns a single tag array
     */
    public function Get_Tag() {
        // Populate the curly tags
        $tag = array(
            'code' => $this->tag,
            'category' => $this->category,
            'hint' => $this->hint,
            'name' => $this->name,
            'method' => array($this,'_Render'),
        );
        // Return the tag
        return $tag;
    }
    
    /**
     * Returns multiple hints for this curly tag
     */
    public function Get_Hints() {
        // Retrieve the form instance
        $form_instance = $this->form_instance;
        // The list for all code hints
        $hints = array();
        // Populate the curly tags
        $hints[] = array(
            'code' => $this->tag,
            'category' => $this->category,
            'hint' => $this->hint,
            'name' => $this->name,
            'method' => array($this,'_Render')
        );
        // Return the hint list
        return $hints;
    }
    
    public function _Render() {
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
        if ($noanswer > 0 || $ischecked == 0) { return 'Incomplete'; }
        // Return the form has passed
        if ($correct == $ischecked) { return 'Passed'; }
        // Return the form has failed
        if ($negative > 0) { return 'Failed'; }
        // Return the pending mark status
        if ($pending > 0) { return 'Pending Marking'; }
    }
}

vcff_map_context('CH_Curly_Result');
