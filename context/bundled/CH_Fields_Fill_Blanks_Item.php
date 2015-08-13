<?php

class CH_Fields_Fill_Blanks_Item extends CH_Question_Item {
    
    public $blanks;
    
    public function On_Create() {
        // Retrieve the shortcode element
        $el = $this->el;
        // If no first child
        if (!isset($el->children[0])) { return; }
        // Retrieve the first child
        $el_first_child = $el->children[0];
        // Retrieve the string contents
        $el_contents = $el_first_child->string;
        // Create a new parser
        $blq_parser = new BLQ_Parser($el_contents);
        // Retrieve a list of shortcodes
        $_options = $blq_parser
            ->Set_Ends('{','}')
            ->Parse()
            ->Get_Flattened();
        // Retrieve the posted value
        $posted_value = $this->posted_value;
        // Loop through each option
        $i=0; foreach ($_options as $k => $_option_el) {
            // If this is not a tag we are after
            if (!$_option_el->is_tag) { continue; }
            // Populate the blanks
            $this->blanks[] = array(
                'i' => $i,
                'el' => $_option_el,
                'answers' => explode('|',$_option_el->string),
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
        $blanks = $this->blanks;
        // If no blanks are provided
        if (!$blanks || !is_array($blanks) || count($blanks) == 0) { return; }
        // If there are blanks to loop through
        foreach ($blanks as $k => $_blank) {
            // Retrieve the value
            $_value = $_blank['value'];
            // If the anwer was incorrect
            if (!$_blank['value'] || !preg_grep("/".$_blank['value']."/i",$_blank['answers'])) {
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
            'extra_class'=>'',
            'css'=>'',
        ), $this->attributes));
        
        $blanks = $this->blanks;
        
        foreach ($blanks as $k => $_blank) {
        
            $blank_input = '<input name="'.$machine_code.'['.$_blank['i'].']" type="text" value="'.$_blank['value'].'" class="">';
        
            $content = str_replace($_blank['el']->raw,$blank_input,$content);
        }
        
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