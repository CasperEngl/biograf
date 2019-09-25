<?php

namespace App;

use Tmdb\Client;
use Tmdb\ApiToken;
use Tmdb\Repository\MovieRepository;

class Tmdb {
  public function __construct()
  {
    $this->apiToken = new ApiToken(env('TMDB_API_KEY'));
    $this->client = new Client($this->apiToken);
  }

  public function client()
  {
    return $this->client;
  }

  public function repository()
  {
    return new MovieRepository($this->client);
  }
}