<?php
namespace ArtOfWP\WP\Testing\Mocking;
$path = defined('ABSPATH') ? ABSPATH : \ArtOfWP\WP\Testing\WP_Bootstrap::get_abspath();
require_once ( $path . '/wp-includes/class-phpmailer.php' );

class MockPHPMailer extends \PHPMailer {
	var $mock_sent = array();

	function preSend() {
		$this->Encoding = '8bit';
		return parent::preSend();
	}

	/**
	 * Override postSend() so mail isn't actually sent.
	 */
	function postSend() {
		$this->mock_sent[] = array(
			'to'     => $this->to,
			'cc'     => $this->cc,
			'bcc'    => $this->bcc,
			'header' => $this->MIMEHeader,
			'body'   => $this->MIMEBody,
		);

		return true;
	}
}
