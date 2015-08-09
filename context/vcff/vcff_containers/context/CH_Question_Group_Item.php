<?php

class CH_Question_Group_Item extends CH_Group_Item {
    
    public function Do_Closure() { 

        $this->_Visibility();
    }
    
    protected function _Visibility() {
        // Retrieve the element
        $el = $this->el;
        // Retrieve the machine code of the container
        $machine_code = $this->machine_code;
        // Retrieve the form instance
        $form_instance = $this->form_instance;
        // Retrieve the list of fields
        $fields = $this->fields;
        // If there are no fields in the container, return out
        if (!$fields || !is_array($fields) || count($fields) == 0) { return; }
        // If no question number has been specified
        if (!isset($el->attributes['ch_questions_number']) || !$el->attributes['ch_questions_number']) { return; }
        // Retrieve the number of allowed fields
        $field_number = intval($el->attributes['ch_questions_number']);
        // If the questions are to be randomised
        if (isset($el->attributes['ch_randomise_questions']) && $el->attributes['ch_randomise_questions'] == 'yes') { 
            // Retrieve the session data
            $session_data = $form_instance->Get_Session_Data();
            // If there is a current fields list
            if (isset($session_data['ch']['group_fields_'.$machine_code])) {
                // A temp fields array
                $_fields = array();
                // Retrieve the saved field order
                $saved_field_order = $session_data['ch']['group_fields_'.$machine_code];
                // Loop through each saved field order
                foreach ($saved_field_order as $k => $fld_machine_code) {
                    // Retrieve the field instance
                    $field_instance = $fields[$fld_machine_code];
                    // Populate the fields array
                    $_fields[$fld_machine_code] = $field_instance;
                }
                // Repopulate the fields list
                $fields = $_fields;
            } // Otherwise generate a new fields list 
            else {
                // Randomise the fields list
                $fields = $this->_Add_Chaos($fields);
                // A temp fields array
                $_fields = array();
                // Loop through each saved field order
                foreach ($fields as $fld_machine_code => $field_instance) {
                    // Retrieve the field instance
                    $_fields[] = $fld_machine_code;
                }
                // Save to the form's session information
                $session_data['ch']['group_fields_'.$machine_code] = $_fields;
                // Update the form's session
                $form_instance->Set_Session_Data($session_data);
            }
        }
        // If the number of fields is less than one, return out
        if ($field_number < 1) { return; }
        // Vars to be used in the search
        $visible_i = 0; $visible_ar = array(); 
        // FIRST PASS - Questions marked as correct or PENDING are ALWAYS visible
        foreach ($fields as $fld_machine_code => $field_instance) {
            // If this is not a question field
            if (!$field_instance->is_question) { continue; }
            // If the field has been marked and is incorrect
            if (!$field_instance->Is_Marked() || (!$field_instance->Is_Correct() && !$field_instance->Is_Pending())) { 
                // Set the field as hidden
                $field_instance->is_hidden = true; continue; 
            }
            // Set the field as visible
            $field_instance->is_hidden = false; $visible_i++;
        }
        // SECOND PASS - Questions not marked are sometimes visible
        foreach ($fields as $fld_machine_code => $field_instance) {
            // If this is not a question field
            if (!$field_instance->is_question) { continue; }
            // If the question is NOT hidden then continue
            if (!$field_instance->Is_Hidden()) { continue; }
            // If the field has been marked
            if ($visible_i >= $field_number || $field_instance->Is_Marked()) { 
                // Set the field as hidden
                $field_instance->is_hidden = true; continue; 
            }
            // Set the field as visible
            $field_instance->is_hidden = false; $visible_i++;
        }
        // THIRD PASS - Any Remaining Questions
        foreach ($fields as $fld_machine_code => $field_instance) {
            // If this is not a question field
            if (!$field_instance->is_question) { continue; }
            // If the question is NOT hidden then continue
            if (!$field_instance->Is_Hidden()) { continue; }
            // If the field has been marked
            if ($visible_i >= $field_number) { 
                // Set the field as hidden
                $field_instance->is_hidden = true; continue; 
            }
            // Set the field as visible
            $field_instance->is_hidden = false; $visible_i++;
        }
    }

    public function Render($content) { 
        // Convert attrs to vars
        extract(shortcode_atts(array(
            'machine_code' => '',
            'label' => '',
            'conditions' => '',
            'extra_class' => '',
            'css' => ''
        ), $this->attributes));
        // Compile the css class
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), $this->settings['base'], $atts);
        // Start gathering content
        ob_start();
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Include the template file
        include(vcff_get_file_dir($dir.'/'.get_class($this).".tpl.php"));
        // Get contents
        $output = ob_get_contents();
        // Clean up
        ob_end_clean();
        // Apply any container filters
        $html = apply_filters('form_container_content', $output, $this );
        // Return the contents
        return $html;
    }
    
}