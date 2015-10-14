# WP Testing framework
*__DISCLAIMER:__ This project is experimental.*

This is a fork of the official WordPress testing tools. Main difference is that this fork is adapted to be used with Composer and thereby support autoloading.
Another big difference is that the WP Unit testcases has been decoupled from the bootstrap file. This is good due to how PHPUnit works, PHPUnit loads all testfiles when it starts before this meant that the WordPress install and related activities were run even when they were not required.
Everything related to WordPress Trac and the standard WordPress testsuite has also been removed.

At it current state it requires the default WordPress testing setup to function.

## How to use
### Step 1
Setup WordPress testing environment as usual. [See WordPress PHPUnit](https://make.wordpress.org/core/handbook/testing/automated-testing/phpunit/).
This test framework uses the environment variable WP_TESTS_DIR  to locate the WordPress files.

### Step 2
Install this framework using Composer.

### Step 3
Create a phpunit.xml file in the *project root directory*. The example file below defines 3 test suites that PHPUnit should run by default.
The listener is used to load the bootstrap file for each test suite.
```xml
<phpunit
        bootstrap="tests/bootstrap.php"
        backupGlobals="false"
        colors="true"
        convertErrorsToExceptions="true"
        convertNoticesToExceptions="true"
        convertWarningsToExceptions="true"
	    >
    <testsuites>
        <testsuite name="unit">
            <directory prefix="" suffix="Test.php">./tests/unit</directory>
        </testsuite>
        <testsuite name="integration">
            <directory prefix="" suffix="Test.php">./tests/integration</directory>
        </testsuite>
        <testsuite name="acceptance">
            <directory prefix="" suffix="Test.php">./tests/acceptance</directory>
        </testsuite>
    </testsuites>
    <listeners>
        <listener class="\ArtOfWP\WP\Testing\BootstrapLoader"></listener>
    </listeners>
</phpunit>
```

Create a bootstrap.php file in the *tests* directory in project root that points to the Composer autoload file.

```php
<?php
$root_dir=dirname(__DIR__);
require $root_dir . '/vendor/autoload.php';

```

Create a bootstrap for each test suite that requires one. For integration tests the following will install WordPress and activate plugins.

```php
<?php
use ArtOfWP\WP\Testing\WP_Bootstrap;
$GLOBALS['wp_tests_options'] = array(
    'active_plugins' => array(
        'my-plugin/my-plugin.php'
    )
);
(new WP_Bootstrap())->run();
```

### Step 4

Depending on your setup just enter *phpunit* or *vendor/bin/phpunit* in the terminal. To run just the unit tests you enter *phpunit --testsuite unit*

## All tests are belong to you now
