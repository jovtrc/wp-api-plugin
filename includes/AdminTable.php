<?php
// phpcs:ignore
namespace ApiPlugin;

if (!class_exists('WP_List_Table')) {
    include_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

use \ApiPlugin\User;

/**
 * Class responsible to manage the list of users and prepare them to be displayed
 * 
 * @category Apiplugin
 * @package  Apiplugin
 * @author   João Carvalho <oi@joaocarvalho.cc>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU Public License 2.0
 * @link     https://github.com/jovtrc/wp-api-plugin
 */
class AdminTable extends \WP_List_Table
{
    private $_user;

    /**
     * Defines the names of the table
     */
    public function __construct()
    {
        $this->_user = new User;

        parent::__construct(
            [
                'singular' => __('User', 'api-plugin'),
                'plural'   => __('Users', 'api-plugin'),
                'ajax'     => false
            ]
        );
    }

    /**
     * Retrieve customers data from the API
     *
     * @return array
     */
    public function apipluginRetrieveData()
    {
        $result = $this->_user->apipluginFetchData();

        return $result['data']['rows'];
    }

    /**
     * Render the columns items
     *
     * @param array  $table      all the elements of the table
     * @param string $columnName identification of the column
     *
     * @return mixed
     */
    public function column_default($table, $columnName) // phpcs:ignore
    {
        return $table[$columnName];
    }

    /**
     *  Associates all columns available
     *
     * @return array
     */
    public function get_columns() // phpcs:ignore
    {
        $columns = [];

        $fields = $this->_user->apipluginGetFields();

        foreach ($fields as $field => $header) {
            $columns[$field] = __($header, 'api-plugin');
        }

        return $columns;
    }

    /**
     * Prepares the content to be displayed.
     * 
     * @return void
     */
    public function prepare_items() // phpcs:ignore
    {
        $this->items = $this->apipluginRetrieveData();
    }
}