<?php

class CH_Basic_Form extends CH_Form_Item {

    static $form_type = 'ch_basic_form';
    
    static $form_title = 'Basic Challenge Form';
    
    static $item_class = 'CH_Basic_Form_Item';
    
    static function Form_Meta() {
        // Return the required meta fields
        return array(
            // Add any custom pages for this form type
            'pages' => array(),
            // Add any custom form groups
            'groups' => array(),
            // Add any custom form fields
            'fields' => array()
        );
    }
    
    static function Form_Settings() {
        // Return the required meta fields
        return array();
    }
    
    static function Form_Params() {
        // Return any form params
        return array();
    }
}

vcff_map_form('CH_Basic_Form');