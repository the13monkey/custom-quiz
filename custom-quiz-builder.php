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
        $des_css = plugins_url('css/style.css', __FILE__);
        $des_js = plugins_url('js/quiz.js', __FILE__);
        wp_enqueue_style( 'style', $des_css, false, '','all');
        wp_enqueue_script('quiz', $des_js, array('jquery'), 1.1, true);
    }
    add_action('init', 'add_scripts');

    function quiz_questions() {
       add_meta_box('quiz_id', 'Shourtcode', 'quiz_id_metabox_display', 'quiz', 'side', 'low');

       add_meta_box('quiz_questions_customfields', '<h3>Custom Quiz Questions</h3>', 'quiz_questions_metabox_display', 'quiz', 'normal', 'high');
       add_meta_box('quiz_answers_customfields', '<h3>Custom Quiz Answers</h3>', 'quiz_answers_metabox_display', 'quiz', 'normal', 'high');
       add_meta_box('quiz_results_customfields', '<h3>Custom Quiz Results</h3>', 'quiz_results_metabox_display', 'quiz', 'normal', 'high');
    }
    add_action('add_meta_boxes', 'quiz_questions');

    function quiz_id_metabox_display() {
        global $post; 
        $output_id = $post->ID;
        $output_title = $post->post_title;
?>
        <p><?php echo "[custom_quiz_".$output_id."]"; ?></p>
<?php 
    }

    function quiz_questions_metabox_display() {
        global $post; 
        $first_question = get_post_meta($post->ID, 'question_one', true);
        $second_question = get_post_meta($post->ID, 'question_two', true);
        $third_question = get_post_meta($post->ID, 'question_three', true);
        
?>
    <label>Question One</label>
    <input type="text" name="question_one" placeholder="First Question" class="input_field" value="<?php print $first_question; ?>">
    <label>Question Two</label>
    <input type="text" name="question_two" placeholder="Second Question" class="input_field" value="<?php print $second_question ?>">
    <label>Question Three</label>
    <input type="text" name="question_three" placeholder="Third Question" class="input_field" value="<?php print $third_question ?>">
<?php
    }

    function quiz_answers_metabox_display() {
?>
    <label>Answers to Question One</label>
<?php 
    }

    function quiz_results_metabox_display() {
        echo "this is where the results are.";
    }

    function quiz_metabox_save($post_id) {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        
        if($is_autosave || $is_revision) {
            return; 
        }

        $post = get_post($post_id); 

        if($post->post_type == "quiz") {
           
            if(array_key_exists('question_one', $_POST)) {
                update_post_meta($post_id, 'question_one', $_POST['question_one']);
            }
            if(array_key_exists('question_two', $_POST)) {
                update_post_meta($post_id, 'question_two', $_POST['question_two']);
            }
            if(array_key_exists('question_three', $_POST)) {
                update_post_meta($post_id, 'question_three', $_POST['question_three']);
            }
        }
    }
    add_action('save_post', 'quiz_metabox_save');


    function output_custom_quiz($output_id) { 
        $output_id = 250; 
        $post = get_post($output_id);
        $quiz_heading = $post->post_title;
?>
    <div id="quiz-body">
        <div id="quiz-wrapper">
            <div id="quiz-title">
                <h1><?php print $quiz_heading ?></h1>
            </div>
        </div>
    </div>
<?php
        
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
    add_shortcode('custom_quiz_250', 'output_custom_quiz');
?>