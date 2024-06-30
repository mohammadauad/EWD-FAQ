<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * This file contains global features for 
 * Admin and Frontend parts.
 */

 if (!function_exists('mxef_register_scripts')) {
    /**
     * Register scripts globally.
     * 
     * @return void
     */
    function mxef_register_scripts()
    {

    }
}
add_action('wp_enqueue_scripts', 'mxef_register_scripts');
add_action('admin_enqueue_scripts', 'mxef_register_scripts');
