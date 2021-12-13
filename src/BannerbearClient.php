<?php

namespace Bannerbear;


class BannerbearClient
{
    /** @var string */
    private $apiKey;
    /** @var string */
    protected static $apiBase = 'https://api.bannerbear.com/v2';
    /** @var string */
    protected static $syncApiBase = 'https://sync.api.bannerbear.com/v2';
    /** @var Api */
    protected $client;
    /** @var Api */
    protected $syncClient;

    public function __construct(?string $apiKey)
    {
        $this->apiKey = $apiKey ? $apiKey : (string)getenv('BANNERBEAR_API_KEY');

        $headers = ['Content-Type: application/json', 'Authorization: Bearer ' . $this->apiKey];
        $this->client = new Api(self::$apiBase, $headers);
        $this->syncClient = new Api(self::$syncApiBase, $headers);
    }

    public function account(): string
    {
        return $this->client->get('/account');
    }

    public function fonts(): string
    {
        return $this->client->get('/fonts');
    }
    public function effects(): string
    {
        return $this->client->get('/effects');
    }

    // =================================
    //            IMAGES
    // =================================

    public function get_image(string $uid): string
    {
        return $this->client->get('/images/' . $uid);
    }

    public function list_images(int $page = null, int $limit = null): string
    {
        $queryString = [];
        if ($page) array_push($queryString, 'page=' . $page);
        if ($limit) array_push($queryString, 'limit=' . $limit);
        return $this->client->get('/images' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    /**
     * @param array<string,mixed> $params
     */
    public function create_image(string $uid, array $params, bool $synchronous = false): string
    {
        $params['template'] = $uid;
        if ($synchronous) {
            return $this->syncClient->post('/images', $params);
        }
        return $this->client->post('/images', $params);
    }

    // =================================
    //            VIDEOS
    // =================================
    public function get_video(string $uid): string
    {
        return $this->client->get('/videos/' . $uid);
    }

    public function list_videos(int $page = null): string
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->client->get('/videos' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    /**
     * @param array<string,mixed> $params
     */
    public function create_video(string $uid, array $params): string
    {
        $params['video_template'] = $uid;
        return $this->client->post('/videos', $params);
    }

    /**
     * @param array<string,mixed> $params
     */
    public function update_video(string $uid, array $params): string
    {
        $params['uid'] = $uid;
        return $this->client->patch('/videos', $params);
    }

    // =================================
    //            COLLECTIONS
    // =================================
    public function get_collection(string $uid): string
    {
        return $this->client->get('/collections/' . $uid);
    }

    public function list_collections(int $page = null): string
    {
        $queryString = [];
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->client->get('/collections' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    /**
     * @param array<string,mixed> $params
     */
    public function create_collection(string $uid, array $params, bool $synchronous = false): string
    {
        $params['template_set'] = $uid;
        if ($synchronous) {
            return $this->syncClient->post('/collections', $params);
        }
        return $this->client->post('/collections', $params);
    }

    // =================================
    //            SCREENSHOTS
    // =================================
    public function get_screenshot(string $uid): string
    {
        return $this->client->get('/screenshots/' . $uid);
    }

    public function list_screenshots(int $page = null): string
    {
        $queryString = [];
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->client->get('/screenshots' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    /**
     * @param array<string,mixed> $params
     */
    public function create_screenshot(string $url, array $params, bool $synchronous = false): string
    {
        $params['url'] = $url;
        if ($synchronous) {
            return $this->syncClient->post('/screenshots', $params);
        }
        return $this->client->post('/screenshots', $params);
    }

    // =================================
    //            ANIMATED GIFS
    // =================================
    public function get_animated_gif(string $uid): string
    {
        return $this->client->get('/animated_gifs/' . $uid);
    }

    public function list_animated_gifs(int $page = null): string
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->client->get('/animated_gifs' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    /**
     * @param array<string,mixed> $params
     */
    public function create_animated_gif(string $uid, array $params): string
    {
        $params['template'] = $uid;
        return $this->client->post('/animated_gifs', $params);
    }

    // =================================
    //            MOVIES
    // =================================
    public function get_movie(string $uid): string
    {
        return $this->client->get('/movies/' . $uid);
    }

    public function list_movies(int $page = null): string
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->client->get('/movies' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    /**
     * @param array<string,mixed> $params
     */
    public function create_movie(array $params): string
    {
        return $this->client->post('/movies', $params);
    }

    // =================================
    //            TEMPLATES
    // =================================
    public function get_template(string $uid): string
    {
        return $this->client->get('/templates/' . $uid);
    }

    public function list_templates(int $page = null, int $limit = null, string $tag = null, string $name = null): string
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        if ($limit) array_push($queryString, 'limit=' . $limit);
        if ($tag) array_push($queryString, 'tag=' . $tag);
        if ($name) array_push($queryString, 'name=' . $name);
        return $this->client->get('/templates' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    /**
     * @param array<string,mixed> $params
     */
    public function update_template(string $uid, array $params): string
    {
        return $this->client->patch('/templates/' . $uid, $params);
    }

    // =================================
    //            VIDEO TEMPLATES
    // =================================
    public function get_video_template(string $uid): string
    {
        return $this->client->get('/video_templates/' . $uid);
    }

    public function list_video_templates(int $page = null): string
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->client->get('/video_templates' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    // =================================
    //            TEMPLATE SETS
    // =================================
    public function get_template_set(string $uid): string
    {
        return $this->client->get('/template_sets/' . $uid);
    }

    public function list_template_sets(int $page = null): string
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->client->get('/template_sets' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    // =================================
    //            SIGNED URLS
    // =================================
    /**
     * @param array<string,mixed> $params
     */
    public function generate_signed_url(string $base_id, array $params, bool $synchronous = false): string
    {
        $base = "https://" . ($synchronous ? 'cdn' : 'ondemand') . ".bannerbear.com/signedurl/" . $base_id . "/image.jpg";

        $jsonParams = json_encode($params);
        if (!is_string($jsonParams)) {
            throw new \Exception('invalid params');
        }
        $query = "?modifications=" . rtrim(strtr(base64_encode($jsonParams), '+/', '-_'), '=');
        $signature = hash_hmac('sha256', $base . $query, $this->apiKey);

        return $base . $query . "&s=" . $signature;
    }
}


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
            $status = curl_getinfo($this->client, CURLINFO_RESPONSE_CODE);
        }

        curl_close($this->client);

        if (isset($error_msg)) {
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
            $status = curl_getinfo($this->client, CURLINFO_RESPONSE_CODE);
        }

        curl_close($this->client);

        if (isset($error_msg)) {
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
            $status = curl_getinfo($this->client, CURLINFO_RESPONSE_CODE);
        }

        curl_close($this->client);

        if (isset($error_msg)) {
            throw new \Exception('Status: ' . $status . '. Message: ' . $error_msg);
        }

        return $res;
    }
}
