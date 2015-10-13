<?php

class CH_Question_Item extends VCFF_Field_Item {

    public $is_correct;
    
    public $is_marked;
    
    public $is_locked;
    
    public $is_question = true;
    
    public $mark;
    
    public $points;
    
    public $points_awarded;
    
    public $comment;
    
    public function Mark() { 
        // Retrieve the form instance
        $form_instance = $this->form_instance; 
        // Retrieve the shortcodes
        $attributes = $this->attributes; 
        // If we have automark enabled
        if ($this->Is_Auto_Mark()) { 
            // Run the automark function
            $this->_Auto_Mark();
        } // Otherwise if we have manual mark on  
        else { $this->_Manual_Mark(); }
        // Do any is locked action
        do_action('ch_field_mark',$this);
    }
    
    protected function _Manual_Mark() {
        // Retrieve the shortcodes
        $this->mark = 'PENDING';
        // Do any is locked action
        do_action('ch_field_mark_manual',$this);
    }
    
    public function Is_Correct() {
        // If the field has not been marked
        if (!$this->mark) { return; }
        // Return the mark bool
        return $this->mark == 'CORRECT' ? true : false;
    }
    
    public function Is_Incorrect() {
        // If the field has not been marked
        if (!$this->mark) { return; }
        // Return the mark bool
        return $this->mark == 'INCORRECT' ? true : false;
    }
    
    public function Is_Pending() {
        // If the field has not been marked
        if (!$this->mark) { return; }
        // Return the mark bool
        return $this->mark == 'PENDING' ? true : false;
    }
    
    public function Is_Marked() {
        // Do any is locked action
        do_action('ch_field_is_marked',$this);
        // Return the locked flag
        return $this->mark ? true : false;
    }
    
    public function Is_Empty() {
        // Retrieve the posted value
        $posted_value = $this->posted_value;
        
        return $this->_Is_Empty_Recur($posted_value);
    }
    
    protected function _Is_Empty() {
        // Retrieve the posted value
        $posted_value = $this->posted_value;
        
        return $this->_Is_Empty_Recur($posted_value);
    }
    
    protected function _Is_Empty_Recur($value) {
        // If the posted value is an array
        if (is_array($value)) {
            // The empty flag
            $is_empty = true;
            // Loop through each value
            foreach ($value as $k => $_value) {
                // If this is another array
                if (is_array($_value)) {
                    // Populate the is empty with the recursive result
                    $is_empty = $this->_Is_Empty_Recur($_value);
                } // Otherwise check the string
                elseif ($_value || $_value != '') { $is_empty = false; }
            } // Return the is empty flag
            return $is_empty;
        } // Otherwise if there is no posted vlaue 
        elseif (!$value || $value == '') { return true; }
    }
    
    public function Is_Auto_Mark() {
        // Retrieve the shortcodes
        $attributes = $this->attributes; 
        // If we have automark enabled
        if (isset($attributes['ch_automark']) && $attributes['ch_automark'] != '') { 
            // Run the automark function
            return true;
        } // Otherwise if we have manual mark on  
        else { return false; }
    }
    
    public function Is_Locked() {
        // Do any is locked action
        do_action('ch_field_is_locked',$this);
        // Return the locked flag
        return $this->is_locked;
    }
    
    public function Get_Correct_Msg() {
        // Retrieve the form instance
        $form_instance = $this->form_instance;
        // Retrieve the shortcodes
        $attributes = $this->attributes;
        // If we have automark enabled
        if (isset($attributes['ch_correct_msg']) && $attributes['ch_correct_msg'] != '') {
            // Apply any filter
            $message = apply_filters('ch_field_correct_msg',urldecode(base64_decode($attributes['ch_correct_msg'])),$this);
            // Run the automark function
            return vcff_curly_compile($form_instance,$message);
        } // Otherwise if we have manual mark on  
        else { return 'Correct Answer!'; }
    }
    
    public function Get_Incorrect_Msg() {
        // Retrieve the form instance
        $form_instance = $this->form_instance;
        // Retrieve the shortcodes
        $attributes = $this->attributes;
        // If we have automark enabled
        if (isset($attributes['ch_incorrect_msg']) && $attributes['ch_incorrect_msg'] != '') {
            // Apply any filter
            $message = apply_filters('ch_field_incorrect_msg',urldecode(base64_decode($attributes['ch_incorrect_msg'])),$this);
            // Run the automark function
            return vcff_curly_compile($form_instance,$message);
        } // Otherwise if we have manual mark on  
        else { return 'Incorrect Answer!'; }
    }
    
    public function Get_Comment_Msg() {
        
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
    
    public function Get_Points() {
        // Retrieve the shortcodes
        $attributes = $this->attributes;
        // If we have automark enabled
        if (isset($attributes['ch_point_value']) && $attributes['ch_point_value'] != '') {
            // Apply any filter
            $points = apply_filters('ch_field_points',$attributes['ch_point_value'],$this);
            // Run the automark function
            return $points;
        } // Otherwise if we have manual mark on  
        else { return 0; }
    }
    
    public function Get_Points_Awarded() {
        // If the question is not marked correct
        if (!$this->Is_Correct()) { return 0; }
        // Apply any filter
        $points_awarded = apply_filters('ch_field_points_awarded',$this->points_awarded,$this);
        // Return the points awarded
        return $points_awarded;
    }
    
}