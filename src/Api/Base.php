<?php

namespace Netinternet\Ilkbyte\Api;

use GuzzleHttp\Client;

class Base {
    public function client()
    {
        return new Client([
            'base_uri' => $this->url(),
            'query' => [
                'access' => config('ilkbyte.access'),
                'secret' => config('ilkbyte.secret'),
            ],
        ]);
    }

    public function url()
    {
        return 'https://api.ilkbyte.com/';
    }

    public function request($url = null, $query = [], $method = 'GET')
    {
        $fullUrl = $this->url().$url;

        try {
            $response = $this->client()->request($method, $fullUrl, [
                'query' => array_merge($this->client()->getConfig('query'), $query),
            ]);

            return json_decode((string) $response->getBody());
        } catch (\Exception $e) {
            return [
                'status' => false,
                'response' => null,
                'message' => $e->getMessage()
            ];
        }

    }
}
