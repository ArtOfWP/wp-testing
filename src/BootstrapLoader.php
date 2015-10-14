<?php
namespace ArtOfWP\WP\Testing;

class BootstrapLoader extends \PHPUnit_Framework_BaseTestListener {
    /**
     * @param \PHPUnit_Framework_TestSuite $suite
     */
    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite) {
        switch($suite->getName()) {
            case "unit":
            case "integration":
            case "acceptance":
            case "functional":
                echo "\nRunning {$suite->getName()} tests\n";
                if(file_exists(getcwd()."/tests/{$suite->getName()}/bootstrap.php"))
                    require getcwd()."/tests/{$suite->getName()}/bootstrap.php";
                else if(file_exists(getcwd()."/tests/bootstrap-{$suite->getName()}.php"))
                    require getcwd()."/tests/bootstrap-{$suite->getName()}.php";
        }
    }
}
