<?php

namespace Bannerbear;

class Api
{
    /** @var \CurlHandle */
    private $client;
    /** @var string */
    protected $url;

    /**
     * @param array<int,string> $headers
     */
    public function __construct(string $url, array $headers = [])
    {
        $curlClient = curl_init();
        curl_setopt_array($curlClient, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_FAILONERROR => true,
        ]);
        $this->client = $curlClient;
        $this->url = $url;
        return $this;
    }

    private function getUrl(string $url)
    {
        return $this->url . $url;
    }

    public function get(string $url)
    {
        curl_setopt($this->client, CURLOPT_URL, $this->getUrl($url));

        /** @var string $res */
        $res = curl_exec($this->client);

        if (curl_errno($this->client)) {
            $error_msg = curl_error($this->client);
            $status = curl_getinfo($this->client, CURLINFO_RESPONSE_CODE);
        }

        curl_close($this->client);

        if (isset($error_msg)) {
            throw new \Exception('Bannerbear Error Status: ' . $status . '. Message: ' . $error_msg);
        }

        return json_decode($res, true);
    }

    /**
     * @param array<string,mixed> $params
     */
    public function patch(string $url, array $params)
    {
        curl_setopt($this->client, CURLOPT_URL, $this->getUrl($url));
        curl_setopt($this->client, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($this->client, CURLOPT_POSTFIELDS, json_encode($params));

        /** @var string $res */
        $res = curl_exec($this->client);

        if (curl_errno($this->client)) {
            $error_msg = curl_error($this->client);
            $status = curl_getinfo($this->client, CURLINFO_RESPONSE_CODE);
        }

        curl_close($this->client);

        if (isset($error_msg)) {
            throw new \Exception('Bannerbear Error Status: ' . $status . '. Message: ' . $error_msg);
        }

        return json_decode($res, true);
    }

    /**
     * @param array<string,mixed> $params
     */
    public function post(string $url, array $params)
    {
        curl_setopt($this->client, CURLOPT_URL, $this->getUrl($url));
        curl_setopt($this->client, CURLOPT_POST, true);
        curl_setopt($this->client, CURLOPT_POSTFIELDS, json_encode($params));

        /** @var string $res */
        $res = curl_exec($this->client);

        if (curl_errno($this->client)) {
            $error_msg = curl_error($this->client);
            $status = curl_getinfo($this->client, CURLINFO_RESPONSE_CODE);
        }

        curl_close($this->client);

        if (isset($error_msg)) {
            throw new \Exception('Bannerbear Error Status: ' . $status . '. Message: ' . $error_msg);
        }

        return json_decode($res, true);
    }
}
