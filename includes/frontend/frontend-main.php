<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * The MXEFFrontEndMain class.
 *
 * Here you can register you classes.
 */
class MXEFFrontEndMain
{

    /*
    * Additional classes
    */
    public function additionalClasses()
    {

        // enqueue_scripts class.
        mxefRequireClassFileFrontend( 'enqueue-scripts.php' );

        MXEFEnqueueScriptsFrontend::registerScripts();

        // Add shortcode.
        mxefRequireClassFileFrontend( 'add-shortcode.php' );
        
        (new MXEFAddShortcode)->shortcodeDisplayApp();

    }

}

/**
 * Initialization.
 */
$frontendClassInstance = new MXEFFrontEndMain();

/**
 * Include classes to the global space.
 */
$frontendClassInstance->additionalClasses();
