<?php

/*
Plugin Name: EWD FAQ
Plugin URI: http://www.euroweb-digital.com/
Description:  Euroweb Digital - Mohammad auad
Author: Euroweb Digital - Mohammad auad
Version: 1.0
Author URI: https://github.com/mohammadauad/
*/

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/*
* Unique string - MXEF
*/

/*
* Define MXEF_PLUGIN_PATH
*
* D:\xampp\htdocs\my-domain.com\wp-content\plugins\ewd-faq\ewd-faq.php
*/
if (!defined('MXEF_PLUGIN_PATH')) {

	define( 'MXEF_PLUGIN_PATH', __FILE__ );
}

/*
* Define MXEF_PLUGIN_URL
*
* Return http://my-domain.com/wp-content/plugins/ewd-faq/
*/
if (!defined('MXEF_PLUGIN_URL')) {

	define( 'MXEF_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
}

/*
* Define MXEF_PLUGN_BASE_NAME
*
* Return ewd-faq/ewd-faq.php
*/
if (!defined( 'MXEF_PLUGN_BASE_NAME')) {

	define( 'MXEF_PLUGN_BASE_NAME', plugin_basename( __FILE__ ) );
}

/*
* Define MXEF_TABLE_SLUG
*/
if (!defined('MXEF_TABLE_SLUG')) {

	define( 'MXEF_TABLE_SLUG', 'mxef_mx_table' );
}

/*
* Define MXEF_PLUGIN_ABS_PATH
* 
* D:\xampp\htdocs\my-domain.com\wp-content\plugins\ewd-faq/
*/
if (!defined( 'MXEF_PLUGIN_ABS_PATH')) {

	define( 'MXEF_PLUGIN_ABS_PATH', dirname( MXEF_PLUGIN_PATH ) . '/' );
}

/*
* Define MXEF_PLUGIN_VERSION
* 
* The version of all CSS and JavaScript files in this plugin.
*/
if (!defined('MXEF_PLUGIN_VERSION')) {

	define( 'MXEF_PLUGIN_VERSION', time() ); // Must be replaced before production on for example '1.0'
}

/*
* Define MXEF_MAIN_MENU_SLUG
*/
if (!defined('MXEF_MAIN_MENU_SLUG')) {

	define( 'MXEF_MAIN_MENU_SLUG', 'mxef-ewd-faq-main-page' );
}

/*
* Define MXEF_SINGLE_TABLE_ITEM_MENU
*/
if (!defined( 'MXEF_SINGLE_TABLE_ITEM_MENU')) {

	// Single table item menu.
	define( 'MXEF_SINGLE_TABLE_ITEM_MENU', 'mxef-ewd-faq-single-page' );
}

/*
* Define MXEF_CREATE_TABLE_ITEM_MENU
*/
if (!defined('MXEF_CREATE_TABLE_ITEM_MENU')) {

	// Table item menu.
	define( 'MXEF_CREATE_TABLE_ITEM_MENU', 'mxef-ewd-faq-create-item-page' );
}

/**
 * activation|deactivation
 */
require_once plugin_dir_path( __FILE__ ) . 'install.php';

/*
* Registration hooks.
*/
// Activation.
register_activation_hook( __FILE__, ['MXEFBasisPluginClass', 'activate'] );

// Deactivation.
register_deactivation_hook( __FILE__, ['MXEFBasisPluginClass', 'deactivate'] );

/*
* Include the main MXEFEWDFAQ class.
*/
if (!class_exists('MXEFEWDFAQ')) {

	require_once plugin_dir_path( __FILE__ ) . 'includes/final-class.php';

	/*
	* Translate plugin.
	*/
	function mxef_translate()
	{

		load_plugin_textdomain( 'ewd-faq', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	}
	add_action( 'plugins_loaded', 'mxef_translate' );
}
