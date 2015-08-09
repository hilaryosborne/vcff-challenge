<?php

class CH_Trigger_Result {
    
    static $code = 'ch_result';
    
    static $title = 'Use challenge result';
    
	static $class_item = 'CH_Trigger_Result_Item';
	
    static function Params() {
        // Return any field params
        return array();
    } 
}

vcff_map_trigger('CH_Trigger_Result');