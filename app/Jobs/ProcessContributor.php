<?php

namespace App\Jobs;

use App\Contributor;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Tmdb\Model\Collection\People\PersonInterface;

class ProcessContributor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $person;

    public $contributor;

    public $model;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PersonInterface $person, Contributor $contributor, $model)
    {
        $this->person = $person;
        $this->contributor = $contributor;
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->person->getProfilePath()) {
            $this->contributor
                ->addMediaFromUrl(
                    'http:' . tmdb_image()->getUrl(
                        tmdb()->getPeopleApi()->getPerson($this->contributor->tmdb_id)['profile_path']
                    )
                )
                ->toMediaCollection('profile');
        }
    }
}
