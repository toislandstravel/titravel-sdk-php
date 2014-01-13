<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Api\Compensation;
use TiTravel\Api\CompensationCode;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\XmlCall;

class Compensations extends Model
{
    /**
     * Number of compensations returned
     * @var integer
     */
    private $count = 0;

    /**
     * Returns the compensations count
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Create compensations from XML
     * @param  \SimpleXMLElement $sxe the API response
     * @return Properties
     */
    public function fromXML(\SimpleXMLElement $sxe)
    {
        $compensations = array();
        $this->count = 0;
        foreach ($sxe->children() as $compensation) {
            $cat = $compensation->getName() == 'Compensation' ?
                new Compensation() : new CompensationCode();
            $cat->fromXml($compensation);
            $compensations[$cat instanceof CompensationCode ? 'codes' : 'compensations'][] = $cat;
            ++$this->count;
        }
        $this->setData($compensations);
        return $this;
    }

    /**
     * Retrive all compensations matching the $params filter
     * @param  array $params            filter paramaters (city_id, compensation_id)
     * @param  Credentials $credentials API credentials
     * @return Properties  the retreived compensations
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
        $sxe = $call->execute('getcompensations&' .
            http_build_query(array_intersect_key($params, $allowedParams)));

        $ret = new Compensations();
        $ret->fromXML($sxe);
        return $ret;
    }
}