<?php

namespace App\Console\Commands;

use App\Tmdb;
use Illuminate\Console\Command;

class ImportPopularMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:movies:popular';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import popular movies from TMDB';

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
        $this->comment('Importing movies...');

        $repo = $this->tmdb->repository();
        $movies = collect($repo->getPopular()->toArray());

        $movies->each(function ($movie) {
            (new \App\Actions\FilmActions)->import($movie, 'popular', true);
        });
        
        $this->comment('Import finished.');
    }
}
