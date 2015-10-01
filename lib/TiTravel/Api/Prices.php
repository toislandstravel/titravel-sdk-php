<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Api\Price;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\XmlCall;
use TiTravel\Transport\JsonCall;

class Prices extends Model
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
     * Create prices from XML
     * @param  \SimpleXMLElement $sxe the API response
     * @return Properties
     */
    public function fromXML(\SimpleXMLElement $sxe)
    {
        $prices = array();
        $this->count = 0;
        foreach ($sxe->children() as $property) {
            $prop = new Price();
            $prop->fromXml($property);
            $prices[] = $prop;
            ++$this->count;
        }
        $this->setData($prices);
        return $this;
    }

    /**
     * Retrieve all prices matching the $params filter
     * @param  array $params            filter parameters
     * @param  Credentials $credentials API credentials
     * @return Properties  the retreived prices
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
            'year' => null
        );
        $wrongParams = array_diff_key($params, $allowedParams);
        if (!empty($wrongParams)) {
            throw new \InvalidArgumentException('Invalid $params filter: '.implode(', ', array_keys($wrongParams)));
        }

        $call = new XmlCall($credentials);
        $sxe = $call->execute('getprices&' .
            http_build_query(array_intersect_key($params, $allowedParams)));

        $ret = new Prices();
        $ret->fromXML($sxe);
        return $ret;
    }

    /**
     * Retrive vacation price calculation results for a single property
     * @param  array $params            filter parameters
     * @param  Credentials $credentials API credentials
     * @return array  the retreived price calculation
     */
    public static function getPrice(array $params = null, Credentials $credentials = null)
    {
        if (empty($params)) {
            $params = array();
        }
        if (!empty($credentials)) {
            self::setCredentials($credentials);
        }
        $allowedParams = array(
            'language' => 1,
            'property_id' => 1,
            'arrival_date' => 1,
            'departure_date' => 1,
            'adults' => 1,
            'children_ages' => 1,
            'pets' => 1,
        );
        $wrongParams = array_diff_key($params, $allowedParams);
        if (!empty($wrongParams)) {
            throw new \InvalidArgumentException('Invalid $params filter: '.implode(', ', array_keys($wrongParams)));
        }

        $call = new JsonCall($credentials);
        return $call->execute('getPrice&format=json&' .
            http_build_query(array_intersect_key($params, $allowedParams)));
    }
}
