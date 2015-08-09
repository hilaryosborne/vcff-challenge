<?php

class CH_Group_Item extends VCFF_Container_Item {
    
    protected function _Add_Chaos($options) {
        // If not an array, return out
        if (!is_array($options)) { return $options; } 
        // Create a chaos value
        $chaos = rand(2,20);
        // Loop through
        for ($i=0;$i<$chaos;$i++) {
            // Return the array keys
            $keys = array_keys($options); 
            // Shuffle returned keys
            shuffle($keys);
            // Temp random var
            $random = array(); 
            // Loop through and populate random 
            foreach ($keys as $key) { $random[$key] = $options[$key];  }
            // Populate the options
            $options = $random;
        }
        // Return the options
        return $options; 
    }
    
}