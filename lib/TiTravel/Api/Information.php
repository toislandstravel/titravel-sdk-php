<?php
namespace TiTravel\Api;
use TiTravel\Api\Model;
use TiTravel\Api\Property;
use TiTravel\Auth\Credentials;
use TiTravel\Transport\XmlCall;

class Information extends Model
{

  /**
   * @return DefaultYear
   */
  public function getDefaultYear()
  {
    return $this->DefaultYear;
  }

  /**
   * @return array PricelistYears
   */
  public function getPricelistYears()
  {
    return $this->PricelistYears;
  }

  /**
   * Create info from XML
   * @param  \SimpleXMLElement $sxe the API response
   * @return Info
   */
  public function fromXML(\SimpleXMLElement $sxe)
  {
    $this->setData(array(
      'DefaultYear' => (int) $sxe->DefaultYear,
      'PricelistYears' => (array) $sxe->PricelistYears->PricelistYear,
    ));
    return $this;
  }

  /**
   * Get informations about titravel
   *
   * @param  Credentials $credentials API credentials
   */
  public static function get(Credentials $credentials = null)
  {
    if (!empty($credentials)) {
      self::setCredentials($credentials);
    }

    $call = new XmlCall($credentials);
    $sxe = $call->execute("getinfo");
    $ret = new Information();
    $ret->fromXML($sxe);
    return $ret;
  }

}
