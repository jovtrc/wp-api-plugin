<?php
// phpcs:ignore
namespace ApiPlugin;

use ApiPlugin\User;

/**
 * Class responsible to create and render the plugin WP-Admin page
 * 
 * @category Apiplugin
 * @package  Apiplugin
 * @author   João Carvalho <oi@joaocarvalho.cc>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU Public License 2.0
 * @link     https://github.com/jovtrc/wp-api-plugin
 */
class AdminScreen
{
    private $_usersContent;
    private $_cacheKey = 'ApiPlugin_userCache';

    /**
     * Runs the WordPress Hooks
     *
     * @return void
     */
    public function __construct()
    {
        add_action('admin_menu', [$this, 'apipluginCreateAdminMenu']);
        add_action('admin_post_clear_cache', [$this, 'apipluginAdminClearCache']);
    }

    /**
     * Creates the link in the WP-Admin
     *
     * @return void
     */
    public function apipluginCreateAdminMenu()
    {
        $hook = add_menu_page(
            __($this->apipluginGetPageTitle(), 'api-plugin'),
            __($this->apipluginGetPageTitle(), 'api-plugin'),
            'manage_options',
            'apiplugin_list_users',
            [$this, 'apipluginRenderAdminPage']
        );

        add_action("load-$hook", [$this, 'apipluginSetScreenOptions']);
    }

    /**
     * Renders the plugin WP-Admin page
     *
     * @return void
     */
    public function apipluginRenderAdminPage()
    {
        echo '<div class="wrap">';
        echo '<h2>' 
            . esc_html__($this->apipluginGetPageTitle(), 'api-plugin') . 
        '</h2>';

        if (isset($_GET['message'], $_GET['wpnonce'])
            && $_GET['message'] === 'success'
            && wp_verify_nonce(sanitize_key($_GET['wpnonce']), 'clearCacheNonce')
        ) {
            echo '<div class="notice notice-success is-dismissible">';
            echo '<p>' . esc_html__('Cache purged', 'api-plugin') . '</p>';
            echo '</div>';
        }

        echo '<form method="post" action="' 
            . esc_url(admin_url('admin-post.php')) . 
        '">';

        $this->_usersContent->prepare_items();
        $this->_usersContent->display(); 

        echo '<input type="hidden" name="action" value="clear_cache">';
        echo '<input type="submit" class="button" value="'
            . esc_attr__('Clear Cache', 'api-plugin') .
        '">';
        echo '</form>';
        echo '</div>';
    }

    /**
     * Get the title page based on the API content
     *
     * @return void
     */
    public function apipluginGetPageTitle()
    {
        $user = new User;
        $content = $user->apipluginFetchData();

        return $content['title'];
    }

    /**
     * Clears the cache when hitting the Reset Cache button
     *
     * @return void
     */
    public function apipluginAdminClearCache()
    {
        Caching::apipluginDeleteCache($this->_cacheKey);

        $redirectNonce = wp_create_nonce('clearCacheNonce');

        wp_redirect(
            add_query_arg(
                [
                    'message' => 'success',
                    'wpnonce' => $redirectNonce,
                ],
                esc_url(
                    admin_url(
                        'admin.php?page=apiplugin_list_users'
                    )
                )
            )
        );

        exit;
    }

    /**
     * Set the screen options
     *
     * @return void
     */
    public function apipluginSetScreenOptions()
    {
        $this->_usersContent = new AdminTable();
    }
}