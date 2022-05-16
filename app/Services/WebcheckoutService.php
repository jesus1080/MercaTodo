<?php

namespace App\Services;

use App\Contracts\WebcheckoutContract;
use App\Request\CreateSessionRequest;
use App\Request\GetInformationRequest;
use GuzzleHttp\Client;

class WebcheckoutService implements WebcheckoutContract
{
    public Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getInformation(?int $session_id)
    {
        //dd($session_id);
        $getInformation = new GetInformationRequest();
        $data = $getInformation->auth();
        $url = $getInformation::url($session_id);

        return $this->request($data, $url);
    }
    public function createSession(array $data)
    {
        $createSessionRequest = new CreateSessionRequest($data);
        //dd($createSessionRequest);
        $data = $createSessionRequest->toArray();
        //dd($data);
        $url = $createSessionRequest::url(null);
        //dd($url);
        //dd($this->request($data,$url));
        return $this->request($data, $url);
    }
    private function request(array $data, string $url)
    {
        //dd($url);
        //dd($this->client);
        $response = $this->client->request('post', $url, [
            'json' => $data,
            'verify' => true,
        ]);
        //dd($response);
        $content = $response->getBody()->getContents();
        //dd(json_decode($content));
        return json_decode($content);
    }
}
