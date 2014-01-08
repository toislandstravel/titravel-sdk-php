<?php
namespace TiTravel\Api;
use TiTravel\Auth\Credentials;

abstract class Model
{
    /**
     * TiTravel API credentials
     * @var TiTravel\Api\Credentials
     */
    private static $credentials;

    /**
     * The model response data
     * @var array
     */
    private $_data = array();

    public function __get($key)
    {
        return $this->_data[$key];
    }

    public function __set($key, $value) {
        $this->_data[$key] = $value;
    }

    public function __isset($key) {
        return isset($this->_data[$key]);
    }

    public function __unset($key) {
        unset($this->_data[$key]);
    }

    /**
     * Returns the results as array
     * @return array the results
     */
    public function toArray() {
        return $this->_convertToArray($this->_data);
    }

    /**
     * Returns the $param as array
     * @param  mixed $param
     * @return array
     */
    private function _convertToArray($param) {
        $ret = array();
        foreach($param as $k => $v) {
            if($v instanceof Model) {
                $ret[$k] = $v->toArray();
            } else if (is_array($v)) {
                $ret[$k] = $this->_convertToArray($v);
            } else {
                $ret[$k] = $v;
            }
        }
        return $ret;
    }

    /**
     * Set API credentials.
     * @param TiTravel\Api\Credentials $credentials
     */
    public static function setCredentials(Credentials $credentials)
    {
        self::$credentials = $credentials;
    }

    /**
     * Returns API credentials.
     * @return TiTravel\Api\Credentials $credentials
     */
    public static function getCredentials()
    {
        return self::$credentials;
    }
}