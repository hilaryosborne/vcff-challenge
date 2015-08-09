<?php

class CH_Fields_Matching_Item extends CH_Question_Item {
    
    public $inputs;
    
    public function On_Create() {
        // Retrieve the shortcode element
        $el = $this->el;
        // Retrieve the allowed options
        $el_options = explode("\n",urldecode(base64_decode($el->attributes['ch_options'])));
        // Retrieve any extra options
        $el_extra_options = explode("\n",urldecode(base64_decode($el->attributes['ch_extra_options'])));
        // List to store possible answers
        $possible_answers = array();
        // Loop through each option
        foreach ($el_options as $k => $_row) {
            // Explode the row by the bar
            $exploded = explode('|',$_row);
            // Add to the possible answers list
            $possible_answers[] = $exploded[1];
        }
        // Merge in any extra options
        $possible_answers = array_merge($possible_answers,$el_extra_options);
        // If we are going to randomise the answers
        if ($el->attributes['ch_randomise'] == 'yes') {
            // Run the option list through the randomiser
            $possible_answers = $this->_Add_Chaos($possible_answers); 
        }
        // Retrieve the posted value
        $posted_value = $this->posted_value;
        // List to store possible answers
        $this->inputs = array(); 
        // Loop through each option
        $i=0; foreach ($el_options as $k => $_row) {
            // Explode the row by the bar
            $exploded = explode('|',$_row);
            // Add to the possible answers list
            $this->inputs[] = array(
                'i' => $i,
                'left' => $exploded[0],
                'right' => $possible_answers,
                'answer' => $exploded[1],
                'value' => isset($posted_value[$i]) ? $posted_value[$i] : null
            ); $i++;
        }
    }
    
    protected function _Auto_Mark() {
        // Retrieve the shortcodes
        $attributes = $this->attributes;
        // Retrieve the posted value
        $posted_value = $this->posted_value;
        // If no posted value has been provided
        if (!$posted_value || !is_array($posted_value) || $this->_Is_Empty()) {
            // Do any is locked action
            do_action('ch_field_mark_auto',$this); return;
        }
        // The is correct flag
        $is_correct = true;
        // Retrieve the list of blanks
        $inputs = $this->inputs;
        // If no blanks are provided
        if (!$inputs || !is_array($inputs) || count($inputs) == 0) { return; } 
        // If there are blanks to loop through
        foreach ($inputs as $k => $_input) {
            // Retrieve the value
            $_value = $_input['value'];
            // If the anwer was incorrect
            if ($_input['value'] != $_input['answer']) {
                // Set the question to false
                $is_correct = false;
            }
        } 
        // Set the correct flag
        $this->mark = $is_correct ? 'CORRECT' : 'INCORRECT';
        // Do any is locked action
        do_action('ch_field_mark_auto',$this);
    }
    
    public function Form_Render($attributes,$content,$shortcode) {
        // Convert attrs to vars
        extract(shortcode_atts(array(
            'field_label'=>'',
            'machine_code' => '',
            'default_value'=>'',
            'options'=>'',
            'conditions'=>'',
            'extra_class'=>'',
            'css'=>'',
        ), $this->attributes));
        // Compile the css class
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $this->attributes);
        // The options list
        $posted_value = $this->posted_value;
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
        // Return the contents
        return $output;
    }
    
}