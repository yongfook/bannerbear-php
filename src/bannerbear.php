<?php

class Bannerbear
{
    private $apiKey;
    protected static $apiBase = 'https://api.bannerbear.com/v2';
    protected static $syncApiBase = 'https://sync.api.bannerbear.com/v2';
    protected $client;
    protected $syncClient;

    public function __construct(?string $apiKey)
    {
        $this->apiKey = $apiKey ? $apiKey : getenv('BANNERBEAR_API_KEY');

        $headers = ['Content-Type: application/json', 'Authorization: Bearer ' . $this->apiKey];
        $this->client = new Api(self::$apiBase, $headers);
        $this->syncClient = new Api(self::$syncApiBase, $headers);
    }

    public function account()
    {
        return $this->client->get('/account');
    }

    public function fonts()
    {
        return $this->client->get('/fonts');
    }
    public function effects()
    {
        return $this->client->get('/effects');
    }

    // =================================
    //            IMAGES
    // =================================

    public function get_image(string $uid)
    {
        return $this->client->get('/images/' . $uid);
    }

    public function list_images($page = NULL, $limit = NULL)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        if ($limit) array_push($queryString, 'limit=' . $limit);
        return $this->client->get('/images' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    public function create_image(string $uid, $params, $synchronous = FALSE)
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
    public function get_video(string $uid)
    {
        return $this->client->get('/videos/' . $uid);
    }

    public function list_videos($page = NULL)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->client->get('/videos' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    public function create_video(string $uid, $params)
    {
        $params['video_template'] = $uid;
        return $this->client->post('/videos', $params);
    }

    public function update_video(string $uid, $params)
    {
        $params['uid'] = $uid;
        return $this->client->patch('/videos', $params);
    }

    // =================================
    //            COLLECTIONS
    // =================================
    public function get_collection(string $uid)
    {
        return $this->client->get('/collections/' . $uid);
    }

    public function list_collections($page = NULL)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->client->get('/collections' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    public function create_collection(string $uid, $params, $synchronous = FALSE)
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
    public function get_screenshot(string $uid)
    {
        return $this->client->get('/screenshots/' . $uid);
    }

    public function list_screenshots($page = NULL)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->client->get('/screenshots' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    public function create_screenshot(string $url, $params, $synchronous = FALSE)
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
    public function get_animated_gif(string $uid)
    {
        return $this->client->get('/animated_gifs/' . $uid);
    }

    public function list_animated_gifs($page = NULL)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->client->get('/animated_gifs' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    public function create_animated_gif(string $uid, $params)
    {
        $params['template'] = $uid;
        return $this->client->post('/animated_gifs', $params);
    }

    // =================================
    //            MOVIES
    // =================================
    public function get_movie(string $uid)
    {
        return $this->client->get('/movies/' . $uid);
    }

    public function list_movies($page = NULL)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->client->get('/movies' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    public function create_movie($params)
    {
        return $this->client->post('/movies', $params);
    }

    // =================================
    //            TEMPLATES
    // =================================
    public function get_template(string $uid)
    {
        return $this->client->get('/templates/' . $uid);
    }

    public function list_templates($page = NULL, $limit = NULL, $tag = NULL, $name = NULL)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        if ($limit) array_push($queryString, 'limit=' . $limit);
        if ($tag) array_push($queryString, 'tag=' . $tag);
        if ($name) array_push($queryString, 'name=' . $name);
        return $this->client->get('/templates' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    public function update_template(string $uid, $params)
    {
        return $this->client->patch('/templates/' . $uid, $params);
    }

    // =================================
    //            VIDEO TEMPLATES
    // =================================
    public function get_video_template(string $uid)
    {
        return $this->client->get('/video_templates/' . $uid);
    }

    public function list_video_templates($page = NULL)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->client->get('/video_templates' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    // =================================
    //            TEMPLATE SETS
    // =================================
    public function get_template_set(string $uid)
    {
        return $this->client->get('/template_sets/' . $uid);
    }

    public function list_template_sets($page = NULL)
    {
        $queryString = array();
        if ($page) array_push($queryString, 'page=' . $page);
        return $this->client->get('/template_sets' . (count($queryString) > 0 ? '?' . implode('&', $queryString) : ''));
    }

    // =================================
    //            SIGNED URLS
    // =================================
    public function generate_signed_url($base_id, $params, $synchronous = FALSE)
    {
        $base = "https://" . ($synchronous ? 'cdn' : 'ondemand') . ".bannerbear.com/signedurl/" . $base_id . "/image.jpg";
        $query = "?modifications=" . rtrim(strtr(base64_encode(json_encode($params)), '+/', '-_'), '=');
        $signature = hash_hmac('sha256', $base . $query, $this->apiKey);

        return $base . $query . "&s=" . $signature;
    }
}

class Api
{
    private $client = null;
    protected $url = '';

    public function __construct($url, $headers = array())
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

    private function getUrl($url)
    {
        return $this->url . $url;
    }

    public function get($url)
    {
        curl_setopt($this->client, CURLOPT_URL, $this->getUrl($url));
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

    public function patch($url, $params)
    {
        curl_setopt($this->client, CURLOPT_URL, $this->getUrl($url));
        curl_setopt($this->client, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($this->client, CURLOPT_POSTFIELDS, json_encode($params));

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

    public function post($url, $params)
    {
        curl_setopt($this->client, CURLOPT_URL, $this->getUrl($url));
        curl_setopt($this->client, CURLOPT_POST, true);
        curl_setopt($this->client, CURLOPT_POSTFIELDS, json_encode($params));

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
