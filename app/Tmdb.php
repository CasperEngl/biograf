<?php

namespace App;

use Tmdb\Client;
use Tmdb\ApiToken;
use Tmdb\Repository\MovieRepository;
use Tmdb\Repository\ConfigurationRepository;

class Tmdb
{
    public function __construct()
    {
        $this->apiToken = new ApiToken(env('TMDB_API_KEY'));
        $this->client = new Client($this->apiToken);

        $configRepository = new ConfigurationRepository($this->client);
        
        $this->config = $configRepository->load();
    }

    public function client()
    {
        return $this->client;
    }

    public function repository()
    {
        return new MovieRepository($this->client);
    }

    public function imageHelper()
    {
        return new \Tmdb\Helper\ImageHelper($this->config);
    }
}