<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * The MXEFAdminMain class.
 *
 * Here you can register you classes.
 */
class MXEFAdminMain
{

    /*
    * List of model names used in the plugin.
    */
    public $modelsCollection = [
        'MXEFMainAdminModel'
    ];

    /*
    * Additional classes.
    */
    public function additionalClasses()
    {

        // Enqueue scripts.
        mxefRequireClassFileAdmin( 'enqueue-scripts.php' );

        MXEFEnqueueScripts::registerScripts();
        
        // Metaboxes engine.
        mxefRequireClassFileAdmin( 'metabox.php' );

        // CPT, Taxonomies and Metaboxes.
        mxefRequireClassFileAdmin( 'cpt.php' );

        MXEFCPTGenerator::createCPT();

        // CPT, Taxonomies and Metaboxes.
        mxefRequireClassFileAdmin( 'cpt.php' );
    }

    /*
    * Models Connection.
    */
    public function modelsCollection()
    {

        foreach ($this->modelsCollection as $model) {            
            mxefUseModel( $model );
        }
    }

    /**
    * AJAX actions registration.
    */
    public function registrationAjaxActions()
    {

        MXEFMainAdminModel::wpAjax();
    }

    /*
    * Routes collection.
    */
    public function routesCollection()
    {

    }

}

/**
 * Initialization.
 */
$adminClassInstance = new MXEFAdminMain();

/**
 * Include classes.
 */
$adminClassInstance->additionalClasses();

/**
 * Include models.
 */
$adminClassInstance->modelsCollection();

/**
 * AJAX requests registration.
 */
$adminClassInstance->registrationAjaxActions();

/**
 * Include controllers.
 */
$adminClassInstance->routesCollection();
