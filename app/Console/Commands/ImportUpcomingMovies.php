<?php

namespace App\Console\Commands;

use App\Tmdb;
use Illuminate\Console\Command;

class ImportUpcomingMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:movies:upcoming';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import upcoming movies from TMDB';

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
        $movies = collect($repo->getUpcoming()->toArray());

        $movies->each(function ($movie) {
            (new \App\Actions\FilmActions)->import($movie, 'upcoming', true);
        });
        
        $this->comment('Import finished.');
    }
}
