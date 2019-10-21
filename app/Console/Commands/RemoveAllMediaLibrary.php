<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\MediaLibrary\Models\Media;

class RemoveAllMediaLibrary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medialibrary:removeall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all media from media library';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Media $media)
    {
        parent::__construct();

        $this->media = $media;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->comment('Starting to remove all files');

            $this->media->all()->each(function ($media) {
                $this->comment(
                    'Deleting '
                    . $media->getKey()
                    . ' '
                    . $media->file_name
                    . ' ('
                    . $media->model_type
                    . '<'
                    . $media->collection_name
                    . '>'
                    . ')'
                );

                $media->forceDelete();
            });

            $this->comment('All files removed successfully');
        } catch (Exception $e) {
            $this->comment('Something went wrong.');
            dd($e);
        }
    }
}
