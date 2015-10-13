<?php

vcff_map_field(array(
    'type' => 'ch_single_choice',
    'title' => 'CH - Single Choice',
    'class' => 'CH_Fields_Single_Choice_Item',
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
            array (
                "type" => "vcff_heading",
                "heading" => false,
                "param_name" => "question_heading",
                'group' => __('Question',VCFF_FORM),
                'html_title' => 'Question Settings',
                'html_description' => 'You can set this field to accept dynamic values from either POST, GET or REQUEST variables. This is useful if you have forms posting to each other or if you want to refill form fields via a URL link.',
            ),
            array (
                "type" => "textarea_html",
                //"heading" => __ ( "What would you like the question to ask?", VCFF_FORM ),
                'group' => __('Question',VCFF_FORM),
                "param_name" => "content",
            ),
            array (
                "type" => "textarea_raw_html",
                "heading" => __ ("Question answers", VCFF_FORM ),
                'group' => __('Question',VCFF_FORM),
                "param_name" => "ch_options",
                'description' => __('Enter an answer on a new line. Prefix each answer with a box containing the line reference. For example; [1] This is answer one')
            ),
            array (
                "type" => "textfield",
                "heading" => __ ("Correct Answers", VCFF_FORM ),
                "param_name" => "ch_answers",
                'group' => __('Question',VCFF_FORM),
                'description' => __('Enter the answer number. For multiple possible correct answers, seperate each number by a comma. For example; 2,4,5')
            ),
            array(
                "type" => "checkbox",
                "param_name" => "ch_randomise",
                'group' => __('Question',VCFF_FORM),
                'value' => array(
                    'Randomise Answers' => 'yes'
                )
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
            array (
                "type" => "vcff_heading",
                "heading" => false,
                "param_name" => "ch_options_heading",
                'group' => __('Question',VCFF_FORM),
                'html_title' => 'Question Marking',
                'html_description' => 'You can set this field to accept dynamic values from either POST, GET or REQUEST variables. This is useful if you have forms posting to each other or if you want to refill form fields via a URL link.',
            ),
            array(
                "type" => "checkbox",
                "param_name" => "ch_automark",
                'value' => array(
                    'Automatically mark this question' => 'yes'
                ),
                'group' => __('Question',VCFF_FORM),
            ),
            array (
                "type" => "vcff_heading",
                "heading" => false,
                "param_name" => "ch_message_heading",
                'group' => __('Question',VCFF_FORM),
                'html_title' => 'Marking Messages',
                'html_description' => 'You can set this field to accept dynamic values from either POST, GET or REQUEST variables. This is useful if you have forms posting to each other or if you want to refill form fields via a URL link.',
            ),
            array (
                "type" => "textarea_raw_html",
                "heading" => __ ( "Show the following message for a correct answer", VCFF_FORM ),
                'group' => __('Question',VCFF_FORM),
                "param_name" => "ch_correct_msg",
            ),
            array (
                "type" => "textarea_raw_html",
                "heading" => __ ( "Show the following message for an incorrect answer", VCFF_FORM ),
                'group' => __('Question',VCFF_FORM),
                "param_name" => "ch_incorrect_msg",
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('CSS',VCFF_FORM),
                'param_name' => 'css',
                'group' => __('Design Options',VCFF_FORM),
            ),
        )
    )
));
