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
        wp_enqueue_script('quiz', $des_js, array('jquery'), '', true);
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
        <p><?php echo "[CustomQuiz id=".$output_id."]"; ?></p>
<?php 
    }

    function quiz_questions_metabox_display() {
        global $post; 
        $first_question = get_post_meta($post->ID, 'question_one', true);
        $second_question = get_post_meta($post->ID, 'question_two', true);
        $third_question = get_post_meta($post->ID, 'question_three', true);
        
?>
    <label>Question 1</label>
    <input type="text" name="question_one" placeholder="First Question" class="input_field" value="<?php print $first_question; ?>">
    <label>Question 2</label>
    <input type="text" name="question_two" placeholder="Second Question" class="input_field" value="<?php print $second_question ?>">
    <label>Question 3</label>
    <input type="text" name="question_three" placeholder="Third Question" class="input_field" value="<?php print $third_question ?>">
<?php
    }

    function quiz_answers_metabox_display() {
        global $post; 
        $answer_one_question_one = get_post_meta($post->ID, 'answer_one_one', true);
        $answer_two_question_one = get_post_meta($post->ID, 'answer_two_one', true);
        $answer_one_question_two = get_post_meta($post->ID, 'answer_one_two', true);
        $answer_two_question_two = get_post_meta($post->ID, 'answer_two_two', true);
        $answer_one_question_three = get_post_meta($post->ID, 'answer_one_three', true);
        $answer_two_question_three = get_post_meta($post->ID, 'answer_two_three', true);
?>
    <h3>Answers to Question 1</h3>
    <div class="answer-block">
        <label>Choice 1</label>
        <input type="text" name="answer_one_one" placeholder="Choice 1 of Question 1" class="input_field" value="<?php print $answer_one_question_one; ?>">
    </div>
    <div class="answer-block">
        <label>Choice 2</label>
        <input type="text" name="answer_two_one" placeholder="Choice 2 of Question 1" class="input_field" value="<?php print $answer_two_question_one; ?>">
    </div>
    <h3>Answers to Question 2</h3>
    <div class="answer-block">
        <label>Choice 1</label>
        <input type="text" name="answer_one_two" placeholder="Choice 1 of Question 2" class="input_field" value="<?php print $answer_one_question_two; ?>">
    </div>
    <div class="answer-block">
        <label>Choice 2</label>
        <input type="text" name="answer_two_two" placeholder="Choice 2 of Question 2" class="input_field" value="<?php print $answer_two_question_two; ?>">
    </div>
    <h3>Answers to Question 3</h3>
    <div class="answer-block">
        <label>Choice 1</label>
        <input type="text" name="answer_one_three" placeholder="Choice 1 of Question 3" class="input_field" value="<?php print $answer_one_question_three; ?>">
    </div>
    <div class="answer-block">
        <label>Choice 2</label>
        <input type="text" name="answer_two_three" placeholder="Choice 2 of Question 3" class="input_field" value="<?php print $answer_two_question_three; ?>">
    </div>
<?php 
    }

    function quiz_results_metabox_display() {
        global $post; 
        $result_one = get_post_meta($post->ID, 'result_one', true);
        $result_two = get_post_meta($post->ID, 'result_two', true);
?>  
    <p style="margin-bottom: 30px;">Each answer 1 = point 0, each answer 2 = point 1, a total score of 2 and above leads to result 1, and a total score of 1 and below leads to result 2.</p>
    <div class="answer-block">
        <label>Result 1</label>
        <input type="text" name="result_one" placeholder="First Result" class="input_field" value="<?php print $result_one; ?>">
    </div>
    <div class="answer-block">
        <label>Result 2</label>
        <input type="text" name="result_two" placeholder="Second Result" class="input_field" value="<?php print $result_two; ?>">
    </div>
<?php 
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
            if(array_key_exists('answer_one_one', $_POST)) {
                update_post_meta($post_id, 'answer_one_one', $_POST['answer_one_one']);
            }
            if(array_key_exists('answer_two_one', $_POST)) {
                update_post_meta($post_id, 'answer_two_one', $_POST['answer_two_one']);
            }
            if(array_key_exists('answer_one_two', $_POST)) {
                update_post_meta($post_id, 'answer_one_two', $_POST['answer_one_two']);
            }
            if(array_key_exists('answer_two_two', $_POST)) {
                update_post_meta($post_id, 'answer_two_two', $_POST['answer_two_two']);
            }
            if(array_key_exists('answer_one_three', $_POST)) {
                update_post_meta($post_id, 'answer_one_three', $_POST['answer_one_three']);
            }
            if(array_key_exists('answer_two_three', $_POST)) {
                update_post_meta($post_id, 'answer_two_three', $_POST['answer_two_three']);
            }
            if(array_key_exists('result_one', $_POST)) {
                update_post_meta($post_id, 'result_one', $_POST['result_one']);
            }
            if(array_key_exists('result_two', $_POST)) {
                update_post_meta($post_id, 'result_two', $_POST['result_two']);
            }
        }
    }
    add_action('save_post', 'quiz_metabox_save');

    function add_quiz_columns($columns) {
        unset($columns['date']);
        return array_merge($columns, [
            'shortcode' => __('Shortcode'),
            'date' => __('Date')
        ]);
    }   
    add_filter('manage_quiz_posts_columns', 'add_quiz_columns');

    function display_admin_shortcode($column, $post_id) {
        switch($column) {
            case 'shortcode': 
                echo "[CustomQuiz id=".$post_id."]";
                break;
        }
    }
    add_action('manage_quiz_posts_custom_column', 'display_admin_shortcode', 10, 2);

    function output_custom_quiz($atts) { 
        $atts = shortcode_atts([
            'id' => 1
        ], $atts);
        $output_id = $atts['id']; 
        $post = get_post($output_id);
        $quiz_heading = $post->post_title; 
        $question_one = get_post_meta($output_id, 'question_one', true);
        $question_two = get_post_meta($output_id, 'question_two', true);
        $question_three = get_post_meta($output_id, 'question_three', true);
?>
    <div id="quiz-body">
        <div id="quiz-wrapper">
            <div id="quiz-title">
                <h1><?php print $quiz_heading ?></h1>
            </div>
            <div id="quiz-result">
                <p class="flex-center">Here are what you've selected.</p>
                <div id="selected-answers"></div>
                <h1>Ready to see the result?</h1>
                <a href="#" id="submit">Submit</a>
                <a href="#" id="back">Not ready to submit. Do it again.</a>
            </div>
            <div id="quiz-end" class="flex-center">
                <div>
                    <p>Did you guess it right?</p>
                    <h1>Team <span id="result-display"></span>!</h1>
                    <div id="recommend">
                        <h4>Check out our best <span id="recommend-display"></span> dishes here:</h4>
                        <div id="dishes">
                            <img src="http://localhost/wptheme/wp-content/uploads/2019/06/image2.jpg">
                            <img src="http://localhost/wptheme/wp-content/uploads/2019/06/image2.jpg">
                            <img src="http://localhost/wptheme/wp-content/uploads/2019/06/image2.jpg">
                            <img src="http://localhost/wptheme/wp-content/uploads/2019/06/image2.jpg">
                        </div>
                    </div>
                </div>
            </div>
            <div id="quiz-questions" class="flex-center">
            
                <div class="quiz-question-answers">
                    <h2 class="quiz-question"><?php print $question_one; ?></h2>
                    <div class="quiz-question-answer">
                        <img src="http://localhost/wptheme/wp-content/uploads/2019/06/image2.jpg" class="answer" data-value="" data-name="">
                        <p class="answer"></p>
                    </div>
                    <div class="quiz-question-answer">
                        <img src="http://localhost/wptheme/wp-content/uploads/2019/06/image2.jpg" class="answer" data-value="" data-name="">
                        <p class="answer"></p>
                    </div>
                </div>
            
            </div>
            <div id="quiz-control" class="flex-center">
                <a href="#" id="next">Next</a> 
            </div>


        </div>
    </div>
<?php        
    }
    add_shortcode('CustomQuiz', 'output_custom_quiz');
?>