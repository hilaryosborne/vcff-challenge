<?php

class CH_Curly_Points extends VCFF_Item {
    
    public $form_instance;
    
    public $tag = 'ch_points';
    
    public $name = 'CH Form Points';
    
    public $category = 'Challenge';
    
    public $hint = 'ch_points';
    
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
        $current_points = 0; $total_points = 0;
        // Loop through each form field
        foreach ($form_fields as $machine_code => $field_instance) {
            // If the field is currently hidden
            if ($field_instance->Is_Hidden()) { continue; }
            // If the field instance is not a question
            if (!$field_instance->is_question) { continue; }
            // The total points
            $total_points = ($total_points+$field_instance->Get_Points());
            // If the question is not empty
            if (!$field_instance->Is_Correct()) { continue; }
            // Inc up the points value
            $current_points = ($current_points+$field_instance->Get_Points());
        }
        // Return the current points
        return (int)$current_points.'/'.(int)$total_points;
    }
}

vcff_map_context('CH_Curly_Points');
