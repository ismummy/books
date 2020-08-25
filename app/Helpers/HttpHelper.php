<?php


namespace App\Helpers;


use GuzzleHttp\Client;

class HttpHelper
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getBook($id)
    {
        return $this->request('/books/' . $id);
    }

    public function getCharacter($id)
    {
        return $this->request('/characters/' . $id);
    }

    private function request($url)
    {
        try {
            $response = $this->client->request('GET', $url);
        } catch (\Exception $e) {
            return [];
        }

        return $this->response($response->getBody()->getContents());
    }

    private function response($response)
    {
        if ($response) {
            return json_decode($response);
        }
        return [];
    }

}
