<?php

namespace App;

use Tmdb\Client;
use Tmdb\ApiToken;
use Tmdb\Helper\ImageHelper;
use Tmdb\Repository\MovieRepository;
use Tmdb\Repository\ConfigurationRepository;

/**
 * Helper class for TMDB
 *
 * The class takes in TMDB_API_KEY from env and exposes client,
 * movie repository and image helper from TMDB's API.
 */
class Tmdb
{
    public $client;

    private $apiToken;

    private $config;

    public function __construct()
    {
        $this->apiToken = new ApiToken(env('TMDB_API_KEY'));
        $this->client = new Client($this->apiToken);

        $configRepository = new ConfigurationRepository($this->client);
        
        $this->config = $configRepository->load();
    }

    public function repository()
    {
        return new MovieRepository($this->client);
    }

    public function imageHelper()
    {
        return new ImageHelper($this->config);
    }
}
