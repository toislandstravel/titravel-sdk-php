<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Api\Property;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\XmlCall;

class PartnerNote extends Model
{
    /**
     * Create note from XML
     * @param  \SimpleXMLElement $sxe the API response
     * @return Properties
     */
    public function fromXML(\SimpleXMLElement $sxe)
    {
        foreach ($sxe->children() as $property) {
            if ($property->getName() == 'PartnerNote') {
                $this->note = (string)$property->nodeValue;
                return $this;
            }
        }
        throw new Exception('No partner note found.');
    }

    /**
     * Retrive the partner note in specific language
     * @param  array $params            filter parameters
     * @param  Credentials $credentials API credentials
     * @return PartnerNote  the retreived note
     */
    public static function get(array $params = null, Credentials $credentials = null)
    {
        if (empty($params)) {
            $params = array();
        }
        // prevent loading properties to speed things up
        $params['city_id'] = 0;
        if (!empty($credentials)) {
            self::setCredentials($credentials);
        }
        $allowedParams = array(
            'language' => 1,
            'city_id' => 1,
        );
        $wrongParams = array_diff_key($params, $allowedParams);
        if (!empty($wrongParams)) {
            throw new \InvalidArgumentException('Invalid $params filter: '.implode(', ', array_keys($wrongParams)));
        }

        $call = new XmlCall($credentials);
        $sxe = $call->execute("getproperties&" .
            http_build_query(array_intersect_key($params, $allowedParams)));

        $ret = new PartnerNote();
        $ret->fromXML($sxe);
        return $ret;
    }
}