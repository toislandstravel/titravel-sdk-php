<?php
namespace TiTravel\Api;
use TiTravel\Auth\Credentials;

abstract class Model
{
    /**
     * TiTravel API credentials
     * @var TiTravel\Api\Credentials
     */
    private static $credentials;

    /**
     * Set API credentials.
     * @param TiTravel\Api\Credentials $credentials
     */
    public static function setCredentials(Credentials $credentials)
    {
        self::$credentials = $credentials;
    }

    /**
     * Returns API credentials.
     * @return TiTravel\Api\Credentials $credentials
     */
    public static function getCredentials()
    {
        return self::$credentials;
    }
}