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

    /**
     * Returns the URL headers and content as associative array
     * @param  string $url URL to grab
     * @return array
     */
    public function getURL($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        $ret = array(
            'header' => mb_substr($response, 0, $info['header_size']),
            'content' => mb_substr($response, -$info['download_content_length']),
        );
        curl_close($curl);
        return $ret;
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
        // API returns empty content and no redirect on invalid credentials
        if (empty($response['content']) && mb_strpos('location:', strtolower($response['header'])) === false) {
            throw new \Exception('API credentials invalid');
        }

        return $this->parseResponse($response);
    }

    /**
     * Returns the parsed response
     */
    abstract protected function parseResponse($response);
}