<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Auth\Credentials;

class Properties extends Model
{

    public static function get(array $params = null, Credentials $credentials = null)
    {
        if (empty($params)) {
            $params = array();
        }
        if (!empty($credentials)) {
            self::setCredentials($credentials);
        }
        $allowedParams = array(
            'city_id' => 1,
            'category_id' => 1,
        );
        $wrongParams = array_diff_key($params, $allowedParams);
        if (!empty($wrongParams)) {
            throw new \InvalidArgumentException('Invalid $params filter: '.implode(', ', array_keys($wrongParams)));
        }

        return array();
    }
}