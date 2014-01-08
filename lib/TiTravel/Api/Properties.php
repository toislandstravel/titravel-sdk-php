<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Api\Property;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\XmlCall;

class Properties extends Model
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
            $prop = new Property();
            $prop->fromXml($property);
            $properties[] = $prop;
            ++$this->count;
        }
        $this->setData($properties);
        return $this;
    }

    /**
     * Retrive all property details matching the $params filter.
     * Results are paginated at 500 per response
     * $params['page'] is the page number
     *
     * @param  array $params            filter paramaters
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
            'page' => 1,
            'city_id' => 1,
            'category_id' => 1,
            'property_id' => 1,
            'property_ids' => 1,
            'range' => 1,
        );
        $wrongParams = array_diff_key($params, $allowedParams);
        if (!empty($wrongParams)) {
            throw new \InvalidArgumentException('Invalid $params argument keys: '.implode(', ', array_keys($wrongParams)));
        }

        $call = new XmlCall($credentials);
        $sxe = $call->execute("getproperty&" .
            http_build_query(array_intersect_key($params, $allowedParams)));

        $ret = new Properties();
        $ret->fromXML($sxe);
        return $ret;
    }
}