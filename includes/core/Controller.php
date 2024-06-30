<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * The MXEFController abstract class.
 *
 * Basic settings of Controller.
 */
abstract class MXEFController
{

    /**
    * Catch missing methods on the controller
    */
    public function __call( $name, $arguments ) {

        echo esc_attr( 'Missing method "' . $name . '"!' );
    }

}
