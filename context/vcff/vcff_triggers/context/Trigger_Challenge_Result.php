<?php

class CH_Trigger_Result {
    
    static $code = 'ch_result';
    
    static $title = 'Use challenge result';
    
	static $class_item = 'Trigger_Challenge_Result_Item';
	
    static function Params() {
        // Return any field params
        return array();
    } 
}

vcff_map_trigger('Trigger_Challenge_Result');