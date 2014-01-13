<?php
namespace TiTravel\Transport;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\ApiCall;

class XmlCall extends ApiCall
{
    /**
     * Returns the XML response as SimpleXMLElement
     *
     * @param  array $response the XML response
     * @return \SimpleXMLElement
     */
    protected function parseResponse($response)
    {
        // suppress xml errors and try to parse XML
        libxml_use_internal_errors(true);
        if (!($sxe = simplexml_load_string($response['content']))) {
            throw new \Exception('API error: '. $response['content']);
        }
        return $sxe;
    }
}