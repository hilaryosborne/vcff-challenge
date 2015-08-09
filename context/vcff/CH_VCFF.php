<?php

class CH_VCFF {
    
    public function __construct() { 
        add_action('vcff_forms_context_init',array($this,'_Add_Forms'));
        add_action('vcff_field_context_init',array($this,'_Add_Fields'));
        add_action('vcff_container_init',array($this,'_Add_Containers'));
        add_action('vcff_supports_context_init',array($this,'_Add_Supports'));
        $this->_Add_Settings();
    }
    
    public function _Add_Forms() { 
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Load core items
        $this->_Load_Dir($dir.'/vcff_forms/core');
        // Load context items
        $this->_Load_Dir($dir.'/vcff_forms/context');
    }
    
    public function _Add_Settings() {
    
        
    }
    
    public function _Add_Containers() { 
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Load core items
        $this->_Load_Dir($dir.'/vcff_containers/core');
        // Load context items
        $this->_Load_Dir($dir.'/vcff_containers/context');
    }

    public function _Add_Fields() { 
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Load core items
        $this->_Load_Dir($dir.'/vcff_fields/core');
        // Load context items
        $this->_Load_Dir($dir.'/vcff_fields/context');
    }
    
    public function _Add_Supports() { 
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Load core items
        $this->_Load_Dir($dir.'/vcff_supports/core');
        // Load context items
        $this->_Load_Dir($dir.'/vcff_supports/context');
    }
    
    protected function _Load_Dir($dir) {
        // If this is not a directory
        if (!is_dir($dir)) { return; }
        // Load each of the field shortcodes
        foreach (new DirectoryIterator($dir) as $FileInfo) {  
            // If this is a directory dot
            if ($FileInfo->isDot()) { continue; }
            // If this is a directory
            if ($FileInfo->isDir()) { continue; }
            // If this is not false
            if (stripos($FileInfo->getFilename(),'.tpl') !== false) { continue; } 
            // Include the file
            require_once($FileInfo->getPathname());
        }
    }
}

new CH_VCFF();

