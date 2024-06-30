<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

// Require Display Error feature.
require_once MXEF_PLUGIN_ABS_PATH . 'includes/core/error_handle/Display-Error.php';

// Require Handle Error feature.
require_once MXEF_PLUGIN_ABS_PATH . 'includes/core/error_handle/Error-Handle.php';

/**
 * The MXEFCatchingErrors class.
 *
 * Catching errors.
 */
class MXEFCatchingErrors
{

	/**
	* Show notification missing class or methods.
	*/
	public static function catchClassAttributesError( $className, $method )
	{

		$errorClassInstance = new MXEFErrorHandle();

		$errorDisplay = $errorClassInstance->classAttributesError( $className, $method );

		$error = NULL;

		if ($errorDisplay !== true) {
			$error = $errorDisplay;
		}		

		return $error;
	}

}
