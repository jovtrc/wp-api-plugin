<?php

/**
 * Plugin Name:       API Plugin
 * Description:       A simple WordPress plugin that fetches and manages API.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            João Carvalho
 * Author URI:        https://joaocarvalho.cc
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       api-plugin
 *
 * @category Apiplugin
 * @package  Apiplugin
 * @author   João Carvalho <oi@joaocarvalho.cc>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU Public License 2.0
 * @link     https://github.com/jovtrc/wp-api-plugin
 */

require_once plugin_dir_path(__FILE__) . '/includes/vendor/autoload.php';

/**
 * Register the block. Block configs available inside frontend/block.json.
 * 
 * @return void
 */
function Apiplugin_registerBlock(): void
{
    register_block_type(__DIR__ . '/build');
}
add_action('init', 'Apiplugin_registerBlock');

/**
 * Initiates i18n.
 * 
 * @return void
 */
function apipluinInit()
{
    $plugin_rel_path = basename(dirname(__FILE__)) . '/languages';
    load_plugin_textdomain('api-plugin', false, $plugin_rel_path);
}
add_action('plugins_loaded', 'apipluinInit');


// Load classes
new \ApiPlugin\Api;
new \ApiPlugin\AdminScreen;
new \ApiPlugin\Cli;
new \ApiPlugin\FormatDate;