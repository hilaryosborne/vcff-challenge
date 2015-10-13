<?php

class CH_Curly_Progress extends VCFF_Item {
    
    public $form_instance;
    
    public $tag = 'ch_progress';
    
    public $name = 'CH Form Progress';
    
    public $category = 'Challenge';
    
    public $hint = 'ch_progress';
    
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
        // Return the contents
        return '3/15 Questions Answered';
    }
}

vcff_map_context('CH_Curly_Progress');
