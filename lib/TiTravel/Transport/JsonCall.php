<?php
namespace TiTravel\Transport;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\ApiCall;

class JsonCall extends ApiCall
{
    /**
     * Returns the decoded JSON response
     *
     * @param  array $response the JSON encoded response
     * @return mixed
     */
    protected function parseResponse($response)
    {
        if (($decodedResponse = json_decode($response['content'], true)) === false) {
            throw new \Exception('API error: '. $response['content']);
        }
        return $decodedResponse;
    }
}