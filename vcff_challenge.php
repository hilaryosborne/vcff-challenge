<?php

/*
* Plugin Name: VC Form Framework - Challenge Addon
* Plugin URI: http://theblockquote.com/
* Description: Reports and entries addon for the visual composer form framework core plugin
* Version: 0.0.1
* Author: Hilary Osborne - BlockQuote
* Author URI: http://theblockquote.com/
* License: License GNU General Public License version 2 or later;
* Copyright 2015 theblockquote
*/

// Require the wp upgrade library
require_once(ABSPATH.'wp-admin/includes/upgrade.php');

if (!defined('VCFF_CHALLENGE_DIR'))
{ define('VCFF_CHALLENGE_DIR',untrailingslashit( plugin_dir_path(__FILE__ ) )); }

if (!defined('VCFF_CHALLENGE_URL'))
{ define('VCFF_CHALLENGE_URL',untrailingslashit( plugins_url( '/', __FILE__ ) )); }

class VCFF_Challenge {
    
    public function __construct() {
        // Initalize core logic
        add_action('vcff_init_core',array($this,'__Init_Core'),30);
        // Initalize context logic
        add_action('vcff_init_context',array($this,'__Init_Context'),30);
        // Initalize misc logic
        add_action('vcff_init_misc',array($this,'__Init_Misc'),30);  
    }
    
    public function __Init_Core() {
        // Load helper classes
        $this->_Load_Helpers();
        // Load the core classes
        $this->_Load_Core(); 
    }

    public function __Init_Context() {
        // Load the context classes
        $this->_Load_Context();
    }
    
    public function __Init_Misc() {
        // Load the pages
        $this->_Load_Pages();
        // Load AJAX
        $this->_Load_AJAX();
    }
    
    public function _Load_Helpers() {
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Recurssively load the directory
        $this->_Recusive_Load_Dir($dir.'/helpers');
    }
    
    protected function _Load_Core() {
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Recurssively load the directory
        $this->_Recusive_Load_Dir($dir.'/core');
    }
    
    public function _Load_Context() {
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Recurssively load the directory
        $this->_Recusive_Load_Dir($dir.'/context');
    }

    public function _Load_Pages() {
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Recurssively load the directory
        $this->_Recusive_Load_Dir($dir.'/pages');
    }
    
    protected function _Load_AJAX() {
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Recurssively load the directory
        $this->_Recusive_Load_Dir($dir.'/ajax');
    }
    
    protected function _Recusive_Load_Dir($dir) {
        // If the directory doesn't exist
        if (!is_dir($dir)) { return; }
        // Load each of the field shortcodes
        foreach (new DirectoryIterator($dir) as $FileInfo) {
            // If this is a directory dot
            if ($FileInfo->isDot()) { continue; }
            // If this is a directory
            if ($FileInfo->isDir()) { 
                // Load the directory
                $this->_Recusive_Load_Dir($FileInfo->getPathname());
            } // Otherwise load the file
            else {
                // If this is not false
                if (stripos($FileInfo->getFilename(),'.tpl') !== false) { continue; } 
                // If this is not false
                if (stripos($FileInfo->getFilename(),'.php') === false) { continue; } 
                // Include the file
                require_once($FileInfo->getPathname());
            }
        }
    }
    
}

add_action('vcff_init',function(){

    $vcff_challenge = new VCFF_Challenge(); 

    vcff_register_library('vcff_challenge',$vcff_challenge);
    
});
