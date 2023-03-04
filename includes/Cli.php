<?php
// phpcs:ignore
namespace ApiPlugin;

use \WP_CLI;
use ApiPlugin\Caching;

/**
 * Class responsible to register and manage the WP-CLI commands
 * 
 * @category Apiplugin
 * @package  Apiplugin
 * @author   João Carvalho <oi@joaocarvalho.cc>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU Public License 2.0
 * @link     https://github.com/jovtrc/wp-api-plugin
 */
class Cli
{
    private $_cacheKey = 'ApiPlugin_userCache';

    /**
     * Runs the register command function when WP-CLI is initiated
     * 
     * @return void
     */
    public function __construct()
    {
        add_action('cli_init', [$this, 'apipluginRegisterCliCommand']);
    }

    /**
     * Register the clear cache command on WP-CLI
     * 
     * @return void
     */
    public function apipluginRegisterCliCommand()
    {
        WP_CLI::add_command('clear_users_cache', [$this, 'apipluginClearCommand']);
    }

    /**
     * Clears the users cache
     * 
     * @return void
     */
    public function apipluginClearCommand()
    {
        WP_CLI::line(__('Cleaning cache...', 'api-plugin'));
        Caching::apipluginDeleteCache($this->_cacheKey);
        WP_CLI::line(__('Done!', 'api-plugin'));
    }
}