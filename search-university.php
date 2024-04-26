<?php
/**
 * Plugin Name: Search University Program
 * 
 * Description: Creates a shortcode to search Universities according to user keyword
 *
 * Version: 1.2
 * Author: Web Developer
 *
 * License: GPL-2.0+
 * Text Domain: ss-supt
 *
 * WC tested up to: 6.5.2
**/

/**
 * If this file is called directly, abort.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die;
}


/**
 * Constant Definitions
 */
define( 'SUPT_VERSION', '1.2' );
define( 'SUPT_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) );
define( 'SUPT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


/**
 * Plugin init function
 */
function supt_session_start_activator() {

    if ( !session_id() ) {
        session_start();
    }

}
add_action( 'init', 'supt_session_start_activator', 1 );


/**
 * Register a new custom menu page.
 */
function register_supt_menu_page() {
    add_menu_page(
        __( 'Search University', 'ss-supt' ),
        __( 'Search University', 'ss-supt' ),
        'manage_options',
        'search_university_program',
        'supt_menu_page_content',
        SUPT_PLUGIN_URL . 'admin/assets/imgs/university.png', 
        55
    );
}
add_action( 'admin_menu', 'register_supt_menu_page' );


/**
 * Display a new custom menu page content
 */
function supt_menu_page_content() {
    require_once SUPT_PLUGIN_DIR . '/admin/supt-dashboard.php';
}


/**
 * Register a new submenu item.
 */
function register_supt_submenu_upload_page() {
    add_submenu_page(
        'search_university_program',
        __( 'Upload', 'ss-supt' ),
        __( 'Upload', 'ss-supt' ),
        'manage_options',
        'supt_upload_file',
        'supt_submenu_upload_content'
    );
}
add_action( 'admin_menu', 'register_supt_submenu_upload_page' );


/**
 * Display a new submenu item page content
 */
function supt_submenu_upload_content() {
    require_once SUPT_PLUGIN_DIR . '/admin/supt-upload.php';
}


/**
 * Add admin script and stylesheets.
 */
function supt_admin_assets() {

    wp_enqueue_style ( 'supt_admin_menu_css', SUPT_PLUGIN_URL . 'admin/assets/css/supt-admin-menu.css', '', null );

    if ( $_GET['page'] == 'search_university_program' || $_GET['page'] == 'supt_upload_file' ) {
        wp_enqueue_style ( 'supt_admin_css', SUPT_PLUGIN_URL . 'admin/assets/css/supt-admin.css', '', SUPT_VERSION );
        wp_enqueue_script( 'supt_admin_js', SUPT_PLUGIN_URL . 'admin/assets/js/supt-admin.js', array( 'jquery' ), SUPT_VERSION, true );
    }

}
add_action( 'admin_enqueue_scripts', 'supt_admin_assets' );


/**
 * Add Preview frontend View script and stylesheets.
 */
function supt_custom_assets() {

    if ( !wp_script_is( 'jquery' ) ) {
        wp_enqueue_script( 'jquery' );
    }

    if ( file_exists( SUPT_PLUGIN_DIR . '/public/assets/css/supt-custom.css' ) ) {
        wp_enqueue_style ( 'supt_custom_css', SUPT_PLUGIN_URL . 'public/assets/css/supt-custom.css', '', SUPT_VERSION );
    }

    if ( file_exists( SUPT_PLUGIN_DIR . '/public/assets/js/supt-custom.js' ) ) {
        wp_enqueue_script( 'supt_custom_js', SUPT_PLUGIN_URL . 'public/assets/js/supt-custom.js', array( 'jquery' ), SUPT_VERSION, true );
    }

}
add_action( 'wp_enqueue_scripts', 'supt_custom_assets' );


/**
 * Create Shortcode to display the Search University tool
 */
include_once( SUPT_PLUGIN_DIR . '/public/supt-shortcode.php' );
add_shortcode( 'Search-University', 'supt_shortcode' );

add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode', 11 );


/**
 * Install University Program db table when the plugin is activated
 */
function supt_db_install() {

    global $wpdb;

    $table_name = $wpdb->prefix . 'supt_university_data';  
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id              mediumint(9) NOT NULL AUTO_INCREMENT, 
        city            varchar(255) NOT NULL, 
        university      varchar(255) NOT NULL, 
        un_type         boolean NOT NULL, 
        institute       varchar(255), 
        program         varchar(255) NOT NULL, 
        thesis          varchar(255), 
        edu_lang        varchar(255), 
        edu_type        varchar(255), 
        app_date        varchar(255), 
        app_date_link   varchar(255), 
        edu_fee         varchar(255), 
        edu_fee_link    varchar(255), 
        note            varchar(255), 
        PRIMARY KEY     (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'supt_version', SUPT_VERSION );

}
register_activation_hook( __FILE__, 'supt_db_install' );