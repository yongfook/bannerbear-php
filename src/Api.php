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
    }

    private function getUrl(string $url): string
    {
        return $this->url . $url;
    }

    public function get(string $url): string
    {
        curl_setopt($this->client, CURLOPT_URL, $this->getUrl($url));

        /** @var string $res */
        $res = curl_exec($this->client);

        if (curl_errno($this->client)) {
            $error_msg = curl_error($this->client);
        }

        curl_close($this->client);

        if (isset($error_msg)) {
            $status = curl_getinfo($this->client, CURLINFO_RESPONSE_CODE);
            throw new \Exception('Status: ' . $status . '. Message: ' . $error_msg);
        }

        return $res;
    }

    /**
     * @param array<string,mixed> $params
     */
    public function patch(string $url, array $params): string
    {
        curl_setopt($this->client, CURLOPT_URL, $this->getUrl($url));
        curl_setopt($this->client, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($this->client, CURLOPT_POSTFIELDS, json_encode($params));

        /** @var string $res */
        $res = curl_exec($this->client);

        if (curl_errno($this->client)) {
            $error_msg = curl_error($this->client);
        }

        curl_close($this->client);

        if (isset($error_msg)) {
            $status = curl_getinfo($this->client, CURLINFO_RESPONSE_CODE);
            throw new \Exception('Status: ' . $status . '. Message: ' . $error_msg);
        }

        return $res;
    }

    /**
     * @param array<string,mixed> $params
     */
    public function post(string $url, array $params): string
    {
        curl_setopt($this->client, CURLOPT_URL, $this->getUrl($url));
        curl_setopt($this->client, CURLOPT_POST, true);
        curl_setopt($this->client, CURLOPT_POSTFIELDS, json_encode($params));

        /** @var string $res */
        $res = curl_exec($this->client);

        if (curl_errno($this->client)) {
            $error_msg = curl_error($this->client);
        }

        curl_close($this->client);

        if (isset($error_msg)) {
            $status = curl_getinfo($this->client, CURLINFO_RESPONSE_CODE);
            throw new \Exception('Status: ' . $status . '. Message: ' . $error_msg);
        }

        return $res;
    }
}
