<?php
namespace ArtOfWP\WP\Testing\Factory;

class WP_UnitTest_Factory_For_Attachment extends WP_UnitTest_Factory_For_Post {

    function create_object( $file, $parent = 0, $args = array() ) {
        return wp_insert_attachment( $args, $file, $parent );
    }
}