<?php
namespace ArtOfWP\WP\Testing\Mocking;
$_tests_dir = getenv('WP_TESTS_DIR');
require_once( dirname(dirname($_tests_dir)) . '/src/wp-includes/class-phpmailer.php' );

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
