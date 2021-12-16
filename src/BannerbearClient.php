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

    public function __construct(?string $apiKey)
    {
        $this->apiKey = $apiKey ? $apiKey : (string)getenv('BANNERBEAR_API_KEY');

        $headers = ['Content-Type: application/json', 'Authorization: Bearer ' . $this->apiKey];
    }

    public function factory()
    {
        $headers = ['Content-Type: application/json', 'Authorization: Bearer ' . $this->apiKey];
        $client = new Api(self::$apiBase, $headers);
        return $client;
    }


    public function factorySync()
    {
        $headers = ['Content-Type: application/json', 'Authorization: Bearer ' . $this->apiKey];
        $client = new Api(self::$syncApiBase, $headers);
        return $client;
    }

    public function account()
    {
        return $this->factory()->get('/account');
    }

    public function fonts()
    {
        return $this->factory()->get('/fonts');
    }
    public function effects()
    {
        return $this->factory()->get('/effects');
    }

    // =================================
    //            IMAGES
    // =================================

    public function get_image(string $uid)
    {
        return $this->factory()->get('/images/' . $uid);
    }

    public function list_images(int $page = null, int $limit = null)
    {
        $queryString = [];
        if ($page) array_push($queryString, 'page=' . $page);
        if ($limit) array_push($queryString, 'limit=' . $limit);
        return $this->factory()->get('/images' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    /**
     * @param array<string,mixed> $params
     */
    public function create_image(string $uid, array $params, bool $synchronous = false)
    {
        $params['template'] = $uid;
        if ($synchronous) {
            return $this->factorySync()->post('/images', $params);
        }
        return $this->factory()->post('/images', $params);
    }

    // =================================
    //            VIDEOS
    // =================================
    public function get_video(string $uid)
    {
        return $this->factory()->get('/videos/' . $uid);
    }

    public function list_videos(int $page = null)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->factory()->get('/videos' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    /**
     * @param array<string,mixed> $params
     */
    public function create_video(string $uid, array $params)
    {
        $params['video_template'] = $uid;
        return $this->factory()->post('/videos', $params);
    }

    /**
     * @param array<string,mixed> $params
     */
    public function update_video(string $uid, array $params)
    {
        $params['uid'] = $uid;
        return $this->factory()->patch('/videos', $params);
    }

    // =================================
    //            COLLECTIONS
    // =================================
    public function get_collection(string $uid)
    {
        return $this->factory()->get('/collections/' . $uid);
    }

    public function list_collections(int $page = null)
    {
        $queryString = [];
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->factory()->get('/collections' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    /**
     * @param array<string,mixed> $params
     */
    public function create_collection(string $uid, array $params, bool $synchronous = false)
    {
        $params['template_set'] = $uid;
        if ($synchronous) {
            return $this->factorySync()->post('/collections', $params);
        }
        return $this->factory()->post('/collections', $params);
    }

    // =================================
    //            SCREENSHOTS
    // =================================
    public function get_screenshot(string $uid)
    {
        return $this->factory()->get('/screenshots/' . $uid);
    }

    public function list_screenshots(int $page = null)
    {
        $queryString = [];
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->factory()->get('/screenshots' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    /**
     * @param array<string,mixed> $params
     */
    public function create_screenshot(string $url, array $params, bool $synchronous = false)
    {
        $params['url'] = $url;
        if ($synchronous) {
            return $this->factorySync()->post('/screenshots', $params);
        }
        return $this->factory()->post('/screenshots', $params);
    }

    // =================================
    //            ANIMATED GIFS
    // =================================
    public function get_animated_gif(string $uid)
    {
        return $this->factory()->get('/animated_gifs/' . $uid);
    }

    public function list_animated_gifs(int $page = null)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->factory()->get('/animated_gifs' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    /**
     * @param array<string,mixed> $params
     */
    public function create_animated_gif(string $uid, array $params)
    {
        $params['template'] = $uid;
        return $this->factory()->post('/animated_gifs', $params);
    }

    // =================================
    //            MOVIES
    // =================================
    public function get_movie(string $uid)
    {
        return $this->factory()->get('/movies/' . $uid);
    }

    public function list_movies(int $page = null)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->factory()->get('/movies' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    /**
     * @param array<string,mixed> $params
     */
    public function create_movie(array $params)
    {
        return $this->factory()->post('/movies', $params);
    }

    // =================================
    //            TEMPLATES
    // =================================
    public function get_template(string $uid)
    {
        return $this->factory()->get('/templates/' . $uid);
    }

    public function list_templates(int $page = null, int $limit = null, string $tag = null, string $name = null)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        if ($limit) array_push($queryString, 'limit=' . $limit);
        if ($tag) array_push($queryString, 'tag=' . $tag);
        if ($name) array_push($queryString, 'name=' . $name);
        return $this->factory()->get('/templates' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    /**
     * @param array<string,mixed> $params
     */
    public function update_template(string $uid, array $params)
    {
        return $this->factory()->patch('/templates/' . $uid, $params);
    }

    // =================================
    //            VIDEO TEMPLATES
    // =================================
    public function get_video_template(string $uid)
    {
        return $this->factory()->get('/video_templates/' . $uid);
    }

    public function list_video_templates(int $page = null)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->factory()->get('/video_templates' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    // =================================
    //            TEMPLATE SETS
    // =================================
    public function get_template_set(string $uid)
    {
        return $this->factory()->get('/template_sets/' . $uid);
    }

    public function list_template_sets(int $page = null)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->factory()->get('/template_sets' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
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
