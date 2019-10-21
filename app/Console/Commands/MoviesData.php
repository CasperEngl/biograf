<?php

namespace App\Console\Commands;

use App\Tmdb;
use Illuminate\Console\Command;

class MoviesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movies:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get movie data from TMDB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Tmdb $tmdb)
    {
        parent::__construct();

        $this->tmdb = $tmdb;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Getting movies data...');

        $repo = $this->tmdb->repository();
        $films = $repo->getPopular()->toArray();

        dd($films);
        
        $this->comment('Finished.');
    }
}
