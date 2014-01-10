<?php
namespace TiTravel\Transport;
use TiTravel\Auth\Credentials;

abstract class ApiCall
{
    private $apiCredentials;
    private $endpointUrl;

    /**
     * Construct new XML API call using the credentials
     * provided
     *
     * @param Credentials $apiCredentials
     * @param string $endpointUrl the API endpoint URL
     */
    public function __construct(Credentials $apiCredentials, $endpointUrl = null)
    {
        $this->apiCredentials = $apiCredentials;
        if (!empty($endpointUrl)) {
            $this->endpointUrl = $endpointUrl;
        }
        return $this;
    }

    /**
     * Returns the API endpoint URL.
     * If the URL is not set, uses the one
     * from Constants
     *
     * @return string API endpoint URL
     */
    public function getEndpointUrl()
    {
        if (empty($this->endpointUrl)) {
            $this->endpointUrl = \TiTravel\Constants::API_LIVE_ENDPOINT;
        }
        return "{$this->endpointUrl}&".$this->getCredentialsUrlParams().'&action=';
    }

    private function getCredentialsUrlParams()
    {
        if (!($this->apiCredentials instanceof Credentials)) {
            throw new Exception('API credentials not set.');
        }
        return http_build_query($this->apiCredentials->getArray());
    }

    public function getURL($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * Execute API call and return the XML response as SimpleXMLElement
     *
     * @param string $path   Resource path relative to base service endpoint
     * @param string $method HTTP method - one of GET, POST, PUT, DELETE, PATCH etc
     * @return SimpleXMLElement
     */
    public function execute($path, $method = 'GET')
    {
        $response = $this->getURL($this->getEndpointUrl().$path);
        // API returns empty string on invalid credentials
        if (empty($response)) {
            throw new \Exception('API credentials invalid');
        }

        return $this->parseResponse($response);
    }

    /**
     * Returns the parsed response
     */
    abstract protected function parseResponse($response);
}