<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * The MXEFBasisPluginClass class.
 *
 * This class runs when you activate the plugin.
 * In this place you can eg. create a custom table.
 */
class MXEFBasisPluginClass
{

    private static $tableSlug = MXEF_TABLE_SLUG;

    public static function activate()
    {

    }

    public static function deactivate()
    {
        // Rewrite rules via installation.
        flush_rewrite_rules();
    }

    /*
    * This function sets the option for CPT rewrite rules.
    */
    public static function createOptionForActivation()
    {

        add_option( 'mxef_flush_rewrite_rules', 'go_flush_rewrite_rules' );
    }

}
