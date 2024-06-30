<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * The MXEFEnqueueScripts class.
 *
 * Here you can register your CSS and JS files for the admin panel.
 */
class MXEFEnqueueScripts
{

    public static function registerScripts()
    {

        // Register scripts and styles actions.
        add_action( 'admin_enqueue_scripts', ['MXEFEnqueueScripts', 'enqueue'] );
    }

    public static function enqueue()
    {

        wp_enqueue_style( 'mxef_font_awesome', MXEF_PLUGIN_URL . 'assets/font-awesome-4.6.3/css/font-awesome.min.css' );

        wp_enqueue_style( 'mxef_admin_style', MXEF_PLUGIN_URL . 'includes/admin/assets/css/style.css', [ 'mxef_font_awesome' ], MXEF_PLUGIN_VERSION, 'all' );

        wp_enqueue_script( 'mxef_admin_script', MXEF_PLUGIN_URL . 'includes/admin/assets/js/script.js', [ 'jquery','wp-i18n' ], MXEF_PLUGIN_VERSION, true );
        wp_set_script_translations( 'mxef_admin_script', 'ewd-faq', plugin_dir_path(__FILE__) . 'languages');

        wp_localize_script( 'mxef_admin_script', 'mxef_admin_localize', [
            'ajaxurl'   => admin_url( 'admin-ajax.php' ),
            'main_page' => admin_url( 'admin.php?page=' . MXEF_MAIN_MENU_SLUG ),
            'nonce' => wp_create_nonce(MXEF_MAIN_MENU_SLUG.'nonce')

        ] );
        
        wp_enqueue_script('wp-editor');
        wp_enqueue_script('wp-tinymce');
        wp_enqueue_editor();
        wp_enqueue_style('flaticon-regular', 'https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-rounded/css/uicons-regular-rounded.css');
        wp_enqueue_style('flaticon-solid', 'https://cdn-uicons.flaticon.com/2.1.0/uicons-solid-rounded/css/uicons-solid-rounded.css');
        wp_enqueue_style('flaticon-straight', 'https://cdn-uicons.flaticon.com/2.1.0/uicons-solid-straight/css/uicons-solid-straight.css');
        wp_enqueue_style('flaticon-rounded', 'https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'); 

    }

}
