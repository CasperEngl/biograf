<?php

use App\Tmdb;
use Illuminate\Support\Str;

if (! function_exists('title_case')) {
    function title_case(string $string) {
        return Str::title($string);
    }
}

if (! function_exists('plural')) {
    function plural(string $string) {
        return Str::plural($string);
    }
}

if (! function_exists('tmdb')) {
    function tmdb() {
        return (new Tmdb)->client();
    }
}

if (! function_exists('tmdb_repo')) {
    function tmdb_repo() {
        return (new Tmdb)->repository();
    }
}

if (! function_exists('tmdb_image')) {
    function tmdb_image() {
        return (new Tmdb)->imageHelper();
    }
}

if (! function_exists('console_log')) {
    function console_log($any) {
        dd($any);
    }
}