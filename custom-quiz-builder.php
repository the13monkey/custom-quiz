<?php 
    /**
     * Plugin Name: Custom Quiz Builder
     * Description: This small plugin enables users to build Buzzfeed style quizzes, including three questions, of each comes with      two answers, that leads to two final results. 
     * Version: 1.0.0
     * Author: Dinah Chen 
     * Author URI: http://dinahchen.com
     */

    defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

    function custom_quiz_builder() {
        register_post_type('Quiz',
            array(
                'labels' => array(
                    'name' => __('Custom Quizzes'),
                    'singular_name' => __('Custom Quiz'),
                    'add_new' => __('Add New'),
                    'add_new_item' => __('Add New Quiz'),
                    'edit_item' => __('Edit Quiz'),
                    'search_items' => __('Search Quizzes')
                ),
                'menu_position' => 5,
                'public' => true,
                'exclud_from_search' => true,
                'has_archive' => false, 
                'register_meta_box_cb' => 'quiz_questions',
                'supports' => array('title','editor','thumbnail'),
                'menu_icon' => 'dashicons-format-status'
            )
        );
    }
    add_action('init', 'custom_quiz_builder');

    function add_scripts() {
        $des = plugins_url('css/style.css', __FILE__);
        wp_enqueue_style( 'style', $des, false, '','all');
    }

    add_action('init', 'add_scripts');

    function quiz_questions() {
       add_meta_box('quiz_questions_customfields', '<h3>Custom Quiz Questions</h3>', 'quiz_questions_metabox_display', 'quiz', 'normal', 'high');
       add_meta_box('quiz_answers_customfields', '<h3>Custom Quiz Answers</h3>', 'quiz_answers_metabox_display', 'quiz', 'normal', 'high');
       add_meta_box('quiz_results_customfields', '<h3>Custom Quiz Results</h3>', 'quiz_results_metabox_display', 'quiz', 'normal', 'high');
       
    }

    add_action('add_meta_boxes', 'quiz_questions');

    function quiz_questions_metabox_display() {
        echo "this is where the questions are.";
    }

    function quiz_answers_metabox_display() {
        echo "this is where the answers are.";
    }

    function quiz_results_metabox_display() {
        echo "this is where the results are.";
    }


    function output_custom_quiz() { 
        $content = '';
        $content .= '<div id="quiz-body">
                        <div id="quiz-wrapper">
                            <h1>This is where the quiz goes.</h1>
                        </div>
                    </div>';

        return $content; 
        /*
        $args = array (
            'posts_per_page' => -1,
            'post_type' => 'quiz'
        );
        $customQuizs = get_posts($args);

        $content = '';

        foreach($customQuizs as $key=>$val) 
        {
            $content .= '<h1 style="text-align:left">'.$val->post_type.'</h1>';
        }

        return $content;
        */
        
    }
    add_shortcode('custom_quiz', 'output_custom_quiz');
?>