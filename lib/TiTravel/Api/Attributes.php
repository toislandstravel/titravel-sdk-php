<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Api\Attribute;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\XmlCall;

class Attributes extends Model
{
    /**
     * Number of attributes returned
     * @var integer
     */
    private $count = 0;

    /**
     * Returns the attributes count
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Create attributes from XML
     * @param  \SimpleXMLElement $sxe the API response
     * @return Properties
     */
    public function fromXML(\SimpleXMLElement $sxe)
    {
        $attributes = array();
        $this->count = 0;
        foreach ($sxe->children() as $attribute) {
            $att = new Attribute();
            $att->fromXml($attribute);
            $attributes[] = $att;
            ++$this->count;
        }
        $this->setData($attributes);
        return $this;
    }

    /**
     * Retrive all attributes matching the $params filter
     * @param  array $params            filter parameters
     * @param  Credentials $credentials API credentials
     * @return Properties  the retreived attributes
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
            'category_id' => 1,
        );
        $wrongParams = array_diff_key($params, $allowedParams);
        if (!empty($wrongParams)) {
            throw new \InvalidArgumentException('Invalid $params filter: '.implode(', ', array_keys($wrongParams)));
        }

        $call = new XmlCall($credentials);
        $sxe = $call->execute("attributes&" .
            http_build_query(array_intersect_key($params, $allowedParams)));

        $ret = new Attributes();
        $ret->fromXML($sxe);
        return $ret;
    }
}