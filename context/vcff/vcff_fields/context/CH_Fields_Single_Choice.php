<?php

class CH_Fields_Single_Choice extends CH_Question_Item {
    
    static $field_type = 'ch_single_choice';
    
    static $field_title = 'CH - Single Choice';

    static $item_class = 'CH_Fields_Single_Choice_Item';

    static $is_context = true;

    static function Field_Settings() {
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
    
    static function VC_Params() {
        // Return any visual composer params
        return array(
            'params' => array(
                // CORE FIELD SETTINGS
                array (
                    "type" => "vcff_heading",
                    "heading" => false,
                    "param_name" => "field_heading",
                    'html_title' => 'VCFF Fields',
                    'html_description' => 'You can set this field to accept dynamic values from either POST, GET or REQUEST variables. This is useful if you have forms posting to each other or if you want to refill form fields via a URL link.',
                    'help_url' => 'http://blah',
                ),
                array (
                    "type" => "vcff_machine",
                    "heading" => __ ( "Machine Code", VCFF_FORM ),
                    "param_name" => "machine_code",
                ),  
                // CORE FIELD SETTINGS
                array (
                    "type" => "vcff_heading",
                    "heading" => false,
                    "param_name" => "label_heading",
                    'html_title' => 'Field Labels',
                    'html_description' => 'You can set this field to accept dynamic values from either POST, GET or REQUEST variables. This is useful if you have forms posting to each other or if you want to refill form fields via a URL link.',
                ),
                array (
                    "type" => "textfield",
                    "heading" => __ ( "Label (Data Entry)", VCFF_FORM ),
                    "param_name" => "field_label",
                    'value' => __('Enter a field label..'),
                    'admin_label' => true,
                ),
                array (
                    "type" => "textfield",
                    "heading" => __ ( "Label (Data Viewing)", VCFF_FORM ),
                    "param_name" => "view_label",
                ),
                // CORE FIELD SETTINGS
                array (
                    "type" => "vcff_heading",
                    "heading" => false,
                    "param_name" => "question_heading",
                    'group' => __('Question',VCFF_FORM),
                    'html_title' => 'Question Setup',
                    'html_description' => 'You can set this field to accept dynamic values from either POST, GET or REQUEST variables. This is useful if you have forms posting to each other or if you want to refill form fields via a URL link.',
                ),
                array (
                    "type" => "textarea_html",
                    //"heading" => __ ( "What would you like the question to ask?", VCFF_FORM ),
                    'group' => __('Question',VCFF_FORM),
                    "param_name" => "content",
                ),
                array (
                    "type" => "vcff_heading",
                    "heading" => false,
                    "param_name" => "ch_options_heading",
                    'group' => __('Question',VCFF_FORM),
                    'html_title' => 'Question Options',
                    'html_description' => 'You can set this field to accept dynamic values from either POST, GET or REQUEST variables. This is useful if you have forms posting to each other or if you want to refill form fields via a URL link.',
                ),
                array (
                    "type" => "textarea_raw_html",
                    //"heading" => __ ("Options", VCFF_FORM ),
                    'group' => __('Question',VCFF_FORM),
                    "param_name" => "ch_options",
                ),
                array (
                    "type" => "textfield",
                    "heading" => __ ("Answers", VCFF_FORM ),
                    "param_name" => "ch_answers",
                    'group' => __('Question',VCFF_FORM),
                ),
                array(
                    "type" => "checkbox",
                    "param_name" => "ch_automark",
                    'value' => array(
                        'Automatically mark this question' => 'yes'
                    )
                ),
                array(
                    "type" => "checkbox",
                    "param_name" => "ch_randomise",
                    'value' => array(
                        'Randomise Answers' => 'yes'
                    )
                ),
                array (
                    "type" => "textfield",
                    "heading" => __ ( "Point Value", VCFF_FORM ),
                    "param_name" => "ch_point_value",
                    'group' => __('Question',VCFF_FORM),
                ),
                array (
                    "type" => "vcff_heading",
                    "heading" => false,
                    "param_name" => "ch_message_heading",
                    'group' => __('Question',VCFF_FORM),
                    'html_title' => 'Question Messages',
                    'html_description' => 'You can set this field to accept dynamic values from either POST, GET or REQUEST variables. This is useful if you have forms posting to each other or if you want to refill form fields via a URL link.',
                ),
                array (
                    "type" => "textarea_raw_html",
                    "heading" => __ ( "Correct Message", VCFF_FORM ),
                    'group' => __('Question',VCFF_FORM),
                    "param_name" => "ch_correct_msg",
                ),
                array (
                    "type" => "textarea_raw_html",
                    "heading" => __ ( "Incorrect Message", VCFF_FORM ),
                    'group' => __('Question',VCFF_FORM),
                    "param_name" => "ch_incorrect_msg",
                ),
                
                // VC CSS EDITOR
                array(
                    'type' => 'css_editor',
                    'heading' => __('CSS',VCFF_FORM),
                    'param_name' => 'css',
                    'group' => __('Design Options',VCFF_FORM),
                ),
            )
        );
    }
    
    static function Field_Params() {
        // Return any field params
        return array();
    }
}

vcff_map_field('CH_Fields_Single_Choice');