<?php
namespace ArtOfWP\WP\Testing\Factory;

class WP_UnitTest_Factory {

	/**
	 * @var WP_UnitTest_Factory_For_Post
	 */
	public $post;

	/**
	 * @var WP_UnitTest_Factory_For_Attachment
	 */
	public $attachment;

	/**
	 * @var WP_UnitTest_Factory_For_Comment
	 */
	public $comment;

	/**
	 * @var WP_UnitTest_Factory_For_User
	 */
	public $user;

	/**
	 * @var WP_UnitTest_Factory_For_Term
	 */
	public $term;

	/**
	 * @var WP_UnitTest_Factory_For_Term
	 */
	public $category;

	/**
	 * @var WP_UnitTest_Factory_For_Term
	 */
	public $tag;

	/**
	 * @var WP_UnitTest_Factory_For_Blog
	 */
	public $blog;

	/**
	 * @var WP_UnitTest_Factory_For_Network
	 */
	public $network;

	function __construct() {
		$this->post = new WP_UnitTest_Factory_For_Post( $this );
		$this->attachment = new WP_UnitTest_Factory_For_Attachment( $this );
		$this->comment = new WP_UnitTest_Factory_For_Comment( $this );
		$this->user = new WP_UnitTest_Factory_For_User( $this );
		$this->term = new WP_UnitTest_Factory_For_Term( $this );
		$this->category = new WP_UnitTest_Factory_For_Term( $this, 'category' );
		$this->tag = new WP_UnitTest_Factory_For_Term( $this, 'post_tag' );
		if ( is_multisite() ) {
			$this->blog = new WP_UnitTest_Factory_For_Blog( $this );
			$this->network = new WP_UnitTest_Factory_For_Network( $this );
		}
	}
}

