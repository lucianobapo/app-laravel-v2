<?php

namespace App\Repositories\Social;

use Guzzle\Http\Client;

use Illuminate\Support\Facades\Config;

class TwitterRepository {

    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client){
//        dd($client);
        $this->client = $client;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function search($query){
        //dd($this->client);
        $response = $this->client->get("search/tweets.json?q=".urlencode($query))->send();
        return array_fetch($response->json()['statuses'], 'text');
//        return $response->json();
    }
}