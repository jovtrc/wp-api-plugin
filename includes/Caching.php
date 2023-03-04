<?php
// phpcs:ignore
namespace ApiPlugin;

/**
 * Class responsible to manage the caching of the plugin
 * 
 * @category Apiplugin
 * @package  Apiplugin
 * @author   João Carvalho <oi@joaocarvalho.cc>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU Public License 2.0
 * @link     https://github.com/jovtrc/wp-api-plugin
 */
class Caching
{
    /**
     * Gets the cache
     *
     * @param string $cacheKey the cache identity
     *
     * @return mixed
     */
    public static function apipluginGetCache($cacheKey)
    {
        return get_transient($cacheKey);
    }

    /**
     * Creates the cache
     *
     * @param mixed  $data     the data to be cached
     * @param string $cacheKey the cache identity
     *
     * @return bool
     */
    public static function apipluginSetCache($data, $cacheKey)
    {
        $userCache = set_transient(
            $cacheKey,
            $data,
            3600
        );

        return $userCache;
    }

    /**
     * Deletes the cache
     *
     * @param string $cacheKey the cache identity
     *
     * @return bool
     */
    public static function apipluginDeleteCache($cacheKey)
    {
        $deletedCache = delete_transient(
            $cacheKey,
        );

        return $deletedCache;
    }
}