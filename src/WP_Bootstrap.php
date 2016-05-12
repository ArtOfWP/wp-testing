<?php
namespace ArtOfWP\WP\Testing;

use ArtOfWP\WP\Testing\Mocking\MockPHPMailer;

class WP_Bootstrap {
    /**
     * @var string
     */
    private static $wordpress_path;
    /**
     * @var string
     */
    private $wordpress_config_file_path;

    /**
     * WP_Bootstrap constructor.
     * @param string $wordpress_path The directory path to WordPress.
     * @param string $wordpress_config_file_path The file path to the config file to use
     */
    public function __construct($wordpress_path, $wordpress_config_file_path) {
        self::$wordpress_path = $wordpress_path;
        $this->wordpress_config_file_path = $wordpress_config_file_path;
    }
    
    public function run() {
        /*
         * Globalize some WordPress variables, because PHPUnit loads this file inside a function
         * See: https://github.com/sebastianbergmann/phpunit/issues/325
         */
        global $wpdb, $current_site, $current_blog, $wp_rewrite, $shortcode_tags, $wp, $phpmailer;

        if ( !is_readable( $this->get_config_file_path() ) ) {
            die( "ERROR: wp-tests-config.php is missing! Please use wp-tests-config-sample.php to create a config file.\n" );
        }
        require_once $this->get_config_file_path();
        /**
         * @var string $table_prefix
         */
        define( 'WP_TESTS_TABLE_PREFIX', $table_prefix );

// Cron tries to make an HTTP request to the blog, which always fails, because tests are run in CLI mode only
        define( 'DISABLE_WP_CRON', true );

        define( 'WP_MEMORY_LIMIT', -1 );
        define( 'WP_MAX_MEMORY_LIMIT', -1 );

        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['HTTP_HOST'] = WP_TESTS_DOMAIN;
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $PHP_SELF = $GLOBALS['PHP_SELF'] = $_SERVER['PHP_SELF'] = '/index.php';

        if ( "1" == getenv( 'WP_MULTISITE' ) ||
            ( defined( 'WP_TESTS_MULTISITE') && WP_TESTS_MULTISITE ) ) {
            $multisite = true;
        } else {
            $multisite = false;
        }

        $phpmailer = new MockPHPMailer();

        system( WP_PHP_BINARY . ' ' . escapeshellarg( dirname( __FILE__ ) . '/install.php' ) . ' ' . escapeshellarg( $this->get_config_file_path() ) . ' ' . $multisite );

        if ( $multisite ) {
            echo "Running as multisite..." . PHP_EOL;
            define( 'MULTISITE', true );
            define( 'SUBDOMAIN_INSTALL', false );
            $GLOBALS['base'] = '/';
        } else {
            echo "Running as single site... To run multisite, use -c tests/phpunit/multisite.xml" . PHP_EOL;
        }
        unset( $multisite );

        require_once dirname( __FILE__ ) . '/functions.php';

        $GLOBALS['_wp_die_disabled'] = false;
        $this->setup_filters();


// Load WordPress
        require_once $this->get_abspath() . '/wp-settings.php';

// Delete any default posts & related data
        _delete_all_posts();
    }
    function wp_tests_options( $value ) {
        $key = substr( current_filter(), strlen( 'pre_option_' ) );
        return $GLOBALS['wp_tests_options'][$key];
    }

    public function setup_filters() {
// Allow tests to override wp_die
        tests_add_filter('wp_die_handler', '_wp_die_handler_filter');

// Preset WordPress options defined in bootstrap file.
// Used to activate themes, plugins, as well as  other settings.
        if (isset($GLOBALS['wp_tests_options'])) {
            foreach (array_keys($GLOBALS['wp_tests_options']) as $key) {
                tests_add_filter('pre_option_' . $key, array($this, 'wp_tests_options'));
            }
        }
    }

    /**
     * @return string
     */
    public function get_config_file_path() {
        return $this->wordpress_config_file_path;
    }

    /**
     * @return string
     */
    public static function get_abspath() {
        return self::$wordpress_path;
    }
}
