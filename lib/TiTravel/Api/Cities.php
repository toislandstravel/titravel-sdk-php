<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Api\City;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\XmlCall;

class Cities extends Model
{
    /**
     * Number of cities returned
     * @var integer
     */
    private $count = 0;

    /**
     * Returns the cities count
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Create cities from XML
     * @param  \SimpleXMLElement $sxe the API response
     * @return Properties
     */
    public function fromXML(\SimpleXMLElement $sxe)
    {
        $cities = array();
        $this->count = 0;
        foreach ($sxe->children() as $city) {
            $cat = new City();
            $cat->fromXml($city);
            $cities[] = $cat;
            ++$this->count;
        }
        $this->setData($cities);
        return $this;
    }

    /**
     * Retrive all cities matching the $params filter
     * @param  array $params            filter paramaters (city_id, city_id)
     * @param  Credentials $credentials API credentials
     * @return Properties  the retreived cities
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
        );
        $wrongParams = array_diff_key($params, $allowedParams);
        if (!empty($wrongParams)) {
            throw new \InvalidArgumentException('Invalid $params filter: '.implode(', ', array_keys($wrongParams)));
        }

        $call = new XmlCall($credentials);
        $sxe = $call->execute("getcities&" .
            http_build_query(array_intersect_key($params, $allowedParams)));

        $ret = new Cities();
        $ret->fromXML($sxe);
        return $ret;
    }
}