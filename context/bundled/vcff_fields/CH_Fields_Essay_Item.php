<?php

class CH_Fields_Essay_Item extends CH_Question_Item {
    
    public function Form_Render($attributes,$content,$shortcode) { 
        // Convert attrs to vars
        extract(shortcode_atts(array(
            'field_label'=>'',
            'machine_code' => '',
            'default_value'=>'',
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
    
    public function Get_HTML_Value() {

        $html = '<div class="posted-field">';
        $html .= '<div class="field-label"><strong>'.$this->Get_Label().'</strong></div>';
        $html .= '<p class="field-contents">'.$this->Get_Contents().'</p>';
        $html .= '<div class="field-value">'.$this->Get_Value().'</div>';
        $html .= '</div>';
        
        return $html;
    }
    
    public function Get_TEXT_Value() {
        
        $text .= $this->Get_Label()."\n";
        $text .= $this->Get_Contents()."\n\r";
        $text .= $this->Get_Value()."\n";
        
        return $text;
    }
    
}