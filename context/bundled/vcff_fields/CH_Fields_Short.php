<?php

vcff_map_field(array(
    'type' => 'ch_short_answer',
    'title' => 'CH - Short Answer',
    'class' => 'CH_Fields_Short_Item',
    'filter_logic' => array(),
    'conditional_logic' => array(),
    'validation_logic' => array(),
    'vc_map' => array(
        'params' => array(
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
                "param_name" => "ch_heading_3",
                'group' => __('Question',VCFF_FORM),
                'html_title' => 'Question Points',
                'html_description' => 'You can set this field to accept dynamic values from either POST, GET or REQUEST variables. This is useful if you have forms posting to each other or if you want to refill form fields via a URL link.',
            ),
            array (
                "type" => "textfield",
                "heading" => __ ( "Point Value", VCFF_FORM ),
                "param_name" => "ch_point_value",
                'group' => __('Question',VCFF_FORM),
            ),
            // VC CSS EDITOR
            array(
                'type' => 'css_editor',
                'heading' => __('CSS',VCFF_FORM),
                'param_name' => 'css',
                'group' => __('Design Options',VCFF_FORM),
            ),
        )
    )
));
