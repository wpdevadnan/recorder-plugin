<?php

    /**
     * blank_riders functions and definitions
     *
     * @link https://developer.wordpress.org/themes/basics/theme-functions/
     *
     * @package blank_riders
     */
//  Loading java scripts & jquerys
    function custom_adding_scripts() {
            wp_register_script('customjs', get_template_directory_uri() . '/vendor/jquery/customjs.js', array('jquery'), time(), true);
            wp_localize_script('customjs', 'dr_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
            wp_enqueue_script('customjs');


            wp_register_script('bootstrap.bundle.min.js', get_template_directory_uri() . '/vendor/bootstrap/js/bootstrap.bundle.min.js', [], null, true);
            wp_enqueue_script('bootstrap.bundle.min.js');

            wp_register_script('jquery.min.js', get_template_directory_uri() . '/vendor/jquery/jquery.min.js', [], null, true);
            wp_enqueue_script('jquery.min.js');
    }

    add_action('wp_enqueue_scripts', 'custom_adding_scripts');

// Loading style sheets

    function custom_adding_styles() {
            wp_register_style('creative', get_template_directory_uri() . '/css/creative.css', [], null);
            wp_enqueue_style('creative');

            wp_register_style('fontawesome-free.all.min', get_template_directory_uri() . '/vendor/fontawesome-free/css/all.min.css', [], null);
            wp_enqueue_style('fontawesome-free.all.min');

            wp_register_style('bootstrap', get_template_directory_uri() . '/vendor/bootstrap/css/bootstrap.min.css', [], null);
            wp_enqueue_style('bootstrap');

            wp_register_style('fonts', get_template_directory_uri() . '/css/fonts.css', [], null);
            wp_enqueue_style('fonts');

            wp_register_style('responsive', get_template_directory_uri() . '/css/responsive.css', [], null);
            wp_enqueue_style('responsive');
    }

    add_action('wp_enqueue_scripts', 'custom_adding_styles');

// creating Custom logo in Customize header section

    add_theme_support('custom-logo');

    function customlogo_in_customizer() {

            add_theme_support('custom-logo', array(
                'height' => 50,
                'width' => 186,
                'flex-width' => true,
            ));
    }

    add_action('after_setup_theme', 'customlogo_in_customizer');

// cleaning extra classes in the custom logo links

    add_filter('wp_get_attachment_image_attributes', function( $attr ) {
            if (isset($attr['class']) && 'custom-logo' === $attr['class'])
                    $attr['class'] = '';

            return $attr;
    });

// creating footer widget

    function blank_riders_widgets_create() {
            register_sidebar(array(
                'name' => esc_html__('Footer', 'blank_riders'),
                'id' => 'footer-1',
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>',
            ));
    }

    add_action('widgets_init', 'blank_riders_widgets_create');


//registering metaboxes
//Register Meta Box

    include get_template_directory() . '/class/metaboxes.php';

//active span tag in tiny mice editor


    function override_mce_options($initArray) {
            $opts = '*[*]';
            $initArray['valid_elements'] = $opts;
            $initArray['extended_valid_elements'] = $opts;
            return $initArray;
    }

    add_filter('tiny_mce_before_init', 'override_mce_options');

// Before VC Init
    add_action('vc_before_init', 'vc_before_init_actions');

    function vc_before_init_actions() {

            //.. Code from other Tutorials ..//
            // Require new custom Element
            // require_once( get_template_directory().'/vc-elements/ridersway.php' );
    }

    function titlefix() {
            add_filter('woocommerce_show_page_title', '__return_true', 1);
            add_filter('woocommerce_single_product_summary', 'woocommerce_template_single_title', 6);
    }

    add_action('init', 'titlefix');


    require_once (dirname(__FILE__) . '/redux-framework/barebones-config.php');

    function example_ajax_request() {

            // The $_REQUEST contains all the data sent via ajax
            if (isset($_REQUEST)) {

                    $fruit = $_REQUEST['fruit'];

                    // Let's take the data that was sent and do something with it
                    if ($fruit == 'Banana') {
                            $fruit = 'adnan hyder';
                    }

                    // Now we'll return it to the javascript function
                    // Anything outputted will be returned in the response
                    //echo $fruit;
                    // If you're debugging, it might be useful to see what was sent in the $_REQUEST
                    // print_r($_REQUEST);
            }

            // Always die in functions echoing ajax content
            die();
    }

    add_action('wp_ajax_example_ajax_request', 'example_ajax_request');

// If you wanted to also use the function for non-logged in users (in a theme for example)
    add_action('wp_ajax_nopriv_example_ajax_request', 'example_ajax_request');



    add_filter('woocommerce_product_tabs', 'producttab');

    function producttab($tabs) {
            // Add the new tab
            $tabs['custom_tab_1'] = array(
                'title' => __('Discount', 'text-domain'),
                'priority' => 50,
                'callback' => 'product_tab_content'
            );
            $tabs['custom_tab_2'] = array(
                'title' => __('Review This Product', 'text-domain'),
                'priority' => 50,
                'callback' => 'product_tab_content2'
            );
            return $tabs;
    }

    function product_tab_content() {
            // The new tab content
            echo 'Discount';
            echo 'Here\'s your new discount product tab.';
            echo '<p class = "searchmessage" style = "display:none"></p>
            <form action = "#" method = "POST" name = "register-form" class = "register-form">
            <input type = "text" name = "search_txt" placeholder = "Search User" id = "new-search">
            <input type = "submit" class = "button" id = "search-button" value = "Search" >
            </form>';
    }

    function product_tab_content2() {
            // The new tab content
            echo 'product Review';
            wp_login_form();

            echo '<p class = "register-message" style = "display:none"></p>
            <form action = "#" method = "POST" name = "register-form" class = "register-form">
            <fieldset>
            <label><i class = "fa fa-file-text-o"></i> Register Form</label>
            <input type = "text" name = "new_user_name" placeholder = "Username" id = "new-username">
            <input type = "email" name = "new_user_email" placeholder = "Email address" id = "new-useremail">
            <input type = "password" name = "new_user_password" placeholder = "Password" id = "new-userpassword">
            <input type = "password" name = "re-pwd" placeholder = "Re-enter Password" id = "re-pwd">
            <input type = "submit" class = "button" id = "register-button" value = "Register" >
            </fieldset>
            </form>';
    }

    add_action('wp_ajax_register_user_front_end', 'register_user_front_end', 0);
    add_action('wp_ajax_nopriv_register_user_front_end', 'register_user_front_end');

    function register_user_front_end() {
            $new_user_name = stripcslashes($_POST['new_user_name']);
            $new_user_email = stripcslashes($_POST['new_user_email']);
            $new_user_password = $_POST['new_user_password'];
            $user_nice_name = strtolower($_POST['new_user_email']);
            $user_data = array(
                'user_login' => $new_user_name,
                'user_email' => $new_user_email,
                'user_pass' => $new_user_password,
                'user_nicename' => $user_nice_name,
                'display_name' => $new_user_first_name,
                'role' => 'subscriber'
            );
            $user_id = wp_insert_user($user_data);
            if (!is_wp_error($user_id)) {
                    echo 'we have Created an account for you.';
            } else {
                    if (isset($user_id->errors['empty_user_login'])) {
                            $notice_key = 'User Name and Email are mandatory';
                            echo $notice_key;
                    } elseif (isset($user_id->errors['existing_user_login'])) {
                            echo'User name already exixts.';
                    } else {
                            echo'Error Occured please fill up the sign up form carefully.';
                    }
            }
            die;
    }

    add_action('wp_ajax_user_search', 'user_search', 0);
    add_action('wp_ajax_nopriv_user_search', 'user_search');

    function user_search() {
            $new_search = stripcslashes($_POST['search']);
            echo $new_search;
            die;
    }
