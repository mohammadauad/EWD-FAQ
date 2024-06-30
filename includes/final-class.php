<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * The MXEFEWDFAQWPPGenerator class.
 *
 * This is a final class of the plugin.
 * Here you can find/add/remove components
 * of the plugin.
 */
final class MXEFEWDFAQWPPGenerator
{

    /**
     * Require necessary files.
     * 
     * @return void
     */
    public function includeCore()
    {        

        // Helpers.
        require_once MXEF_PLUGIN_ABS_PATH . 'includes/core/helpers.php';

        // Catching errors.
        require_once MXEF_PLUGIN_ABS_PATH . 'includes/core/Catching-Errors.php';

        // Route.
        require_once MXEF_PLUGIN_ABS_PATH . 'includes/core/Route.php';

        // Models.
        require_once MXEF_PLUGIN_ABS_PATH . 'includes/core/Model.php';

        // Views.
        require_once MXEF_PLUGIN_ABS_PATH . 'includes/core/View.php';

        // Controllers.
        require_once MXEF_PLUGIN_ABS_PATH . 'includes/core/Controller.php';
    }

    /**
     * Include Global Features.
     * 
     * @return void
     */
    public function includeGlobalFeatures()
    {

        require_once MXEF_PLUGIN_ABS_PATH . 'includes/global/index.php';
    }

    /**
     * Include Admin Panel Features.
     * 
     * @return void
     */
    public function includeAdminPanel()
    {

        require_once MXEF_PLUGIN_ABS_PATH . 'includes/admin/admin-main.php';
    }

    /**
     * Include Frontend Features.
     * 
     * @return void
     */
    public function includeFrontendPath()
    {

        require_once MXEF_PLUGIN_ABS_PATH . 'includes/frontend/frontend-main.php';
    }


    /**
     * REST API.
     * 
     * @return void
     */
    public function includeRestApi()
    {

        require_once MXEF_PLUGIN_ABS_PATH . 'rest-api/index.php';
    }


}

/**
 * The Final class instance.
 */
$wppGenerator = new MXEFEWDFAQWPPGenerator();

/**
 * The core files (helpers, models, controllers ...).
 */
$wppGenerator->includeCore();

/**
 * Include global features.
 */
$wppGenerator->includeGlobalFeatures();

/**
 * Turn on the admin panel features.
 */
$wppGenerator->includeAdminPanel();

/**
 * Turn on the frontend features.
 */
$wppGenerator->includeFrontendPath();

