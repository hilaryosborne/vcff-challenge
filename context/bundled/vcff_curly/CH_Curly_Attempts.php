<?php

class CH_Curly_Attempts extends VCFF_Item {
    
    public $form_instance;
    
    public $tag = 'ch_attempts';
    
    public $name = 'CH Submission Attempts';
    
    public $category = 'Challenge';
    
    public $hint = 'ch_attempts';
    
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
        // Retreiev the form session id
        $session_id = $form_instance->Get_Session_ID();
        // If we already have set the field order
        if (isset($_SESSION["vcff/$session_id/ch"])) {
            // Populate the session data
            $session_data = $_SESSION["vcff/$session_id/ch"];
            // If the attempts are set
            if (isset($session_data['attempts'])) {
                // Update the attempts
                return $session_data['attempts'];
            }
        }
    }
}

vcff_map_context('CH_Curly_Attempts');
