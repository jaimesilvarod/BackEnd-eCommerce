<?php namespace Config;

use CodeIgniter\Events\Events;

/**
 * -------------------------------------------------------------------
 * SYSTEM CONFIGURATION
 * -------------------------------------------------------------------
 * This file defines the system settings used by the CodeIgniter system.
 *
 * @see  https://codeigniter.com/user_guide/installation/index.html
 * @author  CodeIgniter Framework Development Team
 * @license  https://opensource.org/licenses/MIT  MIT License
 * @copyright  Copyright (c) 2017 - 2021, British Columbia Institute of Technology
 * @version  4.1.3
 * @filesource
 */

// --------------------------------------------------------------------

/**
 * This file lets you define settings that will be used when running tests.
 *
 * The settings defined here are used by the test harness to bootstrap
 * your application, as well as run your tests. You can override what
 * is in this file by setting the ENVIRONMENT variable in your terminal
 * before running tests, or by changing the testEnvironment property
 * in the ./phpunit.xml file.
 */

if (!isset($_SERVER['CI_ENVIRONMENT'])) {
    exit('No direct script access allowed');
}

use CodeIgniter\Config\BaseConfig;

class Boot
{
    /**
     * Handles reporting and displaying errors.
     *
     * @param BaseConfig $config
     */
    public static function report_all_php_errors(BaseConfig $config)
    {
        if (ENVIRONMENT !== 'production') {
            error_reporting(-1);
            ini_set('display_errors', '1');
        } else {
            error_reporting(0);
            ini_set('display_errors', '0');
        }

        // Handle all errors the same
        set_error_handler([$config->error, 'logError']);
        set_exception_handler([$config->error, 'logException']);
        register_shutdown_function([$config->error, 'shutdownHandler']);

        // Send error details to CodeIgniter\Log\Log
        ini_set('log_errors', '1');
        ini_set('error_log', WRITEPATH . 'logs/' . date('Y-m-d') . '-error.log');

        // Start the Benchmark
        $config->benchmark = new \CodeIgniter\Debug\Timer();
        $config->benchmark->start('total_execution_time');
    }

    //--------------------------------------------------------------------

    /**
     * Initializes framework setup.
     *
     * @param BaseConfig $config
     */
    public static function init(BaseConfig $config)
    {
        $config->sanitizeGlobals();

        // Set default locale
        if (!ini_get('date.timezone')) {
            date_default_timezone_set('UTC');
        }

        mb_substitute_character('none');

        // Disable magic quotes - this feature has been removed in PHP 5.4
        if (version_compare(PHP_VERSION, '5.4', '<')) {
            ini_set('magic_quotes_runtime', 0);
            ini_set('magic_quotes_sybase', 0);
        }

        if (ini_get('zlib.output_compression') !== 'Off' || ini_get('output_handler')) {
            throw new \Exception('CI4 Requires zlib.output_compression = Off and no output_handler in php.ini.');
        }

        // Start Benchmark
        $config->benchmark->start('total_execution_time');

        // Events system
        Events::initialize($config);

        // Initialize Services
        \Config\Services::init();
    }
}
