<?php

class CH_Curly_History extends VCFF_Item {
    
    public $form_instance;
    
    public $tag = 'ch_history';
    
    public $name = 'CH Submission History';
    
    public $category = 'Challenge';
    
    public $hint = 'ch_history';
    
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
            'hint' => $this->hint.':text',
            'name' => $this->name,
            'method' => array($this,'_Render')
        );
        // Populate the curly tags
        $hints[] = array(
            'code' => $this->tag,
            'category' => $this->category,
            'hint' => $this->hint.':html',
            'name' => $this->name,
            'method' => array($this,'_Render')
        );
        // Return the hint list
        return $hints;
    }
    
    public function _Render($mode) {
        // Retrieve the form instance
        $form_instance = $this->form_instance;
        // Retreiev the form session id
        $session_id = $form_instance->Get_Session_ID();
        // If we already have set the field order
        if (isset($_SESSION["vcff/$session_id/ch"])) {
            // Populate the session data
            $session_data = $_SESSION["vcff/$session_id/ch"];
        } // Otherwise set with an empty array
        else { $session_data = array(); }
        // If there is no history
        if (!isset($session_data['history']) || !is_array($session_data['history'])) { return; }
        // Retrieve the form history
        $form_history = $session_data['history'];
        
        $html = '<div>';
        // Loop through each history
        foreach ($form_history as $k => $_history) {
            // Start the HTML item
            $html .= '<div>';
            $html .= '<div>Submitted on '.date('d/m/Y',$_history['time']).'</div>';
            // Loop through each field
            foreach ($_history['fields'] as $_k => $_field) {
                $html .= '<div>'.$_field['label'].' ('.$_field['status'].')</div>';
            }
            // End the HTML item
            $html .= '</div>';
        }
        // End the HTML
        $html .= '</div>';
        // Return the contents
        return $html;
    }
}

vcff_map_context('CH_Curly_History');
