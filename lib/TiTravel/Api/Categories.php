<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Api\Category;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\XmlCall;

class Categories extends Model
{
    /**
     * Number of categories returned
     * @var integer
     */
    private $count = 0;

    /**
     * Returns the categories count
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Create categories from XML
     * @param  \SimpleXMLElement $sxe the API response
     * @return Properties
     */
    public function fromXML(\SimpleXMLElement $sxe)
    {
        $categories = array();
        $this->count = 0;
        foreach ($sxe->children() as $category) {
            $cat = new Category();
            $cat->fromXml($category);
            $categories[] = $cat;
            ++$this->count;
        }
        $this->setData($categories);
        return $this;
    }

    /**
     * Retrive all categories matching the $params filter
     * @param  array $params            filter paramaters (city_id, category_id)
     * @param  Credentials $credentials API credentials
     * @return Properties  the retreived categories
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
        $sxe = $call->execute("getcategories&" .
            http_build_query(array_intersect_key($params, $allowedParams)));

        $ret = new Categories();
        $ret->fromXML($sxe);
        return $ret;
    }
}