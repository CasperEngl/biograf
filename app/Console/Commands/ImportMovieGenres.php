<?php

namespace App\Console\Commands;

use App\Tmdb;
use Illuminate\Console\Command;

class ImportMovieGenres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:movies:genres';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import movie genres from TMDB';

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
        $this->comment('Importing movie genres...');

        $client = $this->tmdb->client;
        $genres = (object) $client->getGenresApi()->getGenres();
        $genres = collect($genres->genres);

        $genres
            ->map(
                function ($genre) {
                    return (object) $genre;
                }
            )->each(
                function ($genre) {
                    \App\Genre::updateOrCreate(
                        ['tmdb_genre_id' => $genre->id],
                        ['name' => $genre->name]
                    );
                }
            );

        $this->comment('Import finished.');
    }
}
