<?php

namespace TiTravel\Auth;

/**
 * Titravel API's username & password credentials
 *
 */
class Credentials
{

    /**
     * Client b2b ID id obtained from To Islands Travel
     * @var int
     */
    private $b2b;

    /**
     * Client API access code obtained from To Islands Travel
     * @var string
     */
    private $code;

    /**
     * @param int $b2b  Client b2b ID id obtained from To Islands Travel
     * @param [type] $code Client API access code obtained from To Islands Travel
     */
    public function __construct($b2b, $code)
    {
        $this->b2b = $b2b;
        $this->code = $code;
    }

    /**
     * Returns the code
     * @return string Client API authorization code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Returns the B2B client id
     * @return string Client B2B id
     */
    public function getB2B()
    {
        return $this->b2b;
    }
}