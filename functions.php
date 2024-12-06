<?php
function anontalk_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => 'Primary Menu',
        'mobile' => 'Mobile Menu'
    ));
}
add_action('after_setup_theme', 'anontalk_setup');

// Enqueue scripts and styles
function anontalk_scripts() {
    wp_enqueue_style('anontalk-style', get_stylesheet_uri());
    wp_enqueue_style('tailwindcss', get_template_directory_uri() . '/dist/output.css');
    wp_enqueue_script('anontalk-script', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('anontalk-script', 'anonTalkAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('anontalk-nonce')
    ));
}
add_action('wp_enqueue_scripts', 'anontalk_scripts');

// Custom post types
function anontalk_register_post_types() {
    // Profiles
    register_post_type('profile', array(
        'labels' => array(
            'name' => 'Profiles',
            'singular_name' => 'Profile'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true
    ));
    
    // Messages
    register_post_type('message', array(
        'labels' => array(
            'name' => 'Messages',
            'singular_name' => 'Message'
        ),
        'public' => true,
        'has_archive' => false,
        'supports' => array('title', 'editor'),
        'show_in_rest' => true
    ));
    
    // Polls
    register_post_type('poll', array(
        'labels' => array(
            'name' => 'Polls',
            'singular_name' => 'Poll'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor'),
        'show_in_rest' => true
    ));
    
    // Rankings
    register_post_type('ranking', array(
        'labels' => array(
            'name' => 'Rankings',
            'singular_name' => 'Ranking'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor'),
        'show_in_rest' => true
    ));
}
add_action('init', 'anontalk_register_post_types');

// AJAX handlers
function anontalk_like_profile() {
    check_ajax_referer('anontalk-nonce', 'nonce');
    
    $profile_id = intval($_POST['profile_id']);
    $likes = get_post_meta($profile_id, 'likes', true);
    $likes = $likes ? $likes + 1 : 1;
    update_post_meta($profile_id, 'likes', $likes);
    
    wp_send_json_success(array('likes' => $likes));
}
add_action('wp_ajax_like_profile', 'anontalk_like_profile');
add_action('wp_ajax_nopriv_like_profile', 'anontalk_like_profile');

// Instagram integration
function anontalk_instagram_callback() {
    if (!isset($_GET['code'])) {
        return;
    }
    
    $code = $_GET['code'];
    $instagram_config = array(
        'client_id' => '545858305026747',
        'client_secret' => '9d9b204866a05ba3bebdb29366a8792e',
        'redirect_uri' => home_url('/instagram-callback'),
        'grant_type' => 'authorization_code'
    );
    
    // Exchange code for access token
    $token_url = 'https://api.instagram.com/oauth/access_token';
    $response = wp_remote_post($token_url, array(
        'body' => array_merge($instagram_config, array('code' => $code))
    ));
    
    if (is_wp_error($response)) {
        wp_redirect(home_url('/'));
        exit;
    }
    
    $body = json_decode(wp_remote_retrieve_body($response), true);
    if (isset($body['access_token'])) {
        update_option('instagram_access_token', $body['access_token']);
        update_option('instagram_user_id', $body['user_id']);
    }
    
    wp_redirect(home_url('/profiles'));
    exit;
}
add_action('template_redirect', 'anontalk_instagram_callback');