<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\XmlCall;
use TiTravel\Transport\JsonCall;

class Actions extends Model
{
    private $count = 0;

    public function getCount()
    {
        return $this->count;
    }

    public static function all(array $params = null, Credentials $credentials = null)
    {
        if (empty($params)) {
            $params = array();
        }

        if (!empty($credentials)) {
            self::setCredentials($credentials);
        }
        
        $allowedParams = array(
            "offset" => 0,
            "limit" => 100,
            "ids" => array()
        );
        
        $wrongParams = array_diff_key($params, $allowedParams);
        if (!empty($wrongParams)) {
            throw new \InvalidArgumentException("Invalid $params filter: " . implode(', ', array_keys($wrongParams)));
        }

        $call = new JsonCall($credentials);
        return $call->execute("getpopusti" . "&" . http_build_query(array_intersect_key($params, $allowedParams)) );

    }

    public static function apiCount(array $params = null, Credentials $credentials = null)
    {
        if (empty($params)) {
            $params = array();
        }

        if (!empty($credentials)) {
            self::setCredentials($credentials);
        }
        
        $allowedParams = array(
            "ids" => array()
        );

        $wrongParams = array_diff_key($params, $allowedParams);
        if (!empty($wrongParams)) {
            throw new \InvalidArgumentException("Invalid $params filter: " . implode(', ', array_keys($wrongParams)));
        }

        $call = new JsonCall($credentials);
        return $call->execute("getpopusti_count" . "&" . http_build_query(array_intersect_key($params, $allowedParams)) );

    }

}
