<?php

/**
 * Super-simple, minimum abstraction MailChimp API v3 wrapper
 *
 * Uses curl if available, falls back to file_get_contents and HTTP stream.
 * This probably has more comments than code.
 *
 * @author Drew McLellan <drew.mclellan@gmail.com> Michael Minor <me@pixelbacon.com> Daniel Boorn <daniel.boorn@gmail.com>
 * @version 3.0
 */
class MailChimp
{
    /**
     * @var string
     */
    private $apiKey;
    /**
     * @var string
     */
    private $apiEndpoint = 'https://<dc>.api.mailchimp.com/3.0';
    /**
     * @var bool
     */
    private $verifySsl = false;

    /**
     * MailChimp constructor.
     * @param $apiKey
     */
    function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $parts = explode('-', $this->apiKey);
        $this->apiEndpoint = str_replace('<dc>', end($parts), $this->apiEndpoint);
    }

    /**
     * Generic HTTP request
     *
     * @param $method
     * @param array $args
     * @param string $verb
     * @return bool|mixed
     */
    public function call($method, $args = array(), $verb = 'POST')
    {
        return $this->rawRequest($method, $args, $verb);
    }

    /**
     * GET HTTP request
     *
     * @param $method
     * @param array $args
     * @return bool|mixed
     */
    public function get($method, $args = array())
    {
        return $this->call($method, $args, 'GET');
    }

    /**
     * POST HTTP request
     *
     * @param $method
     * @param array $args
     * @return bool|mixed
     */
    public function post($method, $args = array())
    {
        return $this->call($method, $args);
    }

    /**
     * PUT HTTP Request
     *
     * @param $method
     * @param array $args
     * @return bool|mixed
     */
    public function put($method, $args = array())
    {
        return $this->call($method, $args, 'PUT');
    }

    /**
     * PATCH HTTP Request
     *
     * @param $method
     * @param array $args
     * @return bool|mixed
     */
    public function patch($method, $args = array())
    {
        return $this->call($method, $args, 'PATCH');
    }

    /**
     * DELETE HTTP Request
     *
     * @param $method
     * @param array $args
     * @return bool|mixed
     */
    public function delete($method, $args = array())
    {
        return $this->call($method, $args, 'DELETE');
    }

    /**
     * Fetch response from MailChimp API
     *
     * @param $method
     * @param array $args
     * @param string $verb
     * @return bool|mixed
     */
    private function rawRequest($method, $args = array(), $verb = 'POST')
    {

        $url = $this->apiEndpoint . '/' . $method;

        $json = json_encode($args);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode("anystring:{$this->apiKey}"),
            'Connection: close',
            'Content-length: ' . strlen($json)
        );

        $result = @file_get_contents($url, null, stream_context_create(array(
            'http' => array(
                'method'  => $verb,
                'header'  => implode("\r\n", $headers) . "\r\n",
                'content' => $json,
                'timeout' => 60.0,
            ),
            'ssl'  => array(
                'verify_peer' => $this->verifySsl,
            )
        )));

        return $result !== false ? json_decode($result, true) : false;
    }

}
