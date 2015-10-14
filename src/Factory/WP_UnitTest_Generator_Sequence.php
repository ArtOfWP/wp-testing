<?php
namespace ArtOfWP\WP\Testing\Factory;

class WP_UnitTest_Generator_Sequence {
    var $next;
    var $template_string;

    function __construct( $template_string = '%s', $start = 1 ) {
        $this->next = $start;
        $this->template_string = $template_string;
    }

    function next() {
        $generated = sprintf( $this->template_string , $this->next );
        $this->next++;
        return $generated;
    }
}

