<?php
namespace ArtOfWP\WP\Testing\Exceptions;
/**
 * Exception for cases of wp_die(), for ajax tests.
 * This means there was an error (no output, and a call to wp_die)
 *
 * @package    WordPress
 * @subpackage Unit Tests
 * @since      3.4.0
 */
class WPAjaxDieStopException extends WPDieException {}