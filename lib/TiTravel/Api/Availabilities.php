<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Api\Availability;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\XmlCall;

class Availabilities extends Model
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
     * Create availabilties from XML
     * @param  \SimpleXMLElement $sxe the API response
     * @return Properties
     */
    public function fromXML(\SimpleXMLElement $sxe)
    {
        $availabilties = array();
        $this->count = 0;
        foreach ($sxe->children() as $property) {
            $prop = new Availability();
            $prop->fromXml($property);
            $availabilties[] = $prop;
            ++$this->count;
        }
        $this->setData($availabilties);
        return $this;
    }

    /**
     * Retrive all availabilties matching the $params filter
     * @param  array $params            filter parameters
     * @param  Credentials $credentials API credentials
     * @return Properties  the retreived availabilties
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
            'page' => 1,
            'city_id' => 1,
            'category_id' => 1,
            'property_id' => 1,
            'property_ids' => 1,
            'range' => 1,
        );
        $wrongParams = array_diff_key($params, $allowedParams);
        if (!empty($wrongParams)) {
            throw new \InvalidArgumentException('Invalid $params filter: '.implode(', ', array_keys($wrongParams)));
        }

        $call = new XmlCall($credentials);
        $sxe = $call->execute('getavailability&' .
            http_build_query(array_intersect_key($params, $allowedParams)));

        $ret = new Availabilities();
        $ret->fromXML($sxe);
        return $ret;
    }
}