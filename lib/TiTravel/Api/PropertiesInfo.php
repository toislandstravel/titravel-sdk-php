<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Api\Property;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\XmlCall;

class PropertiesInfo extends Model
{
    /**
     * Number of properties returned
     * @var integer
     */
    private $count = 0;

    /**
     * Returns the properties count
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Create properties from XML
     * @param  \SimpleXMLElement $sxe the API response
     * @return Properties
     */
    public function fromXML(\SimpleXMLElement $sxe)
    {
        $properties = array();
        $this->count = 0;
        foreach ($sxe->children() as $property) {
            if ($property->getName() == 'PartnerNote') {
                continue;
            }

            $prop = new Property();
            $prop->fromXml($property);
            $properties[] = $prop;
            ++$this->count;
        }
        $this->setData($properties);
        return $this;
    }

    /**
     * Retrive all properties matching the $params filter
     * @param  array $params            filter paramaters (city_id, category_id)
     * @param  Credentials $credentials API credentials
     * @return Properties  the retreived properties
     */
    public static function all(array $params = null, Credentials $credentials = null)
    {
        if (empty($params)) {
            $params = array();
        }
        if (!empty($credentials)) {
            self::setCredentials($credentials);
        }
        $allowedParams = array(
            'language' => 1,
            'city_id' => 1,
            'category_id' => 1,
        );
        $wrongParams = array_diff_key($params, $allowedParams);
        if (!empty($wrongParams)) {
            throw new \InvalidArgumentException('Invalid $params filter: '.implode(', ', array_keys($wrongParams)));
        }

        $call = new XmlCall($credentials);
        $sxe = $call->execute("getproperties&" .
            http_build_query(array_intersect_key($params, $allowedParams)));

        $ret = new PropertiesInfo();
        $ret->fromXML($sxe);
        return $ret;
    }
}