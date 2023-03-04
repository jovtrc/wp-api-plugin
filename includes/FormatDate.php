<?php
// phpcs:ignore
namespace Apiplugin;

/**
 * Class responsible to format dates
 * 
 * @category Apiplugin
 * @package  Apiplugin
 * @author   João Carvalho <oi@joaocarvalho.cc>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU Public License 2.0
 * @link     https://github.com/jovtrc/wp-api-plugin
 */
class FormatDate
{
    /**
     * Format the date of the users
     *
     * @param string $date the unformatted date
     * 
     * @return string the formatted date
     */
    public static function doFormatDate($date)
    {
        return gmdate('m/d/Y', $date);
    }
}