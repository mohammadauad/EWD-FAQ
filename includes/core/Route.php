<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

// Require Route Registrar class.
require_once MXEF_PLUGIN_ABS_PATH . 'includes/core/Route-Registrar.php';

/**
 * The MXEFRoute class.
 *
 * This class works together with 
 * MXEFRouteRegistrar class and helps
 * create a menu pate in the admin panel.
 */
class MXEFRoute
{
    
    public static function get( ...$args )
    {

        return new MXEFRouteRegistrar( ...$args );
    }
    
}
