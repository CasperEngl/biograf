<?php

if (! function_exists('title_case')) {
    /**
     * Helper function for Str::plural
     *
     * @param string $string
     *
     * @return \Illuminate\Support\Str
     */
    function title_case(string $string)
    {
        return \Illuminate\Support\Str::title($string);
    }
}

if (! function_exists('plural')) {
    /**
     * Helper function for Str::plural
     *
     * @param string $string
     *
     * @return \Illuminate\Support\Str
     */
    function plural(string $string)
    {
        return \Illuminate\Support\Str::plural($string);
    }
}

if (! function_exists('console_log')) {
    function console_log($any)
    {
        dd($any);
    }
}

if (! function_exists('getNearestTimeRoundedUpWithMinimum')) {
    /**
     *
     * @param  \Carbon\Carbon $now
     * @param  int            $nearestMin
     * @param  int            $minimumMinutes
     * @return \Carbon\Carbon
     */
    function getNearestTimeRoundedUpWithMinimum($now, $nearestMin = 30, $minimumMinutes = 0)
    {
        $nearestSec = $nearestMin * 60;
        $minimumMoment = $now->addMinutes($minimumMinutes);
        $futureTimestamp = ceil($minimumMoment->timestamp / $nearestSec) * $nearestSec;
        $futureMoment = \Carbon\Carbon::createFromTimestamp($futureTimestamp);
        return $futureMoment->startOfMinute();
    }
}

if (! function_exists('generateSubsequentDates')) {
    /**
     * Generates a collection of dates following the start date up to the maximum count
     *
     * @param  \Carbon\Carbon $startDate
     * @param  int            $count
     * @return Illuminate\Support\Collection
     */
    function generateSubsequentDates($startDate, $count)
    {
        $dates = collect([]);
        
        for ($i = 0; $i < $count; $i++) {
            $dates->push($startDate->copy()->add($i, 'day'));
        }

        return $dates;
    }
}

if (! function_exists('str_slug')) {
    /**
     * Helper function for Str::slug
     *
     * @param string $string
     *
     * @return \Illuminate\Support\Str
     */
    function str_slug(string $str)
    {
        return \Illuminate\Support\Str::slug($str);
    }
}

if (! function_exists('tmdb')) {
    /**
     * Helper function for TMDB Client
     *
     * @return \Tmdb\Client
     */
    function tmdb()
    {
        return (new \App\Tmdb)->client;
    }
}
    
if (! function_exists('tmdb_repo')) {
    /**
     * Helper function for TMDB Movie Repository
     *
     * @return \Tmdb\Repository\MovieRepository
     */
    function tmdb_repo()
    {
        return (new \App\Tmdb)->repository();
    }
}
    
if (! function_exists('tmdb_image')) {
    /**
     * Helper function for TMDB Image Helper
     *
     * @return \Tmdb\Helper\ImageHelper
     */
    function tmdb_image()
    {
        return (new \App\Tmdb)->imageHelper();
    }
}

if (! function_exists('generate_barcode_image')) {
    /**
     * Generate barcode image encoded as base64
     * @param string $name
     * @param string $type
     * @param integer $w
     * @param integer $h
     * @return string
     */
    function generate_barcode_image(string $name, string $type, int $w, int $h): string
    {
        return 'data:image/png;base64,' . \DNS2D::getBarcodePNG(
            $name,
            $type,
            $w,
            $h,
        );
    }
}
