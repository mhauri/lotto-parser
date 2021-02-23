<?php


namespace LottoParser\Model;


use GuzzleHttp\Client;

class HttpClient
{
    /**
     * @param string $baseUrl
     *
     * @return Client
     */
    public static function create(string $baseUrl): Client
    {
        $headers = [
            'User-Agent' => 'LottoParser Client (https://github.com/mhauri/lotto-parser)',
            'Connection' => 'keep-alive',
            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
            'Accept' => 'text/plain, */*',
            'Accept-Encoding' => 'gzip, deflate',
            'Accept-Language' => 'en-US,en;q=0.8',
        ];

        return new Client(
            [
                'base_uri' => $baseUrl,
                'timeout' => 3.0,
                'headers' => $headers,
            ]
        );
    }
}