<?php 
    /**
     * Plugin Name: Custom Quiz Builder
     * Description: This small plugin enables users to build Buzzfeed style quizzes, including three questions, of each comes with      two answers, that leads to two final results. 
     * Version: 1.0.0
     * Author: Dinah Chen 
     * Author URI: http://dinahchen.com
     */

    defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

    add_action('init', 'wp_enqueue_media');

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
        $admin_js = plugins_url('js/admin.js', __FILE__);
        wp_enqueue_style( 'style', $des_css, false, '','all');
        wp_enqueue_script('quiz', $des_js, array('jquery'), '1.0.0', true);
        wp_enqueue_script('admin', $admin_js, array('jquery'), '1.0.0', true);
        wp_localize_script('quiz', 'baseUrl', ['pluginUrl' => plugins_url()]);
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

        //Script to upload the images 
    //    wp_nonce_field(basename(__FILE__), 'img_q1_a1_nonce');  
        $save_image_q1_a1 = get_post_meta($post->ID, 'image_answer1_question1', true);
        $upload_image_q1_a1_array = [
            'id' => $save_image_q1_a1["id"],
            'src' => $save_image_q1_a1["url"]
        ];
        wp_localize_script('admin', 'upload_image_q1_a1', $upload_image_q1_a1_array);
        
        $save_image_q1_a2 = get_post_meta($post->ID, 'image_answer2_question1', true);
        $upload_image_q1_a2_array = [
            'id' => $save_image_q1_a2['id'],
            'src' => $save_image_q1_a2['url']
        ];
        wp_localize_script('admin', 'upload_image_q1_a2', $upload_image_q1_a2_array);

        $save_image_q2_a1 = get_post_meta($post->ID, 'image_answer1_question2', true);
        $upload_image_q2_a1_array = [
            'id' => $save_image_q2_a1['id'],
            'src' => $save_image_q2_a1['url']
        ];
        wp_localize_script('admin', 'upload_image_q2_a1', $upload_image_q2_a1_array);

        $save_image_q2_a2 = get_post_meta($post->ID, 'image_answer2_question2', true);
        $upload_image_q2_a2_array = [
            'id' => $save_image_q2_a2['id'],
            'src' => $save_image_q2_a2['url']
        ];
        wp_localize_script('admin', 'upload_image_q2_a2', $upload_image_q2_a2_array);

        $save_image_q3_a1 = get_post_meta($post->ID, 'image_answer1_question3', true);
        $upload_image_q3_a1_array = [
            'id' => $save_image_q3_a1['id'],
            'src' => $save_image_q3_a1['url']
        ];
        wp_localize_script('admin', 'upload_image_q3_a1', $upload_image_q3_a1_array);

        $save_image_q3_a2 = get_post_meta($post->ID, 'image_answer2_question3', true);
        $upload_image_q3_a2_array = [
            'id' => $save_image_q3_a2['id'],
            'src' => $save_image_q3_a2['url']
        ];
        wp_localize_script('admin', 'upload_image_q3_a2', $upload_image_q3_a2_array);

        if(metadata_exists('post', $post->ID, 'is_update_q1_a1')) {
            $is_update_q1_a1 == get_post_meta($post->ID, 'is_update_q1_a1', true);
        } else {
            $is_update_q1_a1 = "true";
        }

        if(metadata_exists('post', $post->ID, 'is_update_q1_a2')) {
            $is_update_q1_a2 == get_post_meta($post->ID, 'is_update_q1_a2', true);
        } else {
            $is_update_q1_a2 = "true";
        }

        if(metadata_exists('post', $post->ID, 'is_update_q2_a1')) {
            $is_update_q2_a1 == get_post_meta($post->ID, 'is_update_q2_a1', true);
        } else {
            $is_update_q2_a1 = "true";
        }

        if(metadata_exists('post', $post->ID, 'is_update_q2_a2')) {
            $is_update_q2_a2 == get_post_meta($post->ID, 'is_update_q2_a2', true);
        } else {
            $is_update_q2_a2 = "true";
        }

        if(metadata_exists('post', $post->ID, 'is_update_q3_a1')) {
            $is_update_q3_a1 == get_post_meta($post->ID, 'is_update_q3_a1', true);
        } else {
            $is_update_q3_a1 = "true";
        }

        if(metadata_exists('post', $post->ID, 'is_update_q3_a2')) {
            $is_update_q3_a2 == get_post_meta($post->ID, 'is_update_q3_a2', true);
        } else {
            $is_update_q3_a2 = "true";
        }
     
?>
    <h3>Answers to Question 1</h3>    
    <div class="answer-block">
        <label>Choice 1</label>
        <input type="text" name="answer_one_one" placeholder="Choice 1 of Question 1" class="input_field" value="<?php print $answer_one_question_one; ?>">
        <input type="hidden" id="is_update_q1_a1" name="is_update_q1_a1" value="<?php print $is_update_q1_a1 ?>">
        <div class="image-wrapper">
            <div>
                <img class="image-tag" id="img-tag-q1-a1" >
            </div>
            <input type="hidden" id="hidden-btn-q1-a1" name="image_data_q1_a1">
            <input type="submit" id="image-upload-q1-a1" class="button" value="Add Image" name="image-upload-q1-a1">
            <input type="button" id="image-delete-q1-a1" class="button" value="Remove Image">
        </div>
    </div>
    <div class="answer-block">
        <label>Choice 2</label>
        <input type="text" name="answer_two_one" placeholder="Choice 2 of Question 1" class="input_field" value="<?php print $answer_two_question_one; ?>">
        <input type="hidden" id="is_update_q1_a2" name="is_update_q1_a2" value="<?php print $is_update_q1_a2 ?>">
        <div class="image-wrapper">
            <div>
                <img class="image-tag" id="img-tag-q1-a2" >
            </div>
            <input type="hidden" id="hidden-btn-q1-a2" name="image_data_q1_a2">
            <input type="submit" id="image-upload-q1-a2" class="button" value="Add Image" name="image-upload-q1-a2">
            <input type="button" id="image-delete-q1-a2" class="button" value="Remove Image">
        </div>
    </div>
    <h3>Answers to Question 2</h3>
    <div class="answer-block">
        <label>Choice 1</label>
        <input type="text" name="answer_one_two" placeholder="Choice 1 of Question 2" class="input_field" value="<?php print $answer_one_question_two; ?>">
        <input type="hidden" id="is_update_q2_a1" name="is_update_q2_a1" value="<?php print $is_update_q2_a1 ?>">
        <div class="image-wrapper">
            <div>
                <img class="image-tag" id="img-tag-q2-a1" >
            </div>
            <input type="hidden" id="hidden-btn-q2-a1" name="image_data_q2_a1">
            <input type="button" id="image-upload-q2-a1" class="button" value="Add Image">
            <input type="button" id="image-delete-q2-a1" class="button" value="Remove Image">
        </div>
    </div>
    <div class="answer-block">
        <label>Choice 2</label>
        <input type="text" name="answer_two_two" placeholder="Choice 2 of Question 2" class="input_field" value="<?php print $answer_two_question_two; ?>">
        <input type="hidden" id="is_update_q2_a2" name="is_update_q2_a2" value="<?php print $is_update_q2_a2 ?>">
        <div class="image-wrapper">
            <div>
                <img class="image-tag" id="img-tag-q2-a2">
            </div>
            <input type="hidden" id="hidden-btn-q2-a2" name="image_data_q2_a2">
            <input type="button" id="image-upload-q2-a2" class="button" value="Add Image">
            <input type="button" id="image-delete-q2-a2" class="button" value="Remove Image">
        </div>
    </div>
    <h3>Answers to Question 3</h3>
    <div class="answer-block">
        <label>Choice 1</label>
        <input type="text" name="answer_one_three" placeholder="Choice 1 of Question 3" class="input_field" value="<?php print $answer_one_question_three; ?>">
        <input type="hidden" id="is_update_q3_a1" name="is_update_q3_a1" value="<?php print $is_update_q3_a1 ?>">
        <div class="image-wrapper">
            <div>
                <img class="image-tag" id="img-tag-q3-a1">
            </div>
            <input type="hidden" id="hidden-btn-q3-a1" name="image_data_q3_a1">
            <input type="button" id="image-upload-q3-a1" class="button" value="Add Image">
            <input type="button" id="image-delete-q3-a1" class="button" value="Remove Image">
        </div>
    </div>
    <div class="answer-block">
        <label>Choice 2</label>
        <input type="text" name="answer_two_three" placeholder="Choice 2 of Question 3" class="input_field" value="<?php print $answer_two_question_three; ?>">
        <input type="hidden" id="is_update_q3_a2" name="is_update_q3_a2" value="<?php print $is_update_q3_a2 ?>">
        <div class="image-wrapper">
            <div>
                <img class="image-tag" id="img-tag-q3-a2">
            </div>
            <input type="hidden" id="hidden-btn-q3-a2" name="image_data_q3_a2">
            <input type="button" id="image-upload-q3-a2" class="button" value="Add Image">
            <input type="button" id="image-delete-q3-a2" class="button" value="Remove Image">
        </div>
    </div>
<?php 
    }

    function quiz_results_metabox_display() {
        global $post; 
        $result_one = get_post_meta($post->ID, 'result_one', true);
        $result_two = get_post_meta($post->ID, 'result_two', true);
?>  
    <p style="margin-bottom: 30px;">
        Answer 1 = 0 | Answer 2 = 1<br>
        Total >= 2 : Result 1 | Total < 2 : Result 2<br>        
    </p>
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
    //    $is_valid_nonce = (isset($_POST['img_q1_a1_nonce']) && wp_verify_nonce($_POST['img_q1_a1_nonce']));
        
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

            if(isset($_POST['image_data_q1_a1'])) {
                 
                if ($_POST['is_update_q1_a1'] == "true") {
                    
                } else {
                    $imageData_q1a1 = json_decode(stripslashes($_POST['image_data_q1_a1']));
                if (is_object($imageData_q1a1[0])) {
                    $new_imageData_q1a1 = [
                        'id' => $imageData_q1a1[0] -> id,
                        'url' => $imageData_q1a1[0] -> url
                    ];
                } else {
                    $new_imageData_q1a1 = get_post_meta($post_id, 'image_answer1_question1', true);
                }
                update_post_meta($post_id, 'image_answer1_question1', $new_imageData_q1a1); 
                }
               
            }

            if(isset($_POST['image_data_q1_a2'])) {
                
                if($_POST['is_update_q1_a2'] == "true") {
                   
                } else {
                    $imageData_q1a2 = json_decode(stripslashes($_POST['image_data_q1_a2']));
                if (is_object($imageData_q1a2[0])) {
                    $new_imageData_q1a2 = [
                        'id' => $imageData_q1a2[0] -> id,
                        'url' => $imageData_q1a2[0] -> url
                    ];
                } else {
                    $new_imageData_q1a2 = get_post_meta($post_id, 'image_answer2_question1', true);
                }
                update_post_meta($post_id, 'image_answer2_question1', $new_imageData_q1a2);  
                }
            }
            

            if(isset($_POST['image_data_q2_a1'])) {

                if ($_POST['is_update_q2_a1'] == "true") {

                } else {
                    $imageData_q2a1 = json_decode(stripslashes($_POST['image_data_q2_a1']));
                    if (is_object($imageData_q2a1[0])) {
                        $new_imageData_q2a1 = [
                            'id' => $imageData_q2a1[0] -> id,
                            'url' => $imageData_q2a1[0] -> url
                        ];
                    } else {
                        $new_imageData_q2a1 = [];
                    }
                    update_post_meta($post_id, 'image_answer1_question2', $new_imageData_q2a1);  
                }

                
            }

            if(isset($_POST['image_data_q2_a2'])) {

                if ($_POST['is_update_q2_a2'] == "true") {

                } else {
                    $imageData_q2a2 = json_decode(stripslashes($_POST['image_data_q2_a2']));
                    if (is_object($imageData_q2a2[0])) {
                        $new_imageData_q2a2 = [
                            'id' => $imageData_q2a2[0] -> id,
                            'url' => $imageData_q2a2[0] -> url
                        ];
                    } else {
                        $new_imageData_q2a2 = [];
                    }
                    update_post_meta($post_id, 'image_answer2_question2', $new_imageData_q2a2);  
                }   

            }

            if(isset($_POST['image_data_q3_a1'])) {

                if ($_POST['is_update_q3_a1'] == "true") {

                } else {
                    $imageData_q3a1 = json_decode(stripslashes($_POST['image_data_q3_a1']));
                    if (is_object($imageData_q3a1[0])) {
                        $new_imageData_q3a1 = [
                            'id' => $imageData_q3a1[0] -> id,
                            'url' => $imageData_q3a1[0] -> url
                        ];
                    } else {
                        $new_imageData_q3a1 = [];
                    }
                    update_post_meta($post_id, 'image_answer1_question3', $new_imageData_q3a1);  
                }

            }

            if(isset($_POST['image_data_q3_a2'])) {

                if ($_POST['is_update_q3_a2'] == "true") {

                } else {
                    $imageData_q3a2 = json_decode(stripslashes($_POST['image_data_q3_a2']));
                    if (is_object($imageData_q3a2[0])) {
                        $new_imageData_q3a2 = [
                            'id' => $imageData_q3a2[0] -> id,
                            'url' => $imageData_q3a2[0] -> url
                        ];
                    } else {
                        $new_imageData_q3a2 = [];
                    }
                    update_post_meta($post_id, 'image_answer2_question3', $new_imageData_q3a2);  
                }

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

        $answer_q1_a1 = get_post_meta($output_id, 'answer_one_one', true);
        $answer_q1_a2 = get_post_meta($output_id, 'answer_two_one', true);
        $answer_q2_a1 = get_post_meta($output_id, 'answer_one_two', true);
        $answer_q2_a2 = get_post_meta($output_id, 'answer_two_two', true);
        $answer_q3_a1 = get_post_meta($output_id, 'answer_one_three', true);
        $answer_q3_a2 = get_post_meta($output_id, 'answer_two_three', true);
        
        $image_array_q1_a1 = get_post_meta($output_id, 'image_answer1_question1', true);
        $image_url_q1_a1 = $image_array_q1_a1["url"]; 
        $image_array_q1_a2 = get_post_meta($output_id, 'image_answer2_question1', true);
        $image_url_q1_a2 = $image_array_q1_a2["url"];

        $image_array_q2_a1 = get_post_meta($output_id, 'image_answer1_question2', true);
        $image_url_q2_a1 = $image_array_q2_a1["url"];
        $image_array_q2_a2 = get_post_meta($output_id, 'image_answer2_question2', true);
        $image_url_q2_a2 = $image_array_q2_a2["url"];

        $image_array_q3_a1 = get_post_meta($output_id, 'image_answer1_question3', true);
        $image_url_q3_a1 = $image_array_q3_a1["url"];
        $image_array_q3_a2 = get_post_meta($output_id, 'image_answer2_question3', true);
        $image_url_q3_a2 = $image_array_q3_a2["url"];

        $questions = [
            [
                "question" => $question_one,
                "answer1_image" => $image_url_q1_a1,
                "answer1" =>  $answer_q1_a1,
                "answer1_value" => 1,
                "answer2_image" => $image_url_q1_a2, 
                "answer2" => $answer_q1_a2,
                "answer2_value" => 0
            ],
            [
                "question" => $question_two,
                "answer1_image" => $image_url_q2_a1,
                "answer1" =>  $answer_q2_a1,
                "answer1_value" => 1,
                "answer2_image" => $image_url_q2_a2, 
                "answer2" => $answer_q2_a2,
                "answer2_value" => 0
            ],
            [
                "question" => $question_three,
                "answer1_image" => $image_url_q3_a1,
                "answer1" =>  $answer_q3_a1,
                "answer1_value" => 1,
                "answer2_image" => $image_url_q3_a2, 
                "answer2" => $answer_q3_a2,
                "answer2_value" => 0
            ]
        ];     
        
        $result1 = get_post_meta($output_id, 'result_one', true);
        wp_localize_script('quiz', 'resultOne', ['outcome' => $result1]);

        $result2 = get_post_meta($output_id, 'result_two', true);
        wp_localize_script('quiz', 'resultTwo', ['outcome' => $result2]);
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
                    <h1><span id="result-display"></span> !</h1>
                    
                </div>
            </div>
            <div id="quiz-questions" class="flex-center">
                <?php 
                    foreach ($questions as $question) { 
                ?>
                <div class="quiz-question-answers">
                
                    <h2 class="quiz-question"><?php print $question["question"]; ?></h2>
                    <div class="quiz-question-answer">
                        <img src="<?php print $question["answer1_image"] ?>" class="answer" data-value="<?php print $question["answer1_value"] ?>" data-name="<?php print $question["answer1_image"] ?>">
                        <p class="answer"><?php print $question["answer1"] ?></p>
                    </div>
                    <div class="quiz-question-answer">
                        <img src="<?php print $question["answer2_image"] ?>" class="answer" data-value="<?php print $question["answer2_value"] ?>" data-name="<?php print $question['answer2_image'] ?>">
                        <p class="answer"><?php print $question["answer2"] ?></p>
                    </div>
                </div>
                <?php } ?>
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