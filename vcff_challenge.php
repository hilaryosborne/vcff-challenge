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

define('VCFF_CHALLENGE_SQL_VERSION','0.0.1');

class VCFF_Challenge {
    
    public function Init() {
        // Fire the shortcode init action
        do_action('vcff_challenge_before_init',$this);
        // Include the admin class
        require_once(VCFF_CHALLENGE_DIR.'/functions.php');
        // Load helper classes
        $this->_Load_Helpers();
        // Load the event classes
        $this->_Load_Context();
        // Load the pages
        $this->_Load_Pages();
        // Load the AJAX
        $this->_Load_AJAX();
        // Fire the shortcode init action
        do_action('vcff_challenge_init',$this);
        // Fire the shortcode init action
        do_action('vcff_challenge_after_init',$this);
        // Return for chaining
        return $this;
    }
    
    protected function _Load_Helpers() {
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Load each of the field shortcodes
        foreach (new DirectoryIterator($dir.'/helpers') as $FileInfo) { 
            // If this is a directory dot
            if($FileInfo->isDot()) { continue; }
            // If this is a directory
            if($FileInfo->isDir()) { continue; }
            // If this is not false
            if (stripos($FileInfo->getFilename(),'.tpl') !== false) { continue; } 
            // Include the file
            require_once($FileInfo->getPathname());
        }
        // Fire the shortcode init action
        do_action('vcff_challenge_helper_init',$this);
    }
    
    protected function _Load_Context() {
         // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Load each of the field shortcodes
        foreach (new DirectoryIterator($dir.'/context') as $FileInfo) { 
            // If this is a directory dot
            if ($FileInfo->isDot()) { continue; }
            // If this is a directory
            if ($FileInfo->isDir()) { 
                // Load each of the field shortcodes
                foreach (new DirectoryIterator($FileInfo->getPathname()) as $_FileInfo) {
                    // If this is a directory dot
                    if ($_FileInfo->isDot()) { continue; }
                    // If this is a directory
                    if ($_FileInfo->isDir()) { continue; }
                    // If this is not false
                    if (stripos($_FileInfo->getFilename(),'.tpl') !== false) { continue; } 
                    // Include the file
                    require_once($_FileInfo->getPathname());
                }
            } // Otherwise this is just a file
            else {
                // If this is not false
                if (stripos($FileInfo->getFilename(),'.tpl') !== false) { continue; } 
                // Include the file
                require_once($FileInfo->getPathname());
            }
        }
        // Fire the shortcode init action
        do_action('vcff_challenge_context_init',$this);
    }
    
    protected function _Load_Pages() {
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Load each of the field shortcodes
        foreach (new DirectoryIterator($dir.'/pages') as $FileInfo) { 
            // If this is a directory dot
            if($FileInfo->isDot()) { continue; }
            // If this is a directory
            if($FileInfo->isDir()) { continue; }
            // If this is not false
            if (stripos($FileInfo->getFilename(),'.tpl') !== false) { continue; } 
            // Include the file
            require_once($FileInfo->getPathname());
        }
        // Fire the shortcode init action
        do_action('vcff_challenge_pages_init',$this);
    }
    
    protected function _Load_AJAX() {
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Load each of the field shortcodes
        foreach (new DirectoryIterator($dir.'/ajax') as $FileInfo) { 
            // If this is a directory dot
            if($FileInfo->isDot()) { continue; }
            // If this is a directory
            if($FileInfo->isDir()) { continue; }
            // If this is not false
            if (stripos($FileInfo->getFilename(),'.tpl') !== false) { continue; } 
            // Include the file
            require_once($FileInfo->getPathname());
        }
        // Fire the shortcode init action
        do_action('vcff_challenge_ajax_init',$this);
    }
    
}

add_action('vcff_init',function(){

    $vcff_challenge = new VCFF_Challenge(); 

    vcff_register_library('vcff_challenge',$vcff_challenge);

    $vcff_challenge->Init();
});

