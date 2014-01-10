<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Api\Price;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\XmlCall;
use TiTravel\Transport\JsonCall;

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

        $call = new JsonCall($credentials);
        return $call->execute('setreservation&format=json&' .
            http_build_query(array_intersect_key($params, $allowedParams)));
    }
}