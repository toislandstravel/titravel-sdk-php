<?php
namespace TiTravel\Transport;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\ApiCall;

class HeaderCall extends ApiCall
{
    /**
     * Returns the headers
     *
     * @param  array $response the response
     * @return array
     */
    protected function parseResponse($response)
    {
        return $response['header'];
    }
}