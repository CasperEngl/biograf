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

if (! function_exists('tmdb')) {
    /**
     * Helper function for TMDB Client
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

if (! function_exists('console_log')) {
    function console_log($any)
    {
        dd($any);
    }
}
