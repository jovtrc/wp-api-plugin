<?php
// phpcs:ignore
namespace ApiPlugin;

use ApiPlugin\Caching;
use Apiplugin\FormatDate;

/**
 * Class responsible to get the info of the users
 * 
 * @category Apiplugin
 * @package  Apiplugin
 * @author   João Carvalho <oi@joaocarvalho.cc>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU Public License 2.0
 * @link     https://github.com/jovtrc/wp-api-plugin
 */
class User
{
    private $_callUrl = 'https://miusage.com/v1/challenge/1/';
    private $_cacheKey = 'ApiPlugin_userCache';

    /**
     * Gets the data from the API
     *
     * @return array
     */
    public function apipluginFetchData()
    {
        $data = Caching::apipluginGetCache($this->_cacheKey);

        if (!$data) {
            $request = wp_safe_remote_get($this->_callUrl);

            if (is_wp_error($request)) {
                return false;
            }

            $data = wp_remote_retrieve_body($request);
            Caching::apipluginSetCache($data, $this->_cacheKey);
        }

        $formattedData = $this->apipluginPrepareToFormat($data);

        return $formattedData;
    }

    /**
     * Gets the headers and fields of the content
     *
     * @return array
     */
    public function apipluginGetFields()
    {
        $data = $this->apipluginFetchData();

        $headers = $data['data']['headers'];
        $fields = $data['data']['rows']['1'];

        $headersAndFields = array_combine(
            array_keys($fields),
            $headers
        );

        return $headersAndFields;
    }

    /**
     * Format the date of the users
     *
     * @param string $unformattedData the api data without format
     * 
     * @return array
     */
    public function apipluginPrepareToFormat($unformattedData)
    {
        $formattedData = json_decode($unformattedData, true);

        // Format rows date
        foreach ($formattedData['data']['rows'] as $index => $row) {
            $formattedDate = FormatDate::doFormatDate($row['date']);
            $formattedData['data']['rows'][$index]['date'] = $formattedDate;
        }

        return $formattedData;
    }
}