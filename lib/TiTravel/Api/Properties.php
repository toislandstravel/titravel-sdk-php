<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Api\Property;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\XmlCall;

class Properties extends Model
{
    /**
     * Total number of properties
     * @var integer
     */
    private $countTotal = 0;

    /**
     * Number of properties on current page
     * @var integer
     */
    private $count = 0;

    /**
     * Maximum number of properties per page
     * @var integer
     */
    private $maxPropertiesPerPage = 1;

    /**
     * Page retreived
     * @var integer
     */
    private $page = 0;

    /**
     * Page retreived
     * @var integer
     */
    private $pageMax = 0;

    /**
     * Maximum number of properties per page
     * @var integer
     */
    private $maxResultsPerPage = 100;

    /**
     * Returns the properties count
     * @return int
     */
    public function getCountTotal()
    {
        return $this->countTotal;
    }

    /**
     * Returns the properties count
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Returns the current properties page
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Returns the maximum available results page
     * @return int
     */
    public function getPageMax()
    {
        return $this->pageMax;
    }

    /**
     * Returns the maximum available results per page
     * @return int
     */
    public function getResultsPerPageLimit()
    {
        return $this->maxResultsPerPage;
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
        $this->countTotal = $sxe['results_count'];
        $this->page = $sxe['page'];
        $this->pageMax = $sxe['page_max'];
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
     * Retrieve all property details matching the $params filter.
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