<?php

namespace App\Jobs;

use App\Film;
use Illuminate\Bus\Queueable;
use League\ColorExtractor\Color;
use League\ColorExtractor\Palette;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use League\ColorExtractor\ColorExtractor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessFilmPoster implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $film;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Film $film)
    {
        $this->film = $film;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $film = $this->film;

        $palette = Palette::fromFilename(
            env('MEDIA_DISK') === 'public'
                ? public_path($film->getFirstMediaUrl('poster'))
                : $film->getFirstMediaUrl('poster')
        );

        $extractor = new ColorExtractor($palette);

        $film->colors = collect([]);

        collect($extractor->extract(3))
            ->sort()
            ->reverse()
            ->each(
                function ($color) use ($film) {
                    $color = Color::fromIntToHex($color);
                    $colors = $film->colors ?? collect([]);
    
                    $film->colors = $colors->merge([$color]);
                }
            );

        $film->save();
    }
}
