<?php

class CH_Fields_Single_Choice_Item extends CH_Question_Item {
    
    public $inputs;
    
    public function On_Create() {
        // Retrieve the shortcode element
        $el = $this->el;
        // Retrieve the posted value
        $posted_value = $this->posted_value;
        // List to store possible answers
        $this->inputs = array(); 
        // Retrieve the allowed options
        $el_options = explode("\n",urldecode(base64_decode($el->attributes['ch_options'])));
        // Loop through each option
        $i=0; foreach ($el_options as $k => $_option) {
            // Reset the option vars
            $option_id = false; $option_text = false; 
            // Check if this option has a defined value (which they should)
            if (trim(substr($_option,0,1)) == '[') {
                // Extract all of the shortcodes from the content
                preg_match_all("/\[(.*?)\]/", $_option, $sqr_matches);
                // If there are no squares found
                $option_id = $sqr_matches[1][0];
                // The option text
                $option_text = trim(str_replace('['.$option_id.']','',$_option));
            }
            // Add to the possible answers list
            $this->inputs[] = array(
                'i' => $option_id ? $option_id : $i,
                'text' => $option_text ? $option_text : $_option
            ); $i++;
        }
        // If we are going to randomise the answers
        if ($el->attributes['ch_randomise'] == 'yes') {
            // Run the option list through the randomiser
            $this->inputs = $this->_Add_Chaos($this->inputs); 
        }
    }
    
    protected function _Auto_Mark() {
        // Retrieve the shortcodes
        $attributes = $this->attributes;
        // Retrieve the posted value
        $posted_value = $this->posted_value;
        // If no posted value has been provided
        if (!$posted_value || $this->_Is_Empty()) {
            // Do any is locked action
            do_action('ch_field_mark_auto',$this); return;
        }
        // If the randomise option exists
        $answers = explode('|',$attributes['ch_answers']); 
        // The is correct flag
        $is_correct = false;
        // Loop through each potential answer
        foreach ($answers as $k => $_answer) {
            // If an array was provided
            if ($posted_value == $_answer) { $is_correct = true; }
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