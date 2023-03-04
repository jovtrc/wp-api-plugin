<?php
// phpcs:ignore
namespace ApiPlugin;

use \WP_REST_Response;
use ApiPlugin\User;

/**
 * Class responsible to generate the plugin API
 * 
 * @category Apiplugin
 * @package  Apiplugin
 * @author   João Carvalho <oi@joaocarvalho.cc>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU Public License 2.0
 * @link     https://github.com/jovtrc/wp-api-plugin
 */
class Api
{
    /**
     * Runs the WordPress Hooks
     *
     * @return void
     */
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'apipluginCreateApiRoute']);
    }

    /**
     * Creates the API endpoint
     *
     * @return void
     */
    public function apipluginCreateApiRoute()
    {
        register_rest_route(
            'joaocarvalho/v1', '/users', 
            [
                'methods' => 'GET',
                'callback' => [$this, 'apipluginReturnApiResponse'],
                'permission_callback' => ''
            ]
        );
    }

    /**
     * Returns the data to the API
     *
     * @return \WP_REST_Response
     */
    public function apipluginReturnApiResponse()
    {
        $user = new User;
        $apiData = $user->apipluginFetchData();
        $response = new WP_REST_Response($apiData);
        $response->set_status(200);

        return $response;
    }
}
