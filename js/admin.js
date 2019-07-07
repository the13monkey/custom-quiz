jQuery(document).ready(function($){
    //Set up variables for each answer
    var add_btn_q1_a1 = document.getElementById('image-upload-q1-a1');
    var delete_btn_q1_a1 = document.getElementById('image-delete-q1-a1');
    var image_q1_a1 = document.getElementById('img-tag-q1-a1');
    var hidden_btn_q1_a1 = document.getElementById('hidden-btn-q1-a1');
    var update_btn_q1_a1 = document.getElementById('is_update_q1_a1');

    var add_btn_q1_a2 = document.getElementById('image-upload-q1-a2');
    var delete_btn_q1_a2 = document.getElementById('image-delete-q1-a2');
    var image_q1_a2 = document.getElementById('img-tag-q1-a2');
    var hidden_btn_q1_a2 = document.getElementById('hidden-btn-q1-a2');
    var update_btn_q1_a2 = document.getElementById('is_update_q1_a2');

    var add_btn_q2_a1 = document.getElementById('image-upload-q2-a1');
    var delete_btn_q2_a1 = document.getElementById('image-delete-q2-a1');
    var image_q2_a1 = document.getElementById('img-tag-q2-a1');
    var hidden_btn_q2_a1 = document.getElementById('hidden-btn-q2-a1');
    var update_btn_q2_a1 = document.getElementById('is_update_q2_a1');

    var add_btn_q2_a2 = document.getElementById('image-upload-q2-a2');
    var delete_btn_q2_a2 = document.getElementById('image-delete-q2-a2');
    var image_q2_a2 = document.getElementById('img-tag-q2-a2');
    var hidden_btn_q2_a2 = document.getElementById('hidden-btn-q2-a2');
    var update_btn_q2_a2 = document.getElementById('is_update_q2_a2');

    var add_btn_q3_a1 = document.getElementById('image-upload-q3-a1');
    var delete_btn_q3_a1 = document.getElementById('image-delete-q3-a1');
    var image_q3_a1 = document.getElementById('img-tag-q3-a1');
    var hidden_btn_q3_a1 = document.getElementById('hidden-btn-q3-a1');
    var update_btn_q3_a1 = document.getElementById('is_update_q3_a1');

    var add_btn_q3_a2 = document.getElementById('image-upload-q3-a2');
    var delete_btn_q3_a2 = document.getElementById('image-delete-q3-a2');
    var image_q3_a2 = document.getElementById('img-tag-q3-a2');
    var hidden_btn_q3_a2 = document.getElementById('hidden-btn-q3-a2');
    var update_btn_q3_a2 = document.getElementById('is_update_q3_a2');

    //Open up WordPress media uploader
    var uploader_q1_a1 = wp.media({
        title: 'Select an image for Choice 1 of Question 1',
        button: {
            text: 'Upload'
        },
        multiple: false
    });

    var uploader_q1_a2 = wp.media({
        title: 'Select an image for Choice 2 of Question 1',
        button: {
            text: 'Upload'
        },
        multiple: false
    });

    var uploader_q2_a1 = wp.media({
        title: 'Select an image for Choice 1 of Question 2',
        button: {
            text: 'Upload'
        },
        multiple: false
    });

    var uploader_q2_a2 = wp.media({
        title: 'Select an image for Choice 2 of Question 2',
        button: {
            text: 'Upload'
        },
        multiple: false
    });

    var uploader_q3_a1 = wp.media({
        title: 'Select an image for Choice 1 of Question 3',
        button: {
            text: 'Upload'
        },
        multiple: false
    });

    var uploader_q3_a2 = wp.media({
        title: 'Select an image for Choice 2 of Question 3',
        button: {
            text: 'Upload'
        },
        multiple: false
    });

    //Add click events to the buttons 
    add_btn_q1_a1.addEventListener('click', function(event){
        event.preventDefault();
        if (uploader_q1_a1) {
            uploader_q1_a1.open();
        }
    });
    delete_btn_q1_a1.addEventListener('click', function(){
        image_q1_a1.removeAttribute('src');
        hidden_btn_q1_a1.removeAttribute('value');
    });

    add_btn_q1_a2.addEventListener('click', function(event){
        event.preventDefault();
        if (uploader_q1_a2) {
            uploader_q1_a2.open();
        }
    });
    delete_btn_q1_a2.addEventListener('click', function(){
        image_q1_a2.removeAttribute('src');
        hidden_btn_q1_a2.removeAttribute('value');
    });

    add_btn_q2_a1.addEventListener('click', function(){
        if (uploader_q2_a1) {
            uploader_q2_a1.open();
        }
    });
    delete_btn_q2_a1.addEventListener('click', function(){
        image_q2_a1.removeAttribute('src');
        hidden_btn_q2_a1.removeAttribute('value');
    });

    add_btn_q2_a2.addEventListener('click', function(){
        if (uploader_q2_a2) {
            uploader_q2_a2.open();
        }
    });
    delete_btn_q2_a2.addEventListener('click', function(){
        image_q2_a2.removeAttribute('src');
        hidden_btn_q2_a2.removeAttribute('value');
    });

    add_btn_q3_a1.addEventListener('click', function(){
        if (uploader_q3_a1) {
            uploader_q3_a1.open();
        }
    });
    delete_btn_q3_a1.addEventListener('click', function(){
        image_q3_a1.removeAttribute('src');
        hidden_btn_q3_a1.removeAttribute('value');
    });

    add_btn_q3_a2.addEventListener('click', function(){
        if (uploader_q3_a2) {
            uploader_q3_a2.open();
        }
    });
    delete_btn_q3_a2.addEventListener('click', function(){
        image_q3_a2.removeAttribute('src');
        hidden_btn_q3_a2.removeAttribute('value');
    });


    //After choose the image in the WP media uploader
    uploader_q1_a1.on('select', function(){
        var attachment_q1_a1 = uploader_q1_a1.state().get('selection').first().toJSON();
        image_q1_a1.setAttribute('src', attachment_q1_a1.url); 
        image_q1_a1.style.visibility = "visible";
        hidden_btn_q1_a1.setAttribute('value', JSON.stringify([{id: attachment_q1_a1.id, url: attachment_q1_a1.url}]));
        update_btn_q1_a1.setAttribute('value', 'false');
    });

    uploader_q1_a2.on('select', function(){
        var attachment_q1_a2 = uploader_q1_a2.state().get('selection').first().toJSON();
        image_q1_a2.setAttribute('src', attachment_q1_a2.url); 
        image_q1_a2.style.visibility = "visible";
        hidden_btn_q1_a2.setAttribute('value', JSON.stringify([{id: attachment_q1_a2.id, url: attachment_q1_a2.url}]));
        update_btn_q1_a2.setAttribute('value', 'false');
    });

    uploader_q2_a1.on('select', function(){
        var attachment_q2_a1 = uploader_q2_a1.state().get('selection').first().toJSON();
        image_q2_a1.setAttribute('src', attachment_q2_a1.url); 
        image_q2_a1.style.visibility = "visible";
        hidden_btn_q2_a1.setAttribute('value', JSON.stringify([{id: attachment_q2_a1.id, url: attachment_q2_a1.url}]));
        update_btn_q2_a1.setAttribute('value', 'false');
    });

    uploader_q2_a2.on('select', function(){
        var attachment_q2_a2 = uploader_q2_a2.state().get('selection').first().toJSON();
        image_q2_a2.setAttribute('src', attachment_q2_a2.url); 
        image_q2_a2.style.visibility = "visible";
        hidden_btn_q2_a2.setAttribute('value', JSON.stringify([{id: attachment_q2_a2.id, url: attachment_q2_a2.url}]));
        update_btn_q2_a2.setAttribute('value', 'false');
    });

    uploader_q3_a1.on('select', function(){
        var attachment_q3_a1 = uploader_q3_a1.state().get('selection').first().toJSON();
        image_q3_a1.setAttribute('src', attachment_q3_a1.url); 
        image_q3_a1.style.visibility = "visible";
        hidden_btn_q3_a1.setAttribute('value', JSON.stringify([{id: attachment_q3_a1.id, url: attachment_q3_a1.url}]));
        update_btn_q3_a1.setAttribute('value', 'false');
    });

    uploader_q3_a2.on('select', function(){
        var attachment_q3_a2 = uploader_q3_a2.state().get('selection').first().toJSON();
        image_q3_a2.setAttribute('src', attachment_q3_a2.url); 
        image_q3_a2.style.visibility = "visible";
        hidden_btn_q3_a2.setAttribute('value', JSON.stringify([{id: attachment_q3_a2.id, url: attachment_q3_a2.url}]));
        update_btn_q3_a2.setAttribute('value', 'false');
    });


    //Show the selected image
    window.addEventListener('DOMContentLoaded', function(){
        var src_isexist_q1_a1 = upload_image_q1_a1.src;
        var src_isexist_q1_a2 = upload_image_q1_a2.src;
        var src_isexist_q2_a1 = upload_image_q2_a1.src;
        var src_isexist_q2_a2 = upload_image_q2_a2.src;
        var src_isexist_q3_a1 = upload_image_q3_a1.src;
        var src_isexist_q3_a2 = upload_image_q3_a2.src;

        if (src_isexist_q1_a1 == null) {
            image_q1_a1.style.visibility = "hidden";
        } else {
            image_q1_a1.setAttribute('src', upload_image_q1_a1.src);
            image_q1_a1.style.visibility = "visible";
            hidden_btn_q1_a1.setAttribute('value', JSON.stringify([upload_image_q1_a1]));
        }  
        
        if (src_isexist_q1_a2 == null) {
            image_q1_a2.style.visibility = "hidden";
        } else {
            image_q1_a2.setAttribute('src', upload_image_q1_a2.src);
            image_q1_a2.style.visibility = "visible";
            hidden_btn_q1_a2.setAttribute('value', JSON.stringify([upload_image_q1_a2]));
        }       

        if (src_isexist_q2_a1 == null) {
            image_q2_a1.style.visibility = "hidden";
        } else {
            image_q2_a1.setAttribute('src', upload_image_q2_a1.src);
            image_q2_a1.style.visibility = "visible";
            hidden_btn_q2_a1.setAttribute('value', JSON.stringify([upload_image_q2_a1]));
        } 

        if (src_isexist_q2_a2 == null) {
            image_q2_a2.style.visibility = "hidden";
        } else {
            image_q2_a2.setAttribute('src', upload_image_q2_a2.src);
            image_q2_a2.style.visibility = "visible";
            hidden_btn_q2_a2.setAttribute('value', JSON.stringify([upload_image_q2_a2]));
        }
        
        if (src_isexist_q3_a1 == null) {
            image_q3_a1.style.visibility = "hidden";
        } else {
            image_q3_a1.setAttribute('src', upload_image_q3_a1.src);
            image_q3_a1.style.visibility = "visible";
            hidden_btn_q3_a1.setAttribute('value', JSON.stringify([upload_image_q3_a1]));
        }

        if (src_isexist_q3_a2 == null) {
            image_q3_a2.style.visibility = "hidden";
        } else {
            image_q3_a2.setAttribute('src', upload_image_q3_a2.src);
            image_q3_a2.style.visibility = "visible";
            hidden_btn_q3_a2.setAttribute('value', JSON.stringify([upload_image_q3_a2]));
        }
    });

    
})