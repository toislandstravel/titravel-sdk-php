<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Api\Price;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\HeaderCall;

class Reservation extends Model
{
    const TYPE_INQUIRY = 'i';
    const TYPE_RESERVATION = 'r';

    /**
     * Send a reservation or inquiry for a property
     *
     * @param  array $params            parameters
     * @param  Credentials $credentials API credentials
     * @return Properties  the retreived prices
     */
    public static function send(array $params = null, Credentials $credentials = null)
    {
        if (empty($params)) {
            $params = array();
        }
        if (!empty($credentials)) {
            self::setCredentials($credentials);
        }
        $allowedParams = array(
            'language' => 1,
            'data' => 1,
            'property_id' => 1,
        );
        $wrongParams = array_diff_key($params, $allowedParams);
        if (!empty($wrongParams)) {
            throw new \InvalidArgumentException('Invalid $params filter: '.implode(', ', array_keys($wrongParams)));
        }

        $call = new HeaderCall($credentials);
        $redirectUrl = self::getHeaderLocation($call->execute('setreservation&format=json&' .
            http_build_query(array_intersect_key($params, $allowedParams))));
        parse_str(parse_url($redirectUrl, PHP_URL_QUERY), $params);
        if (!isset($params['reservation_code'])) {
            throw new \Exception('No valid response code in reservation return_url: '.$redirectUrl);
        }
        $code = $params['reservation_code'];
        if (mb_strtolower($code) != 'ok') {
            throw new \Exception('Send reservation validation error code: '.$code);
        }
        return $redirectUrl;
    }

    /**
     * Returns the Location: header URL
     * @param  string $header response headers
     * @return string URL or empty string
     */
    public static function getHeaderLocation($header)
    {
        preg_match_all('/^Location:(.*)$/mi', $header, $matches);
        return !empty($matches[1]) ? trim($matches[1][0]) : '';
    }
}