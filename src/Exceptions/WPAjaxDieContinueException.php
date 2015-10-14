<?php
namespace ArtOfWP\WP\Testing\Exceptions;

/**
 * Exception for cases of wp_die(), for ajax tests.
 * This means execution of the ajax function should be halted, but the unit
 * test can continue.  The function finished normally and there was not an
 * error (output happened, but wp_die was called to end execution)  This is
 * used with WP_Ajax_Response::send
 *
 * @package    WordPress
 * @subpackage Unit Tests
 * @since      3.4.0
 */
class WPAjaxDieContinueException extends WPDieException {}