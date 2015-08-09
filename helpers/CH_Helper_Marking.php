<?php

class CH_Helper_Marking {
    
    protected $form_instance;	
	
	public function Set_Form_Instance($form_instance) {
		
		$this->form_instance = $form_instance;
		
		return $this;
	}
    
    public function Mark() {
        
        $this->_Pre_Marking();
        
        $this->_Mark_Fields();
        
        $this->_Mark_Containers();
        
        $this->_Mark_Form();
        
        $this->_Post_Marking();
        
    }
    
    protected function _Pre_Marking() {
        /// Retrieve the form instance
		$form_instance = $this->form_instance;
        // If this form has a custom validation method
        if (method_exists($form_instance,'Pre_Marking')) { $form_instance->Pre_Marking(); }
        // Retrieve the validation result
        do_action('vcff_pre_marking', $form_instance);
    }
    
    protected function _Mark_Fields() {
        // Retrieve the form instance
		$form_instance = $this->form_instance;
		// Retrieve the form's fields
        $form_fields = $form_instance->fields;
		// If there are no form fields
		if (!$form_fields || !is_array($form_fields)) { return; }
		// Loop through each containers
		foreach ($form_fields as $_name => $field) { 
			// If this field has a custom validation method
			if (method_exists($field,'Do_Marking')) { $field->Do_Marking(); }
            // Retrieve the validation result
            do_action('vcff_field_marking', $field);
		}
    }
    
    protected function _Mark_Containers() {
        // Retrieve the form instance
		$form_instance = $this->form_instance;
		// Retrieve the form's fields
		$form_containers = $form_instance->containers;
		// If there are no form containers
		if (!$form_containers || !is_array($form_containers)) { return; }
		// Loop through each of the form's containers
		foreach ($form_containers as $k => $container_instance) {
			// If this field has a custom validation method
			if (method_exists($container_instance,'Do_Marking')) { $container_instance->Do_Marking(); }
            // Retrieve the validation result
            do_action('vcff_container_marking', $container_instance);
        }
    }
    
    protected function _Mark_Form() {
        /// Retrieve the form instance
		$form_instance = $this->form_instance;
        // If this form has a custom validation method
        if (method_exists($form_instance,'Do_Marking')) { $form_instance->Do_Marking(); }
        // Retrieve the validation result
        do_action('vcff_form_marking', $form_instance);
    }
    
    protected function _Post_Marking() {
        /// Retrieve the form instance
		$form_instance = $this->form_instance;
        // If this form has a custom validation method
        if (method_exists($form_instance,'Post_Marking')) { $form_instance->Post_Marking(); }
        // Retrieve the validation result
        do_action('vcff_post_marking', $form_instance);
    }
}